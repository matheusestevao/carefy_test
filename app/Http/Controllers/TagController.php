<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Helpers\Helper;
use App\Http\Requests\TagRequest;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::all();

        return view('tag.index')->with('tags', $tags);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tag.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request, TagService $tagService)
    {
        $tag = $tagService->store($request);

        if ($tag instanceof Tag) {
            return redirect()->route('tag.index')
                            ->with('success', 'Tag Cadastrada com Sucesso.');
        }
        
        return redirect()->route('tag.create')
                            ->withInput()
                            ->with('error', 'Não foi possível cadastrar a tag.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);

        return view('tag.form')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TagRequest $request, string $id)
    {
        try {
            $tag = Tag::findOrFail($id);

            $tag->update([
                'name' => $request->input('name')
            ]);

            return redirect()->route('tag.index')
                            ->with('success', 'Tag Atualizada com Sucesso.');
        } catch (\Throwable $th) {
            Helper::log_message($th, 'tags', 'error');

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Não foi possível atualizar a tag.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
