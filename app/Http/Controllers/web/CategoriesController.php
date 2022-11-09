<?php

namespace App\Http\Controllers\web;

use App\Models\Categories;
use App\Http\Requests\StorecategoriesRequest;
use App\Http\Requests\UpdatecategoriesRequest;
use App\Http\Resources\CategoriesResource;
use App\Repositories\CategoriesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $categories = Categories::query()->paginate($pageSize);
        return view('web.categories.index', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(categories $categorie)
    {
        return new CategoriesResource($categorie);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorecategoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorecategoriesRequest $request, CategoriesRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'description',
            'description_nl',
            'description_en',
            'description_fr',
            'category_image'
        ]));

        return redirect()->route('web.categories.create')->with('message', 'Categorie successfully created.');
    }

    public function create()
    {

        return view('web.categories.create');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Categories  $categorie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $categorie, CategoriesRepository $repository)
    {
        $result = $repository->update($categorie, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'description',
            'description_nl',
            'description_en',
            'description_fr',
            'category_image'
        ]));

        return view('web.categories.edit', compact('categorie'))->with('message', 'Categorie successfully updated.');
    }

    public function edit(Request $request, Categories $categorie)
    {
        return view('web.categories.edit', compact('categorie'));
    }

    public function delete(Request $request, Categories $categorie)
    {

        return view('web.categories.delete')->with('categorie', $categorie);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $categorie, CategoriesRepository $repository)
    {
          //
          $deleted = $repository->forceDelete($categorie);

          return view('web.categories.index')->with('message', 'Categorie successfully deleted.');
    }
}
