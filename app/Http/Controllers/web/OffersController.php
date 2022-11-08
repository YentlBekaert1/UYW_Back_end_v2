<?php

namespace App\Http\Controllers\web;

use App\Models\Offers;
use App\Http\Requests\StoreOffersRequest;
use App\Http\Requests\UpdateOffersRequest;
use App\Http\Resources\OffersResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Repositories\OffersRepository;
use App\Exceptions\GeneralJsonException;
use App\Http\Resources\OffersLocationResource;
use App\Models\Approach;
use App\Models\Categories;
use App\Models\Material;
use App\Models\OfferImage;
use App\Models\SubMaterial;
use App\Models\Tag;
use App\Models\User;
use App\Http\Controllers\Controller;

class OffersController extends Controller
{

    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $offers = Offers::query()->paginate($pageSize);
        return view('web.offers.index', compact('offers'));
    }

    public function create()
    {
        $categories = Categories::All();
        $materials = Material::All();
        $submaterials = SubMaterial::All();
        $users = User::All();
        $approaches=Approach::All();
        $tags=Tag::All();

        return view('web.offers.create')->with('categories', $categories)->with('materials', $materials)->with('submaterials', $submaterials)->with('users', $users)->with('approaches', $approaches)->with('tags', $tags);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOffersRequest  $request
     * @return OffersResource
     */
    public function store(StoreOffersRequest $request, OffersRepository $repository)
    {
        $created = $repository->create_admin($request->only([
            'title',
            'description',
            'tags',
            'newtags',
            'materials',
            'submaterials',
            'category',
            'approach',
            'status',
            'url',
            'contact',
            'job',
            'lat',
            'lon',
            'street',
            'number',
            'postal',
            'city',
            'country',
            'images',
            'user_id'
        ]));
// return $request;
       return view('web.offers.index', compact('created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offers  $offers
     * @return OffersResource
     */
    public function show(Offers $offer)
    {

        $item = Offers::with(['images','location','materials','submaterials'])->where('id', $offer->id);

        return OffersResource::collection($item->get())->response();
    }

    public function edit(Request $request, Offers $offer)
    {
        $categories = Categories::All();
        $materials = Material::All();
        $users = User::All();
        $approaches=Approach::All();
        $tags=Tag::All();
        $images=OfferImage::Select()->where('offer_id',"=", $offer)->get();
        $offer=Offers::with(['images','location','materials','submaterials','tags'])->find($offer->id);
        return view('web.offers.edit')->with('offer', $offer)->with('images', $images)->with('categories', $categories)->with('tags', $tags)->with('materials', $materials)->with('users', $users)->with('approaches', $approaches);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Offers  $offers
     * @return OffersResource | JsonResponse
     */
    public function update(Request $request, Offers $offer, OffersRepository $repository)
    {

        $offer = $repository->update_admin($offer, $request->only([
            'title',
            'description',
            'tags',
            'materials',
            'submaterials',
            'category',
            'approach',
            'status',
            'url',
            'contact',
            'job',
            'lat',
            'lon',
            'street',
            'number',
            'postal',
            'city',
            'country',
            'images'
        ]));
        return view('web.offers.index', compact('offer'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Offers $offer, OffersRepository $repository)
    {
          //
          $deleted = $repository->forceDelete($offer);

          return new JsonResponse([
              'data' => $deleted,
          ]);
    }

}
