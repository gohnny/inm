<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = User::paginate(10);

        return $this->sendResponse($user->toArray(),'Users list get success');
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

         $user = User::find($id);

         if (is_null($user)){
             return $this->sendError('Not found');
         }

        return $this->sendResponse($user->toArray(),'User get success');
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
       $user = User::findOrFail($id);

        if (is_null($user)){
            return $this->sendError('Not found');
        }

        $input = $request->all();
       // return $input;
        $validator = Validator::make($input, [
            'first_name' => 'required|min:4|max:15',
            'last_name' => 'required',
            'email' => 'required|email'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->email = $input['email'];
        $user->save();
        return $this->sendResponse($user->toArray(), 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function destroy(User $user)
    {
       $user->delete();

        return $this->sendResponse($user->toArray(),'User delete');
    }
}
