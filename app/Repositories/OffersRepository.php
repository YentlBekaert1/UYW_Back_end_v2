<?php
namespace App\Repositories;

use App\Events\Models\Offers\OffersCreated;
use App\Events\Models\Offers\OffersDeleted;
use App\Events\Models\Offers\OffersUpdated;
use App\Models\Offers;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Locations;
use App\Models\OfferImage;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OffersRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            if (Auth::check()) {
                //The user is logged in...
                $user_id = Auth::id();

                $created = Offers::query()->create([
                    'title' => data_get($attributes, 'title', 'Untitled'),
                    'description' => data_get($attributes, 'description'),
                    'title_nl' => data_get($attributes, 'title_nl'),
                    'description_nl' => data_get($attributes, 'description_nl'),
                    'title_fr' => data_get($attributes, 'title_fr'),
                    'description_fr' => data_get($attributes, 'description_fr'),
                    'title_en' => data_get($attributes, 'title_en'),
                    'description_en' => data_get($attributes, 'description_en'),
                    'categories_id' => data_get($attributes, 'category'),
                    'approaches_id' => data_get($attributes, 'approach'),
                    'url' => data_get($attributes, 'url'),
                    'job' => data_get($attributes, 'job'),
                    'status' => data_get($attributes, 'status'),
                    'contact' => data_get($attributes, 'contact'),
                    'user_id' => $user_id,
                ]);

                if(data_get($attributes, 'tags')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(json_decode(data_get($attributes, 'tags')) as $tag){
                        $created->tags()->attach($tag);
                    }
                }

                if(data_get($attributes, 'newtags')){
                    //nieuwe tags aanmaken
                    foreach(json_decode(data_get($attributes, 'newtags')) as $tag){
                        $new = Tag::query()->create([
                            'name' => $tag,
                        ]);
                        $created->tags()->attach($new);
                    }
                }

                if(data_get($attributes, 'materials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(json_decode(data_get($attributes, 'materials')) as $material){
                        $created->materials()->attach($material);
                    }
                }

                if(data_get($attributes, 'submaterials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    $created->submaterials()->attach(json_decode(data_get($attributes, 'submaterials')));
                }

                if(data_get($attributes, 'lat') && data_get($attributes, 'lat')){
                    $created_loction = Locations::query()->create([
                        'lat' => data_get($attributes, 'lat'),
                        'lon' => data_get($attributes, 'lon'),
                        'street' => data_get($attributes, 'street'),
                        'number' => data_get($attributes, 'number'),
                        'postal' => data_get($attributes, 'postal'),
                        'city' => data_get($attributes, 'city'),
                        'country' => data_get($attributes, 'country'),
                        'offers_id' => $created->id,
                    ]);
                    throw_if(!$created_loction, GeneralJsonException::class, 'Failed to location. ');
                }

                if(data_get($attributes, 'images'))
                {
                    $position = 1;
                    foreach (data_get($attributes, 'images') as $imagefile) {

                        $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);

                        $created_image = OfferImage::query()->create([
                            'filename' => $path,
                            'position' => $position,
                            'offer_id' => $created->id,
                        ]);
                        $position++;
                        throw_if(!$created_image, GeneralJsonException::class, 'Failed to create item image. ');
                    }
                }


                throw_if(!$created, GeneralJsonException::class, 'Failed to offer. ');
                event(new OffersCreated($created));

                return $created;
            }
            else{
                return response('{"message":"not authenticated"}', 200);
            }
        });
    }

    /**
     * @param Offers $offer
     * @param array $attributes
     * @return mixed
     */
    public function update($offer, array $attributes)
    {

        return DB::transaction(function () use($offer, $attributes) {
            if (Auth::check()) {
                $updated = $offer->update([
                    'title' => data_get($attributes, 'title', $offer->title),
                    'description' => data_get($attributes, 'description', $offer->description),
                    'categories_id' => data_get($attributes, 'category', $offer->categories_id),
                    'approaches_id' => data_get($attributes, 'approach', $offer->approaches_id),
                    'url' => data_get($attributes, 'url', $offer->url),
                    'job' => data_get($attributes, 'job', $offer->job),
                    'contact' => data_get($attributes, 'contact', $offer->contact),
                    'status' => 1,
                    //'user_id' => data_get($attributes, 'user_id', $offer->user_id),
                ]);

                $offer->tags()->detach();
                if(data_get($attributes, 'tags')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(json_decode(data_get($attributes, 'tags')) as $tag){
                        $offer->tags()->attach($tag);
                    }
                }

                if(data_get($attributes, 'newtags')){
                    //nieuwe tags aanmaken
                    foreach(json_decode(data_get($attributes, 'newtags')) as $tag){
                        $new = Tag::query()->create([
                            'name' => $tag,
                        ]);
                        $offer->tags()->attach($new);
                    }
                }
                $offer->materials()->detach();
                if(data_get($attributes, 'materials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(json_decode(data_get($attributes, 'materials')) as $material){
                        $offer->materials()->attach($material);
                    }
                }
                $offer->submaterials()->detach();
                if(data_get($attributes, 'submaterials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    $offer->submaterials()->attach(json_decode(data_get($attributes, 'submaterials')));
                }

                if(data_get($attributes, 'lat') && data_get($attributes, 'lat')){
                    if($offer->location){
                        $updated =  Locations::find($offer->location->id)->update([
                            'lat' => data_get($attributes, 'lat' ,$offer->lat),
                            'lon' => data_get($attributes, 'lon', $offer->lon),
                            'street' => data_get($attributes, 'street', $offer->street),
                            'number' => data_get($attributes, 'number', $offer->number),
                            'postal' => data_get($attributes, 'postal', $offer->postal),
                            'city' => data_get($attributes, 'city', $offer->city),
                            'country' => data_get($attributes, 'country', $offer->country),
                            'offers_id' => data_get($attributes, 'offers_id', $offer->id),
                        ]);
                        throw_if(!$updated, GeneralJsonException::class, 'Failed to update location');
                    }else{
                        $created_loction = Locations::query()->create([
                            'lat' => data_get($attributes, 'lat'),
                            'lon' => data_get($attributes, 'lon'),
                            'street' => data_get($attributes, 'street'),
                            'number' => data_get($attributes, 'number'),
                            'postal' => data_get($attributes, 'postal'),
                            'city' => data_get($attributes, 'city'),
                            'country' => data_get($attributes, 'country'),
                            'offers_id' => $offer->id,
                        ]);
                        throw_if(!$created_loction, GeneralJsonException::class, 'Failed to location. ');
                    }

                }


                if(data_get($attributes, 'editimages'))
                {
                    $editimages = json_decode(data_get($attributes, 'editimages'));
                    $offerimages_ids = [];
                    $offerimages = OfferImage::where('offer_id','=',$offer->id)->get();
                    foreach ($offerimages  as $img) {
                        array_push($offerimages_ids, $img->id);
                    }
                    $editimages_ids = [];
                    foreach ($editimages  as $img) {
                        if($img->new == false){
                          array_push($editimages_ids, $img->id);
                        }
                    }
                    foreach($editimages as $img){
                        if($img->new == false){
                            $stored_img = OfferImage::find($img->id);
                            $stored_img->position = $img->position;
                            $stored_img->save();

                            //zoek of de id in de offer images zit
                            $res = array_search($img->id, $offerimages_ids);
                            //verwijder de id uit de offer images  id array
                            unset($offerimages_ids[$res]);
                            // nu houden we een array over met de id die we mogen verwijderen.
                            //update position
                        }
                    }
                      //overloop de offerimages id's die we mogen verwijderen en verwijder ze
                      foreach ( $offerimages_ids  as $id) {
                        $img = OfferImage::find($id);
                        if(File::exists($img->filename) ) {
                            File::delete($img->filename);
                        }
                        $image = OfferImage::find($img->id);
                        $deleted = $image->forceDelete();
                    }
                }

                if(data_get($attributes, 'newimages'))
                {
                    $newimagepositions = json_decode(data_get($attributes, 'newimagepositions'));
                    $count = 0;
                    foreach (data_get($attributes, 'newimages') as $imagefile) {
                        $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);

                        $created_image = OfferImage::query()->create([
                            'filename' => $path,
                            'position' => $newimagepositions[$count],
                            'offer_id' => $offer->id,
                        ]);
                        $count++;
                        throw_if(!$created_image, GeneralJsonException::class, 'Failed to create item image. ');
                    }
                }

                throw_if(!$updated, GeneralJsonException::class, 'Failed to update offer');
                event(new OffersUpdated($offer));

                return data_get($attributes, 'newimagepositions');
                }
                else{
                    return response('{"message":"not authenticated"}', 200);
                }
        });
    }
      /**
     * @param Offers $offer
     * @param array $attributes
     * @return mixed
     */
    public function updatestatus($offer, array $attributes)
    {

        return DB::transaction(function () use($offer, $attributes) {
            if (Auth::check()) {
                $updated = $offer->update([
                    'status' => data_get($attributes, 'status', $offer->contact),
                ]);
                return $updated;
            }
            else{
                return response('{"message":"not authenticated"}', 200);
            }
        });
    }

    /**
     * @param Offers $offer
     * @return mixed
     */
    public function forceDelete($offer)
    {
        return DB::transaction(function () use($offer) {
            $deleted = $offer->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete offer.");
            event(new OffersDeleted($offer));

            return $deleted;
        });

    }

     /**
     * @param Offers $offer
     * @param array $attributes
     * @return mixed
     */
    public function add_to_favorites($offer)
    {
        // if($userId = data_get($attributes, 'user_id')){
        //     $offer->users_favorites()->attach($userId);
        // }

        //Gebruiken al we met auth werken.
        if (Auth::check()) {
            // The user is logged in...
            $user_id = Auth::id();
            $offer->users_favorites()->attach($user_id);
            $offer->increment('total_likes');
            return response('{"message":"attached succesfull"}', 200);
        }
        else{
            return response('{"message":"not authenticated"}', 200);
        }
    }

     /**
     * @param Offers $offer
     * @return mixed
     */
    public function remove_from_favorites($offer)
    {
        // if($userId = data_get($attributes, 'user_id')){
        //     $offer->users_favorites()->detach($userId);
        // }

        if (Auth::check()) {
            // The user is logged in...
            $user_id = Auth::id();
            $offer->users_favorites()->detach($user_id);
            $offer->decrement('total_likes');
            return response('{"message":"detached succesfull"}', 200);
        }
        else{
            return response('{"message":"not authenticated"}', 200);
        }
    }

     /**
     * @param Offers $offer
     * @return mixed
     */
    public function add_tag($offer, array $attributes)
    {
        if($tagId = data_get($attributes, 'tag_id')){
            $offer->tags()->attach($tagId);
        }

        // if (Auth::check()) {
        //     // The user is logged in...
        //     $user_id = Auth::id();
        //     //$offer->users_favorites()->attach($user_id);

        //     return response('{"message":"attached succesfull"}', 200);
        // }
        // else{
        //     return response('{"message":"not authenticated"}', 200);
        // }
    }

     /**
     * @param Offers $offer
     * @return mixed
     */
    public function remove_tag($offer, array $attributes)
    {
        if($tagId = data_get($attributes, 'tag_id')){
            $offer->tags()->detach($tagId);
        }

        // if (Auth::check()) {
        //     // The user is logged in...
        //     $user_id = Auth::id();
        //     //$offer->users_favorites()->attach($user_id);

        //     return response('{"message":"attached succesfull"}', 200);
        // }
        // else{
        //     return response('{"message":"not authenticated"}', 200);
        // }
    }

      /**
     * @param Offers $offer
     * @return mixed
     */
    public function increment_offer_views($offer)
    {
        $offer->increment('total_views');
        if($offer){
            return response('{"message":"succesfull"}', 200);
        }
        else{
            return response('{"message":"error"}', 200);
        }

    }

    public function create_admin(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {
            if (Auth::check()) {
                $created = Offers::query()->create([
                    'title' => data_get($attributes, 'title', 'Untitled'),
                    'description' => data_get($attributes, 'description'),
                    'categories_id' => data_get($attributes, 'category'),
                    'approaches_id' => data_get($attributes, 'approach'),
                    'url' => data_get($attributes, 'url'),
                    'job' => data_get($attributes, 'job'),
                    'status' => data_get($attributes, 'status'),
                    'contact' => data_get($attributes, 'contact'),
                    'user_id' => data_get($attributes, 'user_id'),
                ]);

                if(data_get($attributes, 'tags')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'tags')) as $tag){
                        $created->tags()->attach($tag);
                    }
                }

                if(data_get($attributes, 'newtags')){
                    //nieuwe tags aanmaken
                    foreach(explode(",",data_get($attributes, 'newtags')) as $tag){
                        $new = Tag::query()->create([
                            'name' => $tag,
                        ]);
                        $created->tags()->attach($new);
                    }
                }

                if(data_get($attributes, 'materials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'materials')) as $material){
                        $created->materials()->attach($material);
                    }
                }

                if(data_get($attributes, 'submaterials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'submaterials')) as $submaterial){
                        $created->submaterials()->attach($submaterial);
                    }
                }

                if(data_get($attributes, 'lat') && data_get($attributes, 'lat')){
                    $created_loction = Locations::query()->create([
                        'lat' => data_get($attributes, 'lat'),
                        'lon' => data_get($attributes, 'lon'),
                        'street' => data_get($attributes, 'street'),
                        'number' => data_get($attributes, 'number'),
                        'postal' => data_get($attributes, 'postal'),
                        'city' => data_get($attributes, 'city'),
                        'country' => data_get($attributes, 'country'),
                        'offers_id' => $created->id,
                    ]);
                    throw_if(!$created_loction, GeneralJsonException::class, 'Failed to location. ');
                }

                if(data_get($attributes, 'images'))
                {
                    $count = 1;
                    foreach (data_get($attributes, 'images') as $imagefile) {

                        $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
                        $created_image = OfferImage::query()->create([
                            'filename' => $path,
                            'position' => $count,
                            'offer_id' => $created->id,
                        ]);
                        $count++;
                        throw_if(!$created_image, GeneralJsonException::class, 'Failed to create item image. ');
                    }

                }


                throw_if(!$created, GeneralJsonException::class, 'Failed to offer. ');
                event(new OffersCreated($created));

                return $created;
            }
            else{
                return response('{"message":"not authenticated"}', 200);
            }
        });
    }

     /**
     * @param Offers $offer
     * @param array $attributes
     * @return mixed
     */
    public function update_admin($offer, array $attributes)
    {

        return DB::transaction(function () use($offer, $attributes) {
            if (Auth::check()) {
                $updated = $offer->update([
                    'title' => data_get($attributes, 'title', $offer->title),
                    'description' => data_get($attributes, 'description', $offer->description),
                    'categories_id' => data_get($attributes, 'category', $offer->categories_id),
                    'approaches_id' => data_get($attributes, 'approach', $offer->approaches_id),
                    'url' => data_get($attributes, 'url', $offer->url),
                    'job' => data_get($attributes, 'job', $offer->job),
                    'contact' => data_get($attributes, 'contact', $offer->contact),
                    'status' => data_get($attributes, 'status', $offer->status),
                    'user_id' => data_get($attributes, 'user_id', $offer->user_id),
                ]);

                $offer->tags()->detach();
                if(data_get($attributes, 'tags')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'tags')) as $tag){
                        $offer->tags()->attach($tag);
                    }
                }

                if(data_get($attributes, 'newtags')){
                    //nieuwe tags aanmaken
                    foreach(explode(",",data_get($attributes, 'newtags')) as $tag){
                        $new = Tag::query()->create([
                            'name' => $tag,
                        ]);
                        $offer->tags()->attach($new);
                    }
                }
                $offer->materials()->detach();
                if(data_get($attributes, 'materials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'materials')) as $material){
                        $offer->materials()->attach($material);
                    }
                }
                $offer->submaterials()->detach();
                if(data_get($attributes, 'submaterials')){
                    //create the pivot between tags and offers
                    //sync gaat de tags verwijderen die niet meer in de array staan
                    foreach(explode(",", data_get($attributes, 'submaterials')) as $submaterial){
                        $offer->submaterials()->attach($submaterial);
                    }
                }


                if(data_get($attributes, 'lat') && data_get($attributes, 'lat')){
                    if($offer->location){
                        $updated =  Locations::find($offer->location->id)->update([
                            'lat' => data_get($attributes, 'lat' ,$offer->lat),
                            'lon' => data_get($attributes, 'lon', $offer->lon),
                            'street' => data_get($attributes, 'street', $offer->street),
                            'number' => data_get($attributes, 'number', $offer->number),
                            'postal' => data_get($attributes, 'postal', $offer->postal),
                            'city' => data_get($attributes, 'city', $offer->city),
                            'country' => data_get($attributes, 'country', $offer->country),
                            'offers_id' => data_get($attributes, 'offers_id', $offer->id),
                        ]);
                        throw_if(!$updated, GeneralJsonException::class, 'Failed to update location');
                    }else{
                        $created_loction = Locations::query()->create([
                            'lat' => data_get($attributes, 'lat'),
                            'lon' => data_get($attributes, 'lon'),
                            'street' => data_get($attributes, 'street'),
                            'number' => data_get($attributes, 'number'),
                            'postal' => data_get($attributes, 'postal'),
                            'city' => data_get($attributes, 'city'),
                            'country' => data_get($attributes, 'country'),
                            'offers_id' => $offer->id,
                        ]);
                        throw_if(!$created_loction, GeneralJsonException::class, 'Failed to location. ');
                    }

                }

                if(data_get($attributes, 'images'))
                {
                    $old_images = OfferImage::query()->where('offer_id', '=', $offer->id)->get();

                    foreach ($old_images  as $image) {
                        if(File::exists($image->filename) ) {
                            File::delete($image->filename);
                        }
                        $deleted = $image->forceDelete();
                    }
                    $count = 1;
                    foreach (data_get($attributes, 'images') as $imagefile) {

                        $path = $imagefile->store('/images/resource', ['disk' => 'my_files']);
                        $created_image = OfferImage::query()->create([
                            'filename' => $path,
                            'position' => $count,
                            'offer_id' => $offer->id,
                        ]);
                        $count++;
                        throw_if(!$created_image, GeneralJsonException::class, 'Failed to create item image. ');
                    }


                }

                throw_if(!$updated, GeneralJsonException::class, 'Failed to update offer');
                event(new OffersUpdated($offer));

                return $offer;
                }
                else{
                    return response('{"message":"not authenticated"}', 200);
                }
        });
    }


}
