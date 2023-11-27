<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Client;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use App\Services\TagService;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return view('client.index')->with('clients', $clients);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();

        return view('client.add')->with('tags', $tags);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request, TagService $tagService)
    {
        try {
            $client = Client::create($request->all());

            foreach($request->input('tag_id') as $tag) {
                if(!Str::isUlid($tag)) {
                    $storeTag = $tagService->store($tag);

                    $tag = $storeTag->id;
                }

                $client->clientTags()->create([
                    'tag_id' => $tag
                ]);
            }

        } catch (\Throwable $th) {
            Helper::log_message($th, 'clients', 'error');

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Não foi possível cadastrar o Cliente.');
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
