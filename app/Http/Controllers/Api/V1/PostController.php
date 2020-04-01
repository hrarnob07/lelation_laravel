<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostResponse;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Array_;

class PostController extends Controller
{
    protected $post ;
    public function __construct(PostRepository $post){
        $this->post = $post;

    }
    public function store(PostResponse $request){
      Try{
          $from = $request->validated();
          $user = Auth::user();
          $posts = $user->posts()->create($from);
          if(!empty($from["attachment"]))
          {
              $data = [];
              for($index = 0 ; $index<count($from["attachment"]) ; $index++)
              {
                  $data[$index]=[
                      'url' => $from["attachment"][$index]
                  ];
              }
             $posts = $posts->images()->createMany($data);

          }

          if(!empty($this->post->errors())){
              return response()->json([
                  'success'=> false,
                  'message'=> $this->post->errors()
              ]);
          }

          return response()->json([
              'success'=>true,
              'message'=> 'post create successfully',
              'data'=> $posts
          ]);
      }
      catch (\Throwable $exception)
      {
          return response()->json([
              'success'=> false,
              'message'=> $exception->getMessage()
          ]);
      }

    }


}
