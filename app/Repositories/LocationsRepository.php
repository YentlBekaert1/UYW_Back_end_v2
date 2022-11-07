<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Locations;
use Illuminate\Support\Facades\Auth;

class LocationsRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = Locations::query()->create([
                    'lat' => data_get($attributes, 'lat'),
                    'lon' => data_get($attributes, 'lon'),
                    'street' => data_get($attributes, 'street'),
                    'number' => data_get($attributes, 'number'),
                    'postal' => data_get($attributes, 'postal'),
                    'city' => data_get($attributes, 'city'),
                    'country' => data_get($attributes, 'country'),
                    'offers_id' => data_get($attributes, 'offers_id'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create location.');

                return $created;
        });
    }

    /**
     * @param Locations $location
     * @param array $attributes
     * @return mixed
     */
    public function update($location, array $attributes)
    {

        return DB::transaction(function () use($location, $attributes) {
            $updated = $location->update([
                'lat' => data_get($attributes, 'lat' ,$location->lat),
                'lon' => data_get($attributes, 'lon', $location->lon),
                'street' => data_get($attributes, 'street', $location->street),
                'number' => data_get($attributes, 'number', $location->number),
                'postal' => data_get($attributes, 'postal', $location->postal),
                'city' => data_get($attributes, 'city', $location->city),
                'country' => data_get($attributes, 'country', $location->country),
                'offers_id' => data_get($attributes, 'offers_id', $location->offer_id),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update location');

            return $location;

        });
     }

    /**
     * @param Locations $location
     * @return mixed
     */
    public function forceDelete($location)
    {
        return DB::transaction(function () use($location) {
            $deleted = $location->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete location.");
            return $deleted;
        });
    }

}
