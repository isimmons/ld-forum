<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\User;
use App\Models\Topic;

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
