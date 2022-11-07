<x-app-layout>
    <x-slot name="header" >
            <div  class="grid grid-cols-1 md:grid-cols-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Users') }}
                </h2>
                <a href="{{route('web.users.create')}}" style="width: fit-content; justify-self: end; background-color: #42998B; color: white; padding: 0.2rem 2rem; border-radius: 5px;">CREATE NEW</a>
            </div>
    </x-slot>

    <div class="py-12">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <livewire:user-table/>
            </div>
 
    </div>
</x-app-layout>
