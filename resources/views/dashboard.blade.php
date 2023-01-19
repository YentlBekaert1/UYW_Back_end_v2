<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
               <h1 class="py-4 text-lg font-medium leading-6 text-gray-900"">Welkom op de administrator pagina van de Lets's Upcycle applicatie.</h1>
               <p>Hieronder vind u enkele grafieken die info geven over de toegevoegde data.</p>
               <p>Verder kunt u ook de data beheren door in de navigatie naar de tabellen te navigeren.</p>
               <p>Bij de site instellingen kan u de kleuren van de applicatie wijzigen.</p>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" px-4 py-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {!! $chart->container() !!}
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {!! $chart2->container() !!}
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 py-8 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                {!! $chart3->container() !!}
            </div>
        </div>
    </div>
    <script src="{{ $chart->cdn() }}"></script>
    {{ $chart->script() }}
    {{ $chart2->script() }}
    {{ $chart3->script() }}
</x-app-layout>
