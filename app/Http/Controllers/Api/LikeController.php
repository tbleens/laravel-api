<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beat;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likePost($id){

        $post = Post::findOrFail($id);

        $like = new Like;
        $like->user_id=Auth::id();
        $post->like()->save($like);

        return response()->json([
            'status' => true,
            'message' => 'likes successful add',
            'posts' => $post->like
        ]);

    }

    public function likeBeat($id){

        $beat = Post::findOrFail($id);

        $like = new Like;
        $like->user_id=Auth::id();
        $beat->like()->save($like);

        return response()->json([
            'status' => true,
            'message' => 'likes successful add',
            'posts' => $beat->like
        ]);
        
    }
}
