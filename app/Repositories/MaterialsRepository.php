<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Material;
use Illuminate\Support\Facades\Auth;

class MaterialsRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = Material::query()->create([
                    'name' => data_get($attributes, 'name', 'Untitled'),
                    'name_nl' => data_get($attributes, 'name_nl', 'Untitled'),
                    'name_en' => data_get($attributes, 'name_en', 'Untitled'),
                    'name_fr' => data_get($attributes, 'name_fr', 'Untitled'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create material. ');

                return $created;
        });
    }

    /**
     * @param Material $material
     * @param array $attributes
     * @return mixed
     */
    public function update($material, array $attributes)
    {
        return DB::transaction(function () use($material, $attributes) {
            $updated = $material->update([
                'name' => data_get($attributes, 'name', $material->name),
                'name_nl' => data_get($attributes, 'name_nl', $material->name_nl),
                'name_en' => data_get($attributes, 'name_en', $material->name_en),
                'name_fr' => data_get($attributes, 'name_fr', $material->name_fr),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update material');

            return $material;

        });
    }
    /**
     * @param Material $material
     * @return mixed
     */
    public function forceDelete($material)
    {
        return DB::transaction(function () use($material) {
            $deleted = $material->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete material.");

            return $deleted;
        });
    }

}
