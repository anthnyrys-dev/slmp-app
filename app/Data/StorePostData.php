<?php

namespace App\Data;

use Illuminate\Http\Request;

class StorePostData
{
    public function __construct(
        public string $id,
        public string $user_id,
        public string $title,
        public string $body,
    ) {}

    public static function fromRequest(Request $request): self
    {
        return new self(
            id: $request->input('id'),
            user_id: $request->input('user_id'),
            title: $request->input('title'),
            body: $request->input('body'),
        );
    }
}
