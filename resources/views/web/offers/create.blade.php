<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Items') }}
        </h2>
        <div>
            <a href="/offers" class="underline  text-gray-600 hover:text-green-900">Ga terug</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
            <div>
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <div class="px-4 sm:px-0">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Create a new item.</h3>
                                <p class="mt-1 text-sm text-gray-600">This info is shared on the applications.</p>
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
                        <form method="POST" action="{{ route('web.offers.store')}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                        @csrf
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div class="grid grid-cols-2 gap-6">

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700"> Title </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" id="title" name="title" value="" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700"> Description </label>
                                    <div class=" flex rounded-md shadow-sm">
                                    <textarea rows="4" cols="50" type="text" id="description" name="description" value="" autofocus class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300  rounded-md"></textarea>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="category" class="block text-sm font-medium text-gray-700"> Category </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="category" name="category" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @foreach($categories as $category )
                                            <option value="{{ $category->id }}" @if(old('category') == $category->id ) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="approach" class="block text-sm font-medium text-gray-700"> Approach </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="approach" name="approach" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @foreach($approaches as $approach)
                                            <option value="{{ $approach->id }}" @if(old('approach') == $approach->id ) selected @endif>{{ $approach->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="material" class="block text-sm font-medium text-gray-700"> Materials </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="material" name="material" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        <option value="">Select</option>
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}" @if(old('material') == $material->id ) selected @endif>{{ $material->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="submaterial" class="block text-sm font-medium text-gray-700"> Submaterials </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id="submaterial" name="submaterial" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Select first a material</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                       <button type="button" id="add_material_submaterial" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add material/submaterial to list</button>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <div>
                                        <input type="hidden" name="materials" id="materials_array" value="">
                                        <input type="hidden" name="submaterials" id="submaterials_array" value="">
                                        <h4>Material/submaterial list:</h4>
                                        <div id="material_submaterial_list">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="tag" class="block text-sm font-medium text-gray-700"> Tags </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id="tag" name="tag" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}" @if(old('tag') == $tag->id ) selected @endif>{{ $tag->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <button type="button" id="add_tag" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add tag to list</button>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="newtag" class="block text-sm font-medium text-gray-700"> New Tag </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <input type="text" name="newtag" id="newtag" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                     <button type="button" id="add_new_tag" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Add new tag to list</button>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <div>
                                        <input type="hidden" name="tags" id="tags_array" value="">
                                        <input type="hidden" name="newtags" id="newtags_array" value="">
                                        <h4>Tags list:</h4>
                                        <div id="tags_list">

                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="contact" class="block text-sm font-medium text-gray-700"> Contact </label>
                                    <div class=" flex rounded-md shadow-sm">
                                    <input type="text" name="contact" id="contact" value="" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="url" class="block text-sm font-medium text-gray-700"> URL </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="url" id="url" value="" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="user_id" class="block text-sm font-medium text-gray-700"> User </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="user_id" name="user_id" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" @if(old('user') == $user->id ) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="status" class="block text-sm font-medium text-gray-700"> Status </label>
                                    <div class=" flex rounded-md shadow-sm">
                                        <select id ="category" name="status" class="form-control mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            <option value="1">online</option>
                                            <option value="0">offline</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-span-3 sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700"> Images </label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <input id="image" name="images[]" type="file" multiple class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                </label>
                                                <!-- <p class="pl-1">or drag and drop</p> -->
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                            <div id="images">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-3 sm:col-span-2">
                                    <label for="street" class="block text-sm font-medium text-gray-700"> Street and number </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="street" id="streetnumber" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" >
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="city" class="block text-sm font-medium text-gray-700"> City </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="city" id="city" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" >
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="country" class="block text-sm font-medium text-gray-700"> Country </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="country" id="country" class="focus:ring-green-500 focus:border-green-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300" >
                                    </div>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                   <button type="button" id="search_location" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Search Location</button>
                                </div>
                                <div class="col-span-3 sm:col-span-2">
                                    <h4>Choosed location:</h4>
                                    <input type="hidden" name="lat" id="lat">
                                    <input type="hidden" name="lon" id="lon">
                                    <div id="choosed_location">

                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
        var materials_array = new Array;
        var submaterials_array = new Array;
        var tag_array = new Array;
        var new_tag_array = new Array;

        window.addEventListener("load", ()=>{
            console.log('loaded');

            //js for images
            document.getElementById('image').addEventListener("change", (e)=>{
                const files = e.target.files;
                console.log(files);
                if(files.length > 0){
                    document.getElementById('images').innerHTML = "";
                    for (let i = 0; i < files.length; i++) {
                        let file = files.item(i);
                        let img = document.createElement("img");
                        img.src = URL.createObjectURL(file)
                        img.style = "max-height:100px; max-width:100px; display:inline-block; margin-right:10px;"
                        img.addEventListener("click", (e)=>console.log(e));
                        console.log(file.name);
                        document.getElementById('images').append(img);
                    }
                }
            });


            $(document).on('click', '#add_material_submaterial', function () {
                var mat = $('#material')[0].value;
                var submat = $('#submaterial')[0].value;
                if(mat !== ""){
                    materials_array.push(mat);
                }
                if(mat !== "" && submat!== ""){
                    submaterials_array.push(submat);
                }
                $('#materials_array')[0].value = materials_array;
                $('#submaterials_array')[0].value = submaterials_array;

                $('#material_submaterial_list').append('<p mat_attribute="'+mat+'" submat_attribute="'+submat+'">' + $('#material')[0].selectedOptions[0].label + ' ,'
                + $('#submaterial')[0].selectedOptions[0].label +"   "+'<span class="remove_from_material_list inline-flex justify-center border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">delete</span></p>');
            });

            $(document).on('click', '.remove_from_material_list', function () {
               materials_array.splice(materials_array.findIndex((el)=> el == $(this).parents('p')[0].attributes.mat_attribute.value),1);
               submaterials_array.splice(submaterials_array.findIndex((el)=> el == $(this).parents('p')[0].attributes.submat_attribute.value),1);
               $('#materials_array')[0].value = materials_array;
               $('#submaterials_array')[0].value = submaterials_array;
               $(this).parents('p').remove();
            });

            //js for submaterials by material
            $("#material").change(function(){
                    var id=$(this).val();
                    $.ajax({
                        type: "GET",
                        url: "{{url('/api/materialsubmaterials')}}"+"/" + id,
                        success: function(res){
                            $('#submaterial').html('');
                            $('#submaterial').append('<option value="">Selecteer</option>');
                            console.log(res.data);
                            $(res.data).each((i)=>{
                                console.log( i + ": " + res.data[i]);
                                $('#submaterial').append('<option value="' + res.data[i].id + '">' + res.data[i].name + '</option>');
                            });
                        }
                    });

            });

            $(document).on('click', '#add_tag', function () {
                var tag = $('#tag')[0].value;

                if(tag !== ""){
                    tag_array.push(tag);
                }

                $('#tags_array')[0].value = tag_array;

                $('#tags_list').append('<p tag_attribute="'+tag+'">' + $('#tag')[0].selectedOptions[0].label + "   "+
                '<span class="remove_from_tag_list inline-flex justify-center border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">delete</span></p>');
            });

            $(document).on('click', '.remove_from_tag_list', function () {
               tag_array.splice(tag_array.findIndex((el)=> el == $(this).parents('p')[0].attributes.tag_attribute.value),1);
               $('#tags_array')[0].value = tag_array;
               $(this).parents('p').remove();
            });

            $(document).on('click', '#add_new_tag', function () {
                var tag = $('#newtag')[0].value;
                if(tag !== ""){
                    new_tag_array.push(tag);
                }
                $('#newtags_array')[0].value = new_tag_array;
                $('#tags_list').append('<p tag_attribute="'+tag+'">' + tag + "   "+
                '<span class="remove_from_new_tag_list inline-flex justify-center border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">delete</span></p>');
                console.log(new_tag_array);
            });

            $(document).on('click', '.remove_from_new_tag_list', function () {
                new_tag_array.splice(new_tag_array.findIndex((el)=> el == $(this).parents('p')[0].attributes.tag_attribute.value),1);
               $('#newtags_array')[0].value = new_tag_array;
               $(this).parents('p').remove();
            });

            $(document).on('click', '#search_location', function () {
                const street_number = $('#streetnumber')[0].value;
                const city = $('#city')[0].value;
                const country = $('#country')[0].value;
                const query = street_number + '+' + city + '+' + country;
                $.ajax({
                        type: "GET",
                        url: "https://nominatim.openstreetmap.org/search?q="+ query + "&format=json&limit=1",
                        headers: {"Access-Control-Allow-Origin": "*"},
                        success: function(res){
                           console.log(res[0].lat, res[0].lon);
                           $('#lat')[0].value = res[0].lat;
                           $('#lon')[0].value = res[0].lon;
                           $('#choosed_location').html("");
                           $('#choosed_location').append('<p>' + street_number + " " + city + " " + country +'</p>');
                           $('#choosed_location').append('<p>' + "lat: "+ res[0].lat + " lon: " + res[0].lon +'</p>');
                        }
                    });
            });

        });
    </script>
</x-app-layout>
