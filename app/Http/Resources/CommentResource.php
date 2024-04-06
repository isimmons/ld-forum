<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Post;
use App\Models\User;

/**
 * @property int $id
 * @property string $body
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property User user
 * @property Post post
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->whenLoaded('user', fn () => UserResource::make($this->user)),
            'post' => $this->whenLoaded('post', fn () => PostResource::make($this->post)),
            'can' => [
                'delete' => $request->user()?->can('delete', $this->resource)
            ]
        ];
    }
}
