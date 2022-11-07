<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\SubMaterial;
use Illuminate\Support\Facades\Auth;

class SubMaterialsRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = SubMaterial::query()->create([
                    'name' => data_get($attributes, 'name', 'Untitled'),
                    'name_nl' => data_get($attributes, 'name_nl', 'Untitled'),
                    'name_en' => data_get($attributes, 'name_en', 'Untitled'),
                    'name_fr' => data_get($attributes, 'name_fr', 'Untitled'),
                    'material_id' => data_get($attributes, 'material_id'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create submaterial. ');

                return $created;
        });
    }

    /**
     * @param SubMaterial $submaterial
     * @param array $attributes
     * @return mixed
     */
    public function update($submaterial, array $attributes)
    {

        return DB::transaction(function () use($submaterial, $attributes) {
            $updated = $submaterial->update([
                'name' => data_get($attributes, 'name', $submaterial->name),
                'name_nl' => data_get($attributes, 'name_nl', $submaterial->name_nl),
                'name_en' => data_get($attributes, 'name_en', $submaterial->name_en),
                'name_fr' => data_get($attributes, 'name_fr', $submaterial->name_fr),
                'material_id' => data_get($attributes, 'material_id', $submaterial->material_id),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update submaterial');

            return $submaterial;

        });
     }

    /**
     * @param SubMaterial $submaterial
     * @return mixed
     */
    public function forceDelete($submaterial)
    {
        return DB::transaction(function () use($submaterial) {
            $deleted = $submaterial->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete submaterial.");
            return $deleted;
        });
    }

}
