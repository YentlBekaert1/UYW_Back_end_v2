<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Http\Requests\StoreMaterialRequest;
use App\Http\Requests\UpdateMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Repositories\MaterialsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $language)
    {
        $materials = Material::query()->with(['submaterial'])->orderBy('name', 'asc')->get();

        if($language == "en"){
            App::setLocale($language);
            return MaterialResource::collection($materials);
        }
        if($language == "nl"){
            App::setLocale($language);
            return MaterialResource::collection($materials);
        }
        if($language == "fr"){
            App::setLocale($language);
            return MaterialResource::collection($materials);
        }
        else{
            return abort(404, "Language is not supported");
        }

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

        return new MaterialResource($created);
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

        return new MaterialResource($created);
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

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }


    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $materials = Material::query()->paginate($pageSize);
        return view('web.materials.index', compact('materials'));
    }

    public function edit(Request $request, Material $material)
    {
        return view('web.materials.edit', compact('material'));
    }

    public function create()
    {

        return view('web.materials.create');
    }
}
