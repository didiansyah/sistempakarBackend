<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "fullname" => "{$this->fname} {$this->lname}",
            "id" => $this->id,
            "fname" => $this->fname,
            "lname" => $this->lname,
            "phone" => $this->phone,
            "email" => $this->email,
            "link" => route('users.show', $this->id),
            "remember_token" => null,
            // "published" => $this->created_at->format("d F, Y"),
            "published" => $this->created_at->diffForHumans(),
        ];
    }
}
