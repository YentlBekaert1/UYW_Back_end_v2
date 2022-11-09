<?php

namespace App\Http\Controllers\web;

use App\Models\SubMaterial;
use App\Http\Requests\StoreSubMaterialRequest;
use App\Http\Requests\UpdateSubMaterialRequest;
use App\Http\Resources\SubMaterialResource;
use App\Repositories\SubMaterialsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Material;
use PhpParser\Node\Stmt\Return_;

class SubMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $submaterials = SubMaterial::query()->paginate($pageSize);

        return view('web.submaterials.index', compact('submaterials'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubMaterial  $subMaterial
     * @return \Illuminate\Http\Response
     */
    public function show(SubMaterial $subMaterial)
    {
        return new SubMaterialResource($subMaterial);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubMaterialRequest  $request
     * @return SubMaterialResource | JsonResponse
     */
    public function store(StoreSubMaterialRequest $request, SubMaterialsRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'material_id'
        ]));

        $materials = Material::All();
        return view('web.submaterials.create')->with('message', 'Submaterial successfully created.')->with('materials', $materials);
    }

    public function create()
    {
        $materials = Material::All();
        return view('web.submaterials.create')->with('message', 'Submaterial successfully created.')->with('materials', $materials);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\SubMaterial  $submaterial
     * @return SubMaterialResource | JsonResponse
     */
    public function update(Request $request, SubMaterial $submaterial, SubMaterialsRepository $repository)
    {
        $subMaterial = $repository->update($submaterial, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr',
            'material_id'
        ]));
        $materials = Material::All();
        return view('web.submaterials.edit', compact('submaterial','materials'))->with('message', 'Submaterial successfully updated.');
    }

    public function edit(Request $request, SubMaterial $submaterial)
    {
        $materials = Material::All();
        return view('web.submaterials.edit')->with('submaterial', $submaterial)->with('materials', $materials);
    }

    public function delete(Request $request, SubMaterial $submaterial)
    {

        return view('web.submaterials.delete')->with('submaterial', $submaterial);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubMaterial  $subMaterial
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubMaterial $submaterial, SubMaterialsRepository $repository)
    {
        $deleted = $repository->forceDelete($submaterial);

        return view('web.submaterials.index')->with('message', 'Submaterial successfully deleted.');
    }
}
