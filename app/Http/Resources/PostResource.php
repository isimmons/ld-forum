<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property mixed $updated_at
 * @property mixed $created_at
 * @property User $user
 * @method showRoute
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => $this->whenLoaded('user', fn () => UserResource::make($this->user)),
            'routes' => [
                'show' => $this->showRoute(),
            ]
        ];
    }
}
