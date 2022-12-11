<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Http\Requests\Storecontact_usRequest;
use App\Http\Requests\Updatecontact_usRequest;
use App\Http\Resources\ContactusResource;
use App\Mail\ContactUsResponseMail;
use App\Repositories\ContactusRepository;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = ContactUs::query()->get();
        return ContactusResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storecontact_usRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storecontact_usRequest $request, ContactusRepository $repository)
    {
        $created = $repository->create($request->only([
            'email',
            'question',
        ]));
        if($created){
            Mail::to($request->email)
            ->send(new ContactUsResponseMail($created));
        }
        return new ContactusResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function show(ContactUs $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatecontact_usRequest  $request
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function update(Updatecontact_usRequest $request, ContactUs $contact, ContactusRepository $repository)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUs $contact, ContactusRepository $repository)
    {
        //
    }
}
