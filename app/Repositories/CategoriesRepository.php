<?php
namespace App\Repositories;

use App\Events\Models\Offers\OffersCreated;
use App\Events\Models\Offers\OffersDeleted;
use App\Events\Models\Offers\OffersUpdated;
use App\Models\Offers;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;

class CategoriesRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = Categories::query()->create([
                    'name' => data_get($attributes, 'name', 'Untitled'),
                    'name_nl' => data_get($attributes, 'name_nl', 'Untitled'),
                    'name_en' => data_get($attributes, 'name_en', 'Untitled'),
                    'name_fr' => data_get($attributes, 'name_fr', 'Untitled'),
                    'description' => data_get($attributes, 'description', 'Untitled'),
                    'description_nl' => data_get($attributes, 'description_nl', 'Untitled'),
                    'description_en' => data_get($attributes, 'description_en', 'Untitled'),
                    'description_fr' => data_get($attributes, 'description_fr', 'Untitled'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create categorie. ');

                return $created;
        });
    }

    /**
     * @param Categories $categorie
     * @param array $attributes
     * @return mixed
     */
    public function update($categorie, array $attributes)
    {
        return DB::transaction(function () use($categorie, $attributes) {
            $updated = $categorie->update([
                'name' => data_get($attributes, 'name', $categorie->name),
                'name_nl' => data_get($attributes, 'name_nl', $categorie->name_nl),
                'name_en' => data_get($attributes, 'name_en', $categorie->name_en),
                'name_fr' => data_get($attributes, 'name_fr', $categorie->name_fr),
                'description' => data_get($attributes, 'description', $categorie->description),
                'description_nl' => data_get($attributes, 'description_nl', $categorie->description_nl),
                'description_en' => data_get($attributes, 'description_en', $categorie->description_en),
                'description_fr' => data_get($attributes, 'description_fr', $categorie->description_fr),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update categorie');
            return $updated;
        });
    }

    /**
     * @param Categories $categorie
     * @return mixed
     */
    public function forceDelete($categorie)
    {
        return DB::transaction(function () use($categorie) {
            $deleted = $categorie->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete categorie.");
            event(new OffersDeleted($categorie));

            return $deleted;
        });
    }

}
