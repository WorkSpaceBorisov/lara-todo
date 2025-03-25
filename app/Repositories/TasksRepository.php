<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Interfaces\TasksRepositoryInterface;
use App\Models\Tasks;
use Illuminate\Database\Eloquent\Collection;

class TasksRepository implements TasksRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getList(): Collection
    {
        return Tasks::all();
    }

    /**
     * @param $id
     *
     * @return Tasks
     */
    public function getById($id): Tasks
    {
        return Tasks::findOrFail($id);
    }

    /**
     * @param array $data
     *
     * @return Tasks
     */
    public function store(array $data): Tasks
    {
        return Tasks::create($data);
    }

    /**
     * @param array $data
     * @param $id
     *
     * @return Tasks
     */
    public function update(array $data, $id): Tasks
    {
        $model = Tasks::find($id);
        $model->update($data);

        return $model->fresh();
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool
    {
        return (bool)Tasks::destroy($id);
    }
}
