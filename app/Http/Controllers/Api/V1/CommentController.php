<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $comment;

    public function __construct(CommentRepository $comment)
    {
        $this->comment = $comment;
    }

    public function store(CommentRequest $request)
    {
        $form = $request->validated();

        $this->comment->setErrors([]);

        $form["user_id"] = Auth::id();

        $comment = $this->comment->create($form);

        if(!empty($this->comment->errors()))
        {
            return response()->json([
                'success' => false,
                'message' => $this->comment->errors(),
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => "comments created successfully",
            'data' => $comment
        ]);
    }

}
