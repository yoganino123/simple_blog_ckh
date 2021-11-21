<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Validator;

class CategoryController extends Controller
{
    public function get($id = null) {
        if($id) {
            $category = Category::find($id);
            return response()->json([
                'statusCode' => 200,
                'message' => 'success',
                'data' => $category
            ]);
        }
        $categories = Category::all();
        return  response()->json([
            'statusCode' => 200,
            'message' => 'success',
            'data' => $categories
        ]);
    }

    public function store(Request $request) {
        //validasi data yang diterima oleh function ini
        // insert data
        $statusCode = 201;
        $error = null;
        $data = null;
        $message = 'success';

        $validatorRequest = Validator::make($request->all(),[
            'name' => 'required|min:3'
        ]);

        if($validatorRequest->fails()){
            //gagal
            $error = [];
            $statusCode = 400;
            $message = " Bad Request ";
            $errors = $validatorRequest->errors();
            foreach($errors->all() as $message){
                array_push($error, $message);

            }
        }else{
            // berhasil
            $category = new Category;
            $category->name =$request->input('name');
            if($category->save()) {
                $data = $category;
            }else{
                $statusCode = 400;
                $message = " Bad Request ";
            }

        }
        return response()->json([
            'statusCode'=> $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);
    }

    public function update($id , Request $request){
        $statusCode = 201;
        $error = null;
        $data = null;
        $message = 'success';

        if($id) {
            $validatorRequest = Validator::make($request->all(),[
                'name' => 'required|min:3'
            ]);
    
            if($validatorRequest->fails()){
                //gagal
                $error = [];
                $statusCode = 400;
                $message = " Bad Request ";
                $errors = $validatorRequest->errors();
                foreach($errors->all() as $message){
                    array_push($error, $message);
                }
            }else{ 
                $category = Category::find($id);
                if($category) {
                    $category->name = $request->input('name');
                    if($category->save()){
                        $statusCode = 200;
                        $data = $category;
                    }else {
                        $message = "Bad Request";   
                        $statusCode = 400;
                    }

                   
                } else  {
                    $message = "Bad Request";   
                    $statusCode = 400;
                }
            }
        } else {
            $message = "Bad Request";
            $statusCode = 400;
        }
        return response()->json([
            'statusCode'=> $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);

    }
       
    public function delete($id) {
        $statusCode = 200;
        $error = null ;
        $data = null;
        $message = 'succes';

        if($id){
            $category = Category::find($id);
            if($category){
                if(!$category->delete()){
                    $message = "Bad Request";
                    $statusCode = 400;
                }
            } else {
                $message = "Bad Request";
                $statusCode = 400;
            }
        } else{
            $message = "Bad Request";
            $statusCode = 400;
        }

        return response()->json([
            'statusCode'=> $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);
    }

    

}
