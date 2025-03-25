<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\TasksRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Http\Resources\TasksResource;
use App\Interfaces\TasksRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TasksController extends Controller
{
    private const STATUS_NEW = 'new';
    private const STATUS_UPDATED = 'updated';

    /**
     * @param TasksRepositoryInterface $tasksRepository
     */
    public function __construct(
        private readonly TasksRepositoryInterface $tasksRepository,
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $data = $this->tasksRepository->getList();

        return ApiResponseClass::sendResponse(TasksResource::collection($data), '', 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TasksRequest $request
     *
     * @return JsonResponse
     */
    public function store(TasksRequest $request): JsonResponse
    {
        $details = $request->validated();
        DB::beginTransaction();
        try {
            $details['status'] = self::STATUS_NEW;
            $task = $this->tasksRepository->store($details);

            DB::commit();
            return ApiResponseClass::sendResponse(new TasksResource($task), 'Task Create Successful', 201);

        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $task = $this->tasksRepository->getById($id);

        return ApiResponseClass::sendResponse(new TasksResource($task), '', 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTasksRequest $request
     * @param string $id
     *
     * @return JsonResponse
     */
    public function update(UpdateTasksRequest $request, string $id): JsonResponse
    {
        $updateDetails = $request->validated();
        DB::beginTransaction();
        try {
            $updateDetails['status'] = self::STATUS_UPDATED;
            $task = $this->tasksRepository->update($updateDetails, $id);

            DB::commit();
            return ApiResponseClass::sendResponse(new TasksResource($task), 'Task Updated Successful', 201);

        } catch (\Exception $ex) {
            ApiResponseClass::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return JsonResponse
     */
    public function destroy(string $id): JsonResponse
    {
        $this->tasksRepository->delete($id);

        return ApiResponseClass::sendResponse('Task Delete Successful', '', 204);
    }
}
