<?php
declare(strict_types=1);

namespace App\Interfaces;

use App\Models\Tasks;
use Illuminate\Database\Eloquent\Collection;

interface TasksRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getList(): Collection;

    /**
     * @param $id
     *
     * @return Tasks
     */
    public function getById($id): Tasks;

    /**
     * @param array $data
     *
     * @return Tasks
     */
    public function store(array $data): Tasks;

    /**
     * @param array $data
     * @param $id
     *
     * @return Tasks
     */
    public function update(array $data, $id): Tasks;

    /**
     * @param $id
     *
     * @return bool
     */
    public function delete($id): bool;
}
