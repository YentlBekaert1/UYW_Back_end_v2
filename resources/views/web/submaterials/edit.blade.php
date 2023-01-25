<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submateriaal') }}
        </h2>
        <div>
            <a href="/submaterials" class="underline  text-gray-600 hover:text-green-900">Ga terug</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
            <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Wijzig submateriaal.</h3>
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
                        <form method="POST" action="{{ route('web.submaterials.update', $submaterial)}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="name" name="name" value="{{$submaterial->name}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam Nederlands</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="name_nl" name="name_nl" value="{{$submaterial->name_nl}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam Engels</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="name_en" name="name_en" value="{{$submaterial->name_en}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Naam Frans</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="name_fr" name="name_fr" value="{{$submaterial->name_en}}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materiaal om submateriaal aan te koppelen</label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="material" name="material_id" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                        <option value="">Selecteer</option>
                                            @foreach($materials as $material)
                                                <option value="{{ $material->id }}" @if($material->id == $submaterial->material_id ) selected @endif>{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div

                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Bewaar submateriaal</button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script type="text/javascript">

        $("#dynamic-ar").click(function () {
            console.log("click")
            ++i;
            $("#dynamicAddRemove").append('<tr><td class="px-1 py-2 whitespace-nowrap text-sm "><input type="text" name="submaterials[' + i +
                '][name]" placeholder="Geef naam" class="mt-1 focus:ring-green-500 focus:border-green-500  w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />   <input type="text" id="sub" name="" placeholder="Geef naam" value="undefined" class="hidden mt-1 focus:ring-green-500 focus:border-green-500  w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></td><td class="px-1 py-2 whitespace-nowrap text-sm "><button type="button" class="remove-input-field inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Delete</button></td></tr>'
            );
        });
        $(document).on('click', '.remove-input-field', function () {
            console.log(this.parentElement.parentElement);
            if($(this).parents('tr').find("#sub")[0].value !== undefined){
                 $("#submaterials_to_delete").append('<input multiple type="text" name="submaterials_to_delete[]" value="'+ $(this).parents('tr').find("#sub")[0].value +'" class="hidden mt-1 focus:ring-green-500 focus:border-green-500  w-full shadow-sm sm:text-sm border-gray-300 rounded-md">')
            }
            this.parentElement.parentElement.remove();
        });
    </script>
</x-app-layout>
