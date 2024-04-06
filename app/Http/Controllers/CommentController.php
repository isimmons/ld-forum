<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{

    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }


    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request, Post $post)
    {
        $data = $request->validate(['body' => ['required', 'string', 'min:3', 'max:2500']]);

        Comment::create([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return to_route('posts.show', $post);
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {

        $data = $request->validate(['body' => ['required', 'string', 'min:3', 'max:2500']]);

        $comment->update($data);

        return to_route('posts.show', [ 'post' => $comment->post_id, 'page' => $request->query('page') ]);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        $comment->delete();

        return to_route('posts.show', ['post' => $comment->post_id, 'page' => $request->query('page')]);
    }
}
