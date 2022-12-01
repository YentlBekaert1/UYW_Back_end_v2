<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $tags = Tag::query()->paginate($pageSize);
        return TagResource::collection($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request, TagRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr'
        ]));

        return new TagResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag, TagRepository $repository)
    {
        $created = $repository->update($tag, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr'
        ]));

        return new TagResource($created);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag, TagRepository $repository)
    {
        $deleted = $repository->forceDelete($tag);

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }


    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $tags = Tag::query()->paginate($pageSize);
        return view('web.tags.index', compact('tags'));
    }

    public function edit(Request $request, Tag $tag)
    {
        return view('web.tags.edit', compact('tag'));
    }

    public function create()
    {

        return view('web.tags.create');
    }

    public function autocomplete(Request $request)
    {

        //   $data = Tag::where("name_en","LIKE","%{$request->input('query')}%")
        //             ->orWhere("name_fr","LIKE","%{$request->input('query')}%")
        //             ->orWhere("name_nl","LIKE","%{$request->input('query')}%")
        //             ->get();
          $data = Tag::where("name","LIKE","%{$request->input('query')}%")->get();
          
        return TagResource::collection($data);
    }
}

