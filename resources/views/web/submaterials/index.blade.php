<x-app-layout>
    <x-slot name="header" >
            <div  class="grid grid-cols-1 md:grid-cols-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Submatrials') }}
                </h2>
                <a href="{{route('web.submaterials.create')}}" style="width: fit-content; justify-self: end; background-color: #42998B; color: white; padding: 0.2rem 2rem; border-radius: 5px;">Maak een nieuw submateriaal</a>
            </div>
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
    <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <h1 class="py-4 text-lg font-medium leading-6 text-gray-900"">Hieronder vind u alle submaterialen die gebruikt kunnen worden op het platfrom.</h1>
                <p>De submaterialen kunnen worden gewijzigd of worden verwijderd.</p>
                <p>U kan de bovenste rij van de tabel gebruiken om te filteren.</p>
            </div>
    </div>

    <div class="py-4">
        <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <livewire:submaterial-table/>
            </div>
        </div>
    </div>
</x-app-layout>
