<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beantwoord vraag') }}
        </h2>
        <div class="py-4">
            <a href="/contact_us" class="underline  text-gray-600 hover:text-green-900">Ga terug</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 py-6">Beantwoord vraag</h3>
                                <p class="py-2">Hier kun je antwoorden op de vraag van een gerbuiker van de applicatie. </p>
                                <p class="">De gebruiker zal daarna een email krijgen met het antwoord op geformuleerd.</p>
                            </div>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                        <div>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <x-jet-validation-errors class="mb-4" />
                        </div>
                        <form method="POST" action="{{ route('web.contact_us.sendresponse', $contact_us)}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">
                                    <div class="col-span-3 sm:col-span-2">
                                        <h1 class="text-lg font-medium leading-6 text-gray-900">Info over de vraag:</h1>
                                        <p>Email zender vraag: {{$contact_us->email}}</p>
                                        <p>Vraag: {{$contact_us->question}}</p>
                                    </div>
                                    <div class="col-span-3 sm:col-span-2">
                                        <h2 class="text-lg font-medium leading-6 text-gray-900 py-4">Antwoord op de vraag:</h2>
                                        <div class=" flex rounded-md shadow-sm">
                                        <textarea rows="4" cols="50" type="text" id="response" name="response" value="" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300  rounded-md"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Verzend antwoord</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
