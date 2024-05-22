<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use function redirect;

class CommentController extends Controller
{

    use AuthorizesRequests;

    /**
     * Constructs an instance of the CommentController class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Comment::class);
    }


    /**
     * Store a newly created comment in storage.
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate(
            ['body' => ['required', 'string', 'min:3', 'max:2500']]
        );

        Comment::create([
            ...$data,
            'post_id' => $post->id,
            'user_id' => $request->user()->id,
        ]);

        return redirect($post->showRoute())
            ->banner('Your comment has been posted.');
    }

    /**
     * Update the specified comment in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(Request $request, Comment $comment): RedirectResponse
    {
        $data = $request->validate(
            ['body' => ['required', 'string', 'min:3', 'max:2500']]
        );

        $comment->update($data);

        return redirect(
            $comment->post->showRoute(['page' => $request->query('page')])
        )
            ->with('flash', [
                'bannerStyle' => 'success',
                'banner' => 'Your comment has been updated.',
                'delay' => 5000
            ]);
    }

    /**
     * Remove the specified comment from storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(
        Request $request,
        Comment $comment
    ): RedirectResponse {
        $comment->delete();

        return redirect(
            $comment->post->showRoute(['page' => $request->query('page')])
        )
            ->banner('Your comment has been deleted.');
    }
}
