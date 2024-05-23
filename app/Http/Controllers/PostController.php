<?php

namespace App\Http\Controllers;

use App\Http\Resources\{CommentResource, PostResource, TopicResource};
use App\Models\{Post, Topic};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Inertia\Response;
use Inertia\ResponseFactory;

class PostController extends Controller
{
    use AuthorizesRequests;

    /**
     * Construct an instance of PostController.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Post::class);
    }

    /**
     * Display a listing of the posts.
     *
     * @param Topic|null $topic
     * @return Response|ResponseFactory
     */
    public function index(Topic $topic = null): Response|ResponseFactory
    {
        $posts = Post::with(['user', 'topic'])
            ->when($topic, fn(Builder $query) => $query->whereBelongsTo($topic))
            ->latest()
            ->latest('id')
            ->paginate();



        return inertia('Posts/Index', [
            'posts' => PostResource::collection($posts),
            'topics' => fn() => TopicResource::collection(Topic::all()),
            'selectedTopic' => fn() => $topic ? TopicResource::make(
                $topic
            ) : null,
        ]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Response|ResponseFactory
     */
    public function create()
    {
        return inertia('Posts/Create', [
            'topics' => TopicResource::collection(Topic::all()),
        ]);
    }

    /**
     * Store a newly created post in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'min:10', 'max:120'],
            'topic_id' => ['required', 'numeric', 'exists:topics,id'],
            'body' => ['required', 'string', 'min:100', 'max:10000'],
        ]);

        $post = Post::create([
            ...$data,
            'user_id' => $request->user()->id,
        ]);

        return redirect($post->showRoute());
    }

    /**
     * Display the specified post.
     *
     * @param Request $request
     * @param Post $post
     * @return RedirectResponse|Response|ResponseFactory
     */
    public function show(
        Request $request,
        Post $post
    ): RedirectResponse|Response|ResponseFactory {
        if (!Str::endsWith($post->showRoute(), $request->path())) {
            return redirect($post->showRoute($request->query()), status: 301);
        }

        return inertia('Posts/Show', [
            'post' => fn() => PostResource::make($post->load('user', 'topic')),
            'comments' => fn() => CommentResource::collection(
                $post->comments()
                    ->with('user')
                    ->latest()
                    ->latest('id')
                    ->paginate(10)
            )
        ]);
    }
}
