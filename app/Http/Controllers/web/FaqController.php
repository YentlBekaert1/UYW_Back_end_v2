<?php

namespace App\Http\Controllers\web;

use App\Models\faq;
use App\Http\Requests\StorefaqRequest;
use App\Http\Requests\UpdatefaqRequest;
use App\Http\Resources\FaqResource;
use App\Repositories\FaqRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $faq = faq::query()->paginate($pageSize);
        return view('web.faq.index', compact('faq'));
    }

    public function create(Request $request)
    {

        return view('web.faq.create');
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

        return redirect()->route('web.faq.index')->with('message', 'Question successfully created.');
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

    public function edit(Request $request, faq $faq)
    {

        return view('web.faq.edit')->with('faq', $faq);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatefaqRequest  $request
     * @param  \App\Models\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, faq $faq, FaqRepository $repository)
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

        return view('web.faq.index');
    }

    public function delete(Request $request, faq $faq)
    {

        return view('web.faq.delete')->with('faq', $faq);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(faq $faq, FaqRepository $repository)
    {
        $deleted = $repository->forceDelete($faq);

        return view('web.faq.index')->with('message', 'Question successfully deleted.');
    }
}
