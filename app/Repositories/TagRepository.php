<?php
namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = Tag::query()->create([
                    'name' => data_get($attributes, 'name', 'Untitled'),
                    'name_nl' => data_get($attributes, 'name_nl', 'Untitled'),
                    'name_en' => data_get($attributes, 'name_en', 'Untitled'),
                    'name_fr' => data_get($attributes, 'name_fr', 'Untitled'),
                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create tag. ');

                return $created;
        });
    }

    /**
     * @param Tag $tag
     * @param array $attributes
     * @return mixed
     */
    public function update($tag, array $attributes)
    {
        return DB::transaction(function () use($tag, $attributes) {
            $updated = $tag->update([
                'name' => data_get($attributes, 'name', $tag->name),
                'name_nl' => data_get($attributes, 'name_nl', $tag->name_nl),
                'name_en' => data_get($attributes, 'name_en', $tag->name_en),
                'name_fr' => data_get($attributes, 'name_fr', $tag->name_fr),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update tag');

            return $tag;

        });
    }
    /**
     * @param Tag $tag
     * @return mixed
     */
    public function forceDelete($tag)
    {
        return DB::transaction(function () use($tag) {
            $deleted = $tag->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete tag.");

            return $deleted;
        });
    }

}
