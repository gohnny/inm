<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tasks;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;

class TaskController extends BaseController
{
    public function index()
    {
        $products = Tasks::all();
        return $this->sendResponse($products->toArray(), 'Все задачи получены успешно.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required|text',
            'description' => 'required|text',
            'status_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = Product::create($input);
        return $this->sendResponse($product->toArray(), 'Product created successfully.');
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse($product->toArray(), 'Product retrieved successfully.');
    }

    public function update(Request $request, Product $product)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'detail' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product->name = $input['name'];
        $product->detail = $input['detail'];
        $product->save();
        return $this->sendResponse($product->toArray(), 'Product updated successfully.');
    }

    public function destroy(Tasks $tasks)
    {
        $tasks->delete();
        return $this->sendResponse($tasks->toArray(), 'Product deleted successfully.');
    }


}
