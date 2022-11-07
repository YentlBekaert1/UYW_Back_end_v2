<x-app-layout>
<x-slot name="header" >
            <div  class="grid grid-cols-1 md:grid-cols-2">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Categories') }}
                </h2>
                <a href="{{route('web.categories.create')}}" style="width: fit-content; justify-self: end; background-color: #42998B; color: white; padding: 0.2rem 2rem; border-radius: 5px;">CREATE NEW</a>
            </div>
    </x-slot>
    <div class="py-12">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg sm:px-6 lg:px-8 py-5">
                <div>
                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <x-jet-validation-errors class="mb-4" />
                </div>
                <livewire:category-table/>

        </div>
    </div>
</x-app-layout>
<script>
            window.addEventListener('showAlert', event => {
                alert(event.detail.message);
            })
</script>
