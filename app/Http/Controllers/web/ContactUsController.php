<?php

namespace App\Http\Controllers\web;

use App\Models\ContactUs;
use App\Http\Requests\Storecontact_usRequest;
use App\Http\Requests\Updatecontact_usRequest;
use App\Http\Resources\ContactusResource;
use App\Mail\ContactUsResponseMail;
use App\Repositories\ContactusRepository;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\ContactUsResponseMail2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $contact_us = ContactUs::query()->paginate($pageSize);
        return view('web.contact_us.index', compact('contact_us'));
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

    public function response(Request $request, ContactUs $contact_us)
    {

        return view('web.contact_us.response')->with('contact_us', $contact_us);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updatecontact_usRequest  $request
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function sendresponse(Request $request, ContactUs $contact_us, ContactusRepository $repository)
    {
        if($request->response){
            $contact = $repository->update($contact_us, $request->only([
                'response'
            ]));
            if($contact){
                Mail::to($contact_us->email)
                ->send(new ContactUsResponseMail2($contact_us));
            }
        }
        return redirect()->route('web.contact_us.index')->with('message', 'Vraag succesvol beantwoord.');
    }


    public function delete(Request $request, ContactUs $contact_us)
    {

        return view('web.contact_us.delete')->with('contact_us', $contact_us);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\contact_us  $contact_us
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactUs $contact_us, ContactusRepository $repository)
    {
    $deleted = $repository->forceDelete($contact_us);
       return redirect()->route('web.contact_us.index')->with('message', 'Vraag succesvol verwijderd.');
    }
}
