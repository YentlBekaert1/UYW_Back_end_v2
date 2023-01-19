<?php

namespace App\Http\Controllers\web;

use App\Models\Material;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\SubMaterial;
use App\Repositories\MaterialsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $materials = Material::query()->with(['submaterial'])->paginate($pageSize);
        return view('web.materials.index', compact('materials'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function show(Material $material)
    {
        return new MaterialResource($material);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMaterialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMaterialRequest $request, MaterialsRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr'
        ]));

        return redirect()->route('web.materials.index')->with('message', 'Materiaal succesvol aangemaakt.');
    }

    public function create()
    {

        return view('web.materials.create');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material, MaterialsRepository $repository)
    {
        $created = $repository->update($material, $request->only([
            'name',
            'name_nl',
            'name_en',
            'name_fr'
        ]));

        $submaterials = SubMaterial::Select()->where('material_id',"=", $material->id)->get();

        return redirect()->route('web.materials.index')->with('message', 'Materiaal succesvol gewijzigd.');
    }

    public function edit(Request $request, Material $material)
    {
        $submaterials = SubMaterial::Select()->where('material_id',"=", $material->id)->get();
        return view('web.materials.edit')->with('material', $material)->with('submaterials', $submaterials);
    }

    public function delete(Request $request, Material $material)
    {

        return view('web.materials.delete')->with('material', $material);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material  $material
     * @return \Illuminate\Http\Response
     */
    public function destroy(Material $material, MaterialsRepository $repository)
    {
        $deleted = $repository->forceDelete($material);

        return redirect()->route('web.materials.index')->with('message', 'Materiaal succesvol verwijderd.');
    }
}
