<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\OfferImage;
use App\Models\SubMaterial;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class OfferImagesRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {


                $filename = time().data_get($attributes, 'filename')->getClientOriginalName();
                data_get($attributes, 'filename')->move(public_path().'/images/',$filename);

                $created = OfferImage::query()->create([
                    'filename' => $filename,
                    'offer_id' => data_get($attributes, 'offer_id'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create item image. ');

                return $created;
        });
    }

    /**
     * @param OfferImage $itemimage
     * @param array $attributes
     * @return mixed
     */
    public function update($itemimage, array $attributes)
    {
        return DB::transaction(function () use($itemimage, $attributes) {

            if(data_get($attributes, 'filename')){
                $currentimage = OfferImage::find($itemimage->id);
                $path = public_path().'/images/' . $currentimage->filename;;
                if(File::exists($path) ) {
                    File::delete($path);
                }

                $filename = time().data_get($attributes, 'filename')->getClientOriginalName();
                data_get($attributes, 'filename')->move(public_path().'/images/',$filename);

                 $updated = $itemimage->update([
                    'filename' => data_get($attributes, 'filename', $filename),
                    'offer_id' => data_get($attributes, 'offer_id', $itemimage->offer_id),
                ]);
                throw_if(!$updated, GeneralJsonException::class, 'Failed to update itemimage');

                return $itemimage;
            }
            else{
                $updated = $itemimage->update([
                    'offer_id' => data_get($attributes, 'offer_id', $itemimage->offer_id),
                ]);

                throw_if(!$updated, GeneralJsonException::class, 'Failed to update itemimage');

                return $attributes;
            }




           // return $itemimage;

        });
     }

    /**
     * @param OfferImage $itemimage
     * @return mixed
     */
    public function forceDelete($itemimage)
    {
        return DB::transaction(function () use($itemimage) {


            $filename = $itemimage->filename;
            $path = public_path().'/images/' . $filename;

            if(File::exists($path) ) {
                File::delete($path);
            }

            $deleted = $itemimage->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete itemimage.");
            return $deleted;
        });
    }

}
