<?php

namespace App\Http\Controllers;

use App\Models\faq;
use App\Http\Requests\StorefaqRequest;
use App\Http\Requests\UpdatefaqRequest;
use App\Http\Resources\FaqResource;
use App\Repositories\FaqRepository;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $faq = faq::query()->paginate($pageSize);
        return FaqResource::collection($faq);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorefaqRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorefaqRequest $request, FaqRepository $repository)
    {
        $created = $repository->create($request->only([
            'title',
            'description',
            'title_nl',
            'description_nl',
            'title_fr',
            'description_fr',
            'title_en',
            'description_en',
        ]));

        return FaqResource::collection($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(faq $faq)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefaqRequest  $request
     * @param  \App\Models\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatefaqRequest $request, faq $faq, FaqRepository $repository)
    {
        $faq = $repository->update($faq, $request->only([
            'title',
            'description',
            'title_nl',
            'description_nl',
            'title_fr',
            'description_fr',
            'title_en',
            'description_en',
        ]));

        return FaqResource::collection($faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(faq $faq)
    {
        //
    }
}
