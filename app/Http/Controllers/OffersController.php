<?php

namespace App\Http\Controllers;

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

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        //abort(404);
        $pageSize = $request->page_size ?? 20;
        $offers = Offers::query()->filter($request)->with(['images','location','materials','submaterials']);
        //->where('status','=', 1)
        $offers = $offers->where('status','=', 1)->paginate($pageSize);

        return OffersResource::collection($offers);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreOffersRequest  $request
     * @return OffersResource
     */
    public function store(StoreOffersRequest $request, OffersRepository $repository)
    {
        $created = $repository->create($request->only([
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

        return new OffersResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Offers  $offers
     * @return OffersResource
     */
    public function show(Offers $offer)
    {

        $item = Offers::with(['images','location','materials','submaterials','tags'])->where('id', $offer->id)->where('status','=', 1);

        return OffersResource::collection($item->get())->response();
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

        $offer = $repository->update($offer, $request->only([
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
            'newimages',
            'editimages'
        ]));

        return $offer;
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

      /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */
    public function add_offer_to_favorites_user($id, OffersRepository $repository)
    {
        $offer = Offers::find($id);
        $res = $repository->add_to_favorites($offer);

       return $res;
    }

     /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function remove_offer_from_favorites_user($id, OffersRepository $repository)
    {
        $offer = Offers::find($id);
        $res = $repository->remove_from_favorites($offer);

       return $res;
    }

          /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function add_tag_to_offer(Request $request, Offers $offer, OffersRepository $repository)
    {

        $offer = $repository->add_tag($offer, $request->only([
            'tag_id',
        ]));

       return $offer;
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Offers  $offers
     * @return \Illuminate\Http\Response
     */

    public function remove_tag_from_offer(Request $request, Offers $offer, OffersRepository $repository)
    {

        $offer = $repository->remove_tag($offer, $request->only([
            'tag_id',
        ]));

       return $offer;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function increment_offer_views($id, OffersRepository $repository)
    {
        $offer = Offers::find($id);
        $res = $repository->increment_offer_views($offer);

       return $res;
    }


    public function searchterms(Request $request)
    {
        $query_offers =  Offers::query()->where('title', "LIKE",  "%{$request->name}%")->get();

        return  $query_offers;
    }

}
