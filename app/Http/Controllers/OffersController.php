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
use App\Models\Locations;
use App\Models\Material;
use App\Models\OfferImage;
use App\Models\SubMaterial;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\File;

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


    public function searchitems(Request $request)
    {

        $offers = Offers::query()->with(['images','location','materials','submaterials'])
        ->where('status','=',1)
        ->where("title","LIKE","%{$request->input('query')}%")
        ->orWhere(function($query) use($request) {
            $query->whereHas("materials",function($query) use($request){
                $query->where("name","LIKE","%{$request->input('query')}%");
            });
        })
        ->orWhere(function($query) use($request) {
            $query->whereHas("submaterials",function($query) use($request){
                $query->where("name","LIKE","%{$request->input('query')}%");
            });
        })
        ->orWhere(function($query) use($request) {
            $query->whereHas("tags",function($query) use($request){
                $query->where("name","LIKE","%{$request->input('query')}%");
            });
        })
        ->orWhere(function($query) use($request) {
            $query->whereHas("location",function($query) use($request){
                $query->where("street","LIKE","%{$request->input('query')}%")
                      ->orWhere("city","LIKE","%{$request->input('query')}%")
                      ->orWhere("country","LIKE","%{$request->input('query')}%");
            });
        })

        ->filter($request)->paginate(20);
        return OffersResource::collection($offers);
    }


    public function searchterms(Request $request)
    {
        $query_offers=  collect(Offers::select('title')->where("title","LIKE","%{$request->input('query')}%")->get());
        $query_materials =  collect(Material::select('name')->where("name","LIKE","%{$request->input('query')}%")->get());
        $query_submaterials = collect(SubMaterial::select('name')->where("name","LIKE","%{$request->input('query')}%")->get());
        $query_tags = collect(Tag::select('name')->where("name","LIKE","%{$request->input('query')}%")->get());
        $query_locations = collect(Locations::select(['street','city','country'])->where("street","LIKE","%{$request->input('query')}%")
                                        ->orWhere("city","LIKE","%{$request->input('query')}%")
                                        ->orWhere("country","LIKE","%{$request->input('query')}%")->get())->unique('');

        $merged_1 = $query_offers->merge($query_materials);
        $merged_mat_submat = $merged_1->merge($query_submaterials);
        $merged_mat_submat_tag = $merged_mat_submat->merge($query_tags);
        $merged_mat_submat_tag_items = $merged_mat_submat_tag->merge($query_locations);
        return $merged_mat_submat_tag_items;
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
     * Display the specified resource.
     *
     * @param  \App\Models\Offers  $offers
     * @return OffersResource
     */
    public function geteditoffer(Offers $offer)
    {

        $item = Offers::with(['images','location','materials','submaterials','tags'])->where('id', $offer->id);

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
            'newimagepositions',
            'newimages',
            'editimages'
        ]));

        return $offer;
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Offers  $offers
     * @return OffersResource | JsonResponse
     */
    public function updateStatus(Request $request, Offers $offer, OffersRepository $repository)
    {

        $offer = $repository->updatestatus($offer, $request->only([
            'status',
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
        $old_images = OfferImage::query()->where('offer_id', '=', $offer->id)->get();

        foreach ($old_images  as $image) {
            if(File::exists($image->filename) ) {
                File::delete($image->filename);
            }
            $deleted = $image->forceDelete();
        }

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


    // public function searchterms(Request $request)
    // {
    //     $query_offers =  Offers::query()->where('title', "LIKE",  "%{$request->name}%")->get();

    //     return  $query_offers;
    // }

}
