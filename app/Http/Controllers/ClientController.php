<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\City;
use App\Models\State;
use App\Models\Client;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use App\Services\TagService;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

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

        return view('client.add')
                ->with('tags', $tags);
    }

    public function setStateCity(Request $request)
    {
        $jsonCity  = City::where('number', $request->city)->first();
        $cities    = City::where('state_id', $jsonCity->state_id)->get();
        
        $states    = State::all();

        $response = [
            'selected_state'   => $jsonCity->state_id,
            'selected_city'    => $jsonCity->number,
            'cities'           => $cities,
            'states'           => $states,
        ];

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request, TagService $tagService)
    {
        try {
            $client = Client::create($request->all());

            foreach($request->input('tag_id') as $tag) {
                if(!Str::isUuid($tag)) {
                    $storeTag = $tagService->store($tag);

                    $tag = $storeTag->id;
                }

                $client->clientTags()->create([
                    'tag_id' => $tag
                ]);
            }

            return redirect()->route('client.index')
                            ->with('success', 'Cliente Cadastrado com sucesso.');
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
        $client = Client::findOrFail($id);
        $tags =  Tag::all();

        return view('client.edit')
                ->with('client', $client)
                ->with('tags', $tags);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, string $id, TagService $tagService)
    {
        try {
            $client = Client::findOrFail($id);
            $client->update($request->all());

            foreach($request->input('tag_id') as $tag) {
                if(!Str::isUuid($tag)) {
                    $storeTag = $tagService->store($tag);

                    $tag = $storeTag->id;
                }

                $setTags[] = $tag;
            }

            $client->tags()->sync($setTags);

            return redirect()->route('client.index')
                            ->with('success', 'Cliente Atualizado com sucesso.');
        } catch (\Throwable $th) {
            Helper::log_message($th, 'clients', 'error');

            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Não foi possível Atualizar o Cliente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $client = Client::findOrFail($request->input('client'));
            $client->delete();

            return response()->json([
                'message' => "Cliente deletado com sucesso."
            ], 200);
        } catch (\Throwable $th) {
            Helper::log_message($th, 'clients', 'error');

            return response()->json([
                'message' => 'Falha ao deletar o cliente. Favor, dente novamente'
            ], 403);
        }
    }
}
