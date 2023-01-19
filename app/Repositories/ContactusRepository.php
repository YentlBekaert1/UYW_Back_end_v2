<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralJsonException;
use App\Models\Categories;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Auth;

class ContactusRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

                $created = ContactUs::query()->create([
                    'email' => data_get($attributes, 'email'),
                    'question' => data_get($attributes, 'question'),

                ]);

                throw_if(!$created, GeneralJsonException::class, 'Failed to create contact. ');

                return $created;
        });
    }

    /**
     * @param Categories $categorie
     * @param array $attributes
     * @return mixed
     */
    public function update($contact_us, array $attributes)
    {
        return DB::transaction(function () use($contact_us, $attributes) {
            $updated = $contact_us->update([
                'response' => data_get($attributes, 'response', $contact_us->response),
            ]);

            throw_if(!$updated, GeneralJsonException::class, 'Failed to update contact');
            return $updated;
        });
    }

    /**
     * @param Categories $categorie
     * @return mixed
     */
    public function forceDelete($contact_us)
    {
        return DB::transaction(function () use($contact_us) {
            $deleted = $contact_us->forceDelete();

            throw_if(!$deleted, GeneralJsonException::class, "cannot delete question.");
            return $deleted;
        });
    }

}
