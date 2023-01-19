<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('change style') }}
        </h2>
    </x-slot>
    
    @if (session()->has('message'))
    <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session('alert-class') == 'alert-danger')
        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md" role="alert">
        @else
        <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
        @endif
            <div class="flex">
                <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                <div>
                <p class="font-bold">{{ session('message') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <div>
                    @if($message)
                        <div class="alert alert-success">
                            {{$message}}
                        </div>
                    @endif
                    <x-jet-validation-errors class="mb-4" />
                </div>
                <form method="POST" action="{{ route('web.style.store')}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-2 gap-6">
                            <div class="col-span-3 sm:col-span-2">
                                <div class=" flex rounded-md shadow-sm">
                                    <textarea name="newfile" id="newfile"  rows="20" autofocus style="width:100%; padding: 2%" class="mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{$test}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save</button>
                        </div>
                    </div>
                </form>
                <form method="POST" action="{{ route('web.style.reset')}}" class="mt-8 space-y-6" enctype="multipart/form-data">
                    @csrf
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
