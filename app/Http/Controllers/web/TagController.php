<?php

namespace App\Http\Controllers\web;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\TagResource;
use App\Repositories\TagRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $tags = Tag::query()->paginate($pageSize);
        return view('web.tags.index', compact('tags'));
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

        return redirect()->route('web.tags.index')->with('message', 'Tag succesvol toegevoegd.');
    }

    public function create()
    {

        return view('web.tags.create');
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

        return redirect()->route('web.tags.index')->with('message', 'Tag succesvol gewijzigd.');;
    }

    public function edit(Request $request, Tag $tag)
    {
        return view('web.tags.edit', compact('tag'));
    }

    public function delete(Request $request, Tag $tag)
    {

        return view('web.tags.delete')->with('tag', $tag);
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

        return redirect()->route('web.tags.index')->with('message', 'Tag succesvol verwijderd.');
    }

}
