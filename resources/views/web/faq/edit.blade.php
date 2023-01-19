<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bewerken van de vraag') }}
        </h2>
        <div>
            <a href="/categories" class="underline  text-gray-600 hover:text-green-900">Ga terug</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Bewerk de vraag</h3>
                                <p>Deze vraag zal worden getoont op de Freqeuntly Asked Quetions pagina van de applicatie.</p>
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
                        <form method="POST" action="{{ route('web.faq.update', $faq)}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Titel</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="title" name="title" value="{{$faq->title}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Titel Nederlands</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="title_nl" name="title_nl" value="{{$faq->title_nl}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Titel Engels</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="title_en" name="title_en" value="{{$faq->title_en}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Titel Frans</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="title_fr" name="title_fr" value="{{$faq->title_fr}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="description" name="description" value="{{$faq->description}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving Nederlands</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="description_nl" name="description_nl" value="{{$faq->description_nl}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving Engels</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="description_en" name="description_en" value="{{$faq->description_en}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Beschrijving Frans</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="description_fr" name="description_fr" value="{{$faq->description_fr}}" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Bewaar</button>
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
