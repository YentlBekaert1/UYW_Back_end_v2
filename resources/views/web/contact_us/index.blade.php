<x-app-layout>
    <x-slot name="header" >
            <div  class="grid grid-cols-1 md:grid-cols-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('User Questions') }}
                </h2>
            </div>
    </x-slot>

    <div class="py-12">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <livewire:contact-us-table/>
            </div>

    </div>
</x-app-layout>
