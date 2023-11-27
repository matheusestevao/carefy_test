<?php

namespace App\Services;

use App\Models\Tag;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class TagService
{
    public function store(Request $request): object|bool
    {
        try {
            $tag = Tag::create([
                'name' => $request->input('name'),
            ]);

            return $tag;
        } catch (\Throwable $th) {
            Helper::log_message($th, 'tags', 'error');

            return false;
        }
    }
}