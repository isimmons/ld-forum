<?php

namespace App\Http\Resources;

use App\Models\{Topic, User};
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $html
 * @property mixed $updated_at
 * @property mixed $created_at
 * @property User $user
 * @property Topic $topic
 * @method showRoute(array $parameters = [])
 */
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'html' => $this->html,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => UserResource::make($this->whenLoaded('user')),
            'topic' => TopicResource::make($this->whenLoaded('topic')),
            'routes' => [
                'show' => $this->showRoute(),
            ]
        ];
    }
}
