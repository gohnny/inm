<?php

namespace App\Http\Controllers\API;

use App\Models\Tasks;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input["created_by_user_id"] = Auth::id();
        $task = Tasks::create($input);
        return $this->sendResponse($task->toArray(), 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);
        if (is_null($task)) {
            return $this->sendError('Not found');
        }
        $input = $request->all();
        $validator = Validator::make($input, [
            'status_id' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task->status_id = $input['status_id'];
        $task->save();
        return $this->sendResponse($task->toArray(), 'Task  status updated successfully.');
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function changeAssignUser(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);
        if (is_null($task)) {
            return $this->sendError('Not found');
        }
        $input = $request->all();
        $usersId = User::all()->except(Auth::id())->pluck('user_id');
        $validator = Validator::make($input, [
            'assign_user_id' => 'required|in:' . $usersId->implode(',')
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task->assign_user_id = $input['assign_user_id'];
        $task->save();
        return $this->sendResponse($task->toArray(), 'Task  status updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        if (is_null($task)) {
            return $this->sendError('Not found');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required|in:1,2,3'
        ]);
        $input["created_by_user_id"] = Auth::id();
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $task->title = $input['title'];
        $task->description = $input['description'];
        $task->status_id = $input['status_id'];
        $task->created_by_user_id = $input['created_by_user_id'];
        $task->save();
        return $this->sendResponse($task->toArray(), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     * @param Tasks $task
     * @return JsonResponse
     *
     */
    public function destroy(Tasks $task): JsonResponse
    {
        $task->delete();

        return $this->sendResponse($task->toArray(), 'Task deleted');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filter(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status_id' => 'required|in:1,2,3'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error value must be 1/2/3 ', $validator->errors());
        }
        $status_id = $input['status_id'];
        $filterByStatus = Tasks::where('status_id', '=', "$status_id")->with('status')->get();

        return $this->sendResponse($filterByStatus->toArray(), 'Task filtered by ""');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function order(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'order' => 'required|in:asc,desc'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error value must be asc|desc', $validator->errors());
        }
        $order = $input['order'];
        $orderByUser = Tasks::with(['createByUser' => function ($q) use ($order) {
            $q->orderBy('created_at', "$order");
        }])->get();

        return $this->sendResponse($orderByUser->toArray(), 'Task filtered by ""');
    }


}
