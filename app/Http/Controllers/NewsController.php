<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\Category;
use Validator;
use Illuminate\Support\Facades\Auth;
class NewsController extends Controller
{
    public function get($id = null) {
        if($id){
            $news = News::with('category')->find($id);
            return response()->json([
                'statusCode' => 200,
                'message' => 'success',
                'data' => $news
            ]);
        }

        $news = News::with('category')->get();
        return response()->json([
            'statusCode' => 200,
            'message' => 'success',
            'data' => $news
        ]);
    }

    public function store (Request $request) {

        $statusCode = 201;
        $message = 'success';
        $error = null;
        $data = null;

        $validatorRequest = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'category_id' => 'required|numeric'
        ]);

        if($validatorRequest-> fails()){
            $message ="Bad Request";
            $statusCode = 400;
            $errors = [];

            $errors = $validatorRequest->errors();
            foreach($errors->all() as $message){
                array_push($error, $message);
            }
        }else{
            $category = Category::find($request->input('category_id'));
            if($category){
                $user = Auth::user();
                $news = new News;
                $news->title = $request->input('title');
                $news->content = $request->input('content');
                $news->category_id = $request->input('category_id');
                $news->author = $user->id;
                if ($news->save()){
                    $data = $news;
                }else{
                    $statusCode = 400;
                    $message = "Bad Request";
                }
            }else {
                    $statusCode = 400;
                    $message = "Bad Request";
            }
           
        }

        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);

    }

    public function update($id , Request $request){
       
        $statusCode = 201;
        $message = 'success';
        $error = null;
        $data = null;

        if($id){
            
           $news = News::find($id);
                if($news){
                    $news->title = $request->input('title', $news->title);
                    $news->content = $request->input('content', $news->content);
                    $news->category_id = $request->input('category_id', $news->category_id);
                    if ($news->save()){
                        $data = $news;
                    }else{
                        $statusCode = 400;
                        $message = "Bad Request";
                    }
                } else{
                         $statusCode = 400;
                        $message = "Bad Request";
                    }
               
            
        }else{
            // bad request
            $message = "Bad Request";
            $statusCode= 400;
                }

        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);

    }

    public function delete ($id){
        $statusCode = 201;
        $message = 'success';
        $error = null;
        $data = null;

        if($id){
            $news = News::find($id);
            if($news){
                if(!$news->delete()){
                    $message = " Bad Request";
                    $statusCode = 400;
        
                }
            }else {
                $message = " Bad Request";
                $statusCode = 400;
            }

        }else{
            $message = " Bad Request";
            $statusCode = 400;

        }
        return response()->json([
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => $error
        ], $statusCode);

    }
}
