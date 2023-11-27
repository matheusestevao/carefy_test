<?php

namespace App\Services;

use App\Models\Tag;
use App\Helpers\Helper;
use Illuminate\Http\Request;

class TagService
{
    public function store(string $name): object|bool
    {
        try {
            $tag = Tag::create([
                'name' => $name,
            ]);

            return $tag;
        } catch (\Throwable $th) {
            Helper::log_message($th, 'tags', 'error');

            return false;
        }
    }
}