<?php

namespace App\Repositories;

use App\Exceptions\User\Action\FailedToSaveException;
use App\Http\Resources\ActionResource;
use App\Models\Custom\DTO\CreateUserActionDTO;
use App\Models\Custom\UserAction;
use Illuminate\Contracts\Filesystem\Filesystem;
use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Log;

class UserActionJsonRepository extends FileRepository implements UserActionRepository
{
    const PATH = 'actions/user_action.json';

    protected $date;

    public function __construct(Filesystem $filesystem)
    {
        $this->date = date('Y-m-d');
        $this->path = static::PATH . '_' . $this->date;
        $this->filesystem = $filesystem;
    }

    /**
     * @throws FailedToSaveException
     */
    public function save(CreateUserActionDTO $dto): UserAction
    {
        $data = $dto->get();
        $data['date_created'] = now();
        $action = UserAction::makeFromArray($data);

        try {
            $this->put($action);
            return $action;
        } catch (\Exception $e) {
            Log::alert('Could not save user actions ' . $data['date_created']);
        }

        throw new FailedToSaveException('Failed to save action to json');
    }

    protected function getFileAsArray(): array
    {
        return $this->fileExists()
            ? json_decode($this->filesystem->get($this->path), true)['actions']
            : [];
    }

    protected function put(UserAction $action): void
    {
        $actions = $this->getFileAsArray();
        $actions[] = $action->__serialize();
        $data = [
            'actions' => $actions
        ];

        $this->filesystem->put(static::PATH, json_encode($data));
    }
}
