<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Approach;
use Illuminate\Support\Facades\Auth;

class ApproachesRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = Approach::query()->create([
                    'name' => data_get($attributes, 'name', 'Untitled'),
                    'name_nl' => data_get($attributes, 'name_nl', 'Untitled'),
                    'name_en' => data_get($attributes, 'name_en', 'Untitled'),
                    'name_fr' => data_get($attributes, 'name_fr', 'Untitled'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create appraoch. ');

                return $created;
        });
    }

    /**
     * @param Approach $approach
     * @param array $attributes
     * @return mixed
     */
    public function update($approach, array $attributes)
    {
        return DB::transaction(function () use($approach, $attributes) {
            $updated = $approach->update([
                'name' => data_get($attributes, 'name', $approach->name),
                'name_nl' => data_get($attributes, 'name_nl', $approach->name_nl),
                'name_en' => data_get($attributes, 'name_en', $approach->name_en),
                'name_fr' => data_get($attributes, 'name_fr', $approach->name_fr),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update material');

            return $approach;

        });
    }
    /**
     * @param Approach $approach
     * @return mixed
     */
    public function forceDelete($approach)
    {
        return DB::transaction(function () use($approach) {
            $deleted = $approach->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete material.");

            return $deleted;
        });
    }

}
