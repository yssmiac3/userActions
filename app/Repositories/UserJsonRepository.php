<?php

namespace App\Repositories;

use App\Exceptions\User\Repository\FailedToSaveException;
use App\Exceptions\User\Repository\NoSuitableSearchFieldsException;
use App\Exceptions\User\Repository\UserAlreadyExistsException;
use App\Exceptions\User\Repository\UsersNotFoundException;
use App\Models\Custom\DTO\CreateUserDTO;
use App\Models\Custom\User;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserJsonRepository extends FileRepository implements UserRepository
{
    const PATH = 'users.json';

    protected User $user;

    public function __construct(
        Filesystem $filesystem)
    {
        $this->path = static::PATH;
        $this->filesystem = $filesystem;
    }


    /**
     * @throws FailedToSaveException
     * @throws UserAlreadyExistsException
     */
    public function save(CreateUserDTO $dto): User
    {
        if ($this->exists('nickname', $dto->getNickname()))
            throw new UserAlreadyExistsException(
                'User with nickname ' . $dto->getNickname() . ' already exists!'
            );

        $data = $dto->get();
        $data['id'] = Str::uuid();
        $user = User::makeFromArray($data);

        try {
            $this->put($user);
            return $user;
        } catch (\Exception $e) {
            Log::alert('Could not save user' . now());
        }

        throw new FailedToSaveException('Failed to save user to json');
    }

    /**
     * @throws UsersNotFoundException
     * @throws NoSuitableSearchFieldsException
     */
    public function fetch(array $givenSearchFields): User
    {
        if (!$this->fileExists()) {
            throw new UsersNotFoundException('No users found');
        }

        if (empty($givenSearchFields)) {
            throw new NoSuitableSearchFieldsException('No search fields provided');
        }

        $availableSearchFields = User::$searchFields;
        if (
            empty($searchFields = array_intersect($availableSearchFields, array_keys($givenSearchFields)))
        ) {
            throw new NoSuitableSearchFieldsException(
                'You can`t search by this fields'
            );
        }

        foreach ($searchFields as $field) {
            $searchData[$field] = $givenSearchFields[$field];
        }

        $users = $this->getFileAsArray();
        foreach ($users as $user) {
            foreach ($searchData as $key => $value) {
                if ($user[$key] != $value)
                    continue 2;
            }

            return User::makeFromArray($user);
        }

        throw new UsersNotFoundException('Such user was not found');

    }

    /**
     */
    public function exists(string $field, string $value): bool
    {
        if (!$this->fileExists()) {
            return false;
        }

        $users = $this->getFileAsArray();

        foreach ($users as $user) {
            if ($user[$field] == $value)
                return true;
        }

        return false;
    }

    /**
     * @throws UsersNotFoundException
     */
    public function checkCredentials(string $nickname, string $password): User
    {
        if (!$this->fileExists()) {
            throw new UsersNotFoundException('No users found');
        }

        $users = $this->getFileAsArray();

        foreach ($users as $user) {
            if ($user['nickname'] == $nickname && $user['password'] == $password)
                return User::makeFromArray($user);
        }

        throw new UsersNotFoundException('Wrong credentials');
    }

    protected function fileExists(): bool
    {
        return $this->filesystem->exists(static::PATH);
    }

    protected function getFileAsArray(): array
    {
        return $this->fileExists()
            ? json_decode($this->filesystem->get(static::PATH), true)['users']
            : [];
    }

    protected function put(User $user): void
    {
        $users = $this->getFileAsArray();
        $users[] = $user->__serialize();
        $data = [
            'users' => $users
        ];

        $this->filesystem->put(static::PATH, json_encode($data));
    }
}
