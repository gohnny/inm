<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $filterByStatus = Tasks::whereHas('status',function ($query){
            $query->where('status.status','=','View');
            })->with('status')
            ->get();//три возможных статуса: ["View", "In Progress", "Done"]

//        $orderByUser = Tasks::with(['createByUser' => function ($q) {
//            $q->orderBy('created_at', 'asc/desc');
//        }])->get();// Отсортировав по новым/старым пользователям

        return $this->sendResponse($filterByStatus->toArray(),'Users list get success');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required|in:1,2,3'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $input["created_by_user_id"] = Auth::id();
        $task = Tasks::create($input);
        return $this->sendResponse($task->toArray(), 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        if (is_null($task)){
            return $this->sendError('Not found');
        }

        $input = $request->all();


        $validator = Validator::make($input, [
            'status_id' => 'required|in:1,2,3'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $task->status_id = $input['status_id'];

        $task->save();
        return $this->sendResponse($task->toArray(), 'Task  status updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $task = Tasks::findOrFail($id);

        if (is_null($task)){
            return $this->sendError('Not found');
        }

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
            'status_id' => 'required|in:1,2,3'
        ]);
        $input["created_by_user_id"] = Auth::id();
       // return $input;

        if($validator->fails()){
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
     *
     * @param Tasks $task
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Tasks $task): \Illuminate\Http\JsonResponse
    {
        $task->delete();

        return $this->sendResponse($task->toArray(),'Task deleted');
    }
}
