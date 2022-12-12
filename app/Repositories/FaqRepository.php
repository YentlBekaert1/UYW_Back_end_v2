<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\faq;
use Illuminate\Support\Facades\Auth;

class FaqRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = faq::query()->create([
                    'title' => data_get($attributes, 'title'),
                    'description' => data_get($attributes, 'description'),
                    'title_nl' => data_get($attributes, 'title_nl'),
                    'description_nl' => data_get($attributes, 'description_nl'),
                    'title_en' => data_get($attributes, 'title_en'),
                    'description_en' => data_get($attributes, 'description_en'),
                    'title_fr' => data_get($attributes, 'title_fr'),
                    'description_fr' => data_get($attributes, 'description_fr'),

                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create faq. ');

                return $created;
        });
    }

    /**
     * @param Categories $categorie
     * @param array $attributes
     * @return mixed
     */
    public function update($contact, array $attributes)
    {
        return DB::transaction(function () use($contact, $attributes) {
            $updated = $contact->update([
                'title' => data_get($attributes, 'title', $contact->title),
                'description' => data_get($attributes, 'description', $contact->description),
                'title_nl' => data_get($attributes, 'title_nl', $contact->title_nl),
                'description_nl' => data_get($attributes, 'description_nl', $contact->description_nl),
                'title_en' => data_get($attributes, 'title_en', $contact->title_en),
                'description_en' => data_get($attributes, 'description_en', $contact->description_en),
                'title_fr' => data_get($attributes, 'title_fr', $contact->title_fr),
                'description_fr' => data_get($attributes, 'description_fr', $contact->description_fr),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update faq');
            return $updated;
        });
    }

    /**
     * @param Categories $categorie
     * @return mixed
     */
    public function forceDelete($faq)
    {
        return DB::transaction(function () use($faq) {
            $deleted = $faq->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete faq.");
            return $deleted;
        });
    }

}
