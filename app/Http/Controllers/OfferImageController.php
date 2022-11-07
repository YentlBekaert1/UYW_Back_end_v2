<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfferImageRequest;
use App\Http\Requests\UpdateOfferImageRequest;
use App\Http\Resources\OfferImagesResource;
use App\Models\OfferImage;
use App\Repositories\OfferImagesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OfferImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $images = OfferImage::query()->paginate($pageSize);
        return OfferImagesResource::collection($images);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOfferImageRequest $request, OfferImagesRepository $repository)
    {
        $created = $repository->create($request->only([
            'filename',
            'offer_id',
        ]));

        return new OfferImagesResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemImage  $offerimage
     * @return \Illuminate\Http\Response
     */
    public function show(OfferImage $offerimage)
    {
        return new OfferImagesResource($offerimage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOfferImageRequest  $request
     * @param  \App\Models\OfferImage  $offerimage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOfferImageRequest $request, OfferImage $offerimage, OfferImagesRepository $repository)
    {
        $offerimage = $repository->update($offerimage, $request->only([
            'filename',
            'offer_id',
        ]), $request->file('filename'));

        return $offerimage;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfferImage  $offerimage
     * @return \Illuminate\Http\Response
     */
    public function destroy(OfferImage $offerImage, OfferImagesRepository $repository)
    {
        $deleted = $repository->forceDelete($offerImage);

        return new JsonResponse([
            'data' => $deleted,
        ]);
    }
}
