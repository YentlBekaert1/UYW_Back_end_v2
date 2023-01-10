<?php

namespace App\Charts;

use App\Models\Categories;
use App\Models\Offers;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class AddedoffersLastYear
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $categorie_ids = Categories::query()->pluck('id')->toArray();
        $categorie_names = Categories::query()->pluck('name')->toArray();
        //dd($categroie_ids , $categorie_names);

        $items = Offers::select(
            DB::raw("COUNT(*) as count"),
            DB::raw("MONTHNAME(created_at) as month_name")
        );

        for($i =0; $i<count($categorie_ids); $i++){
            $items =$items->addSelect(
                DB::raw("sum(case when categories_id = $categorie_ids[$i] then 1 else 0 end) AS $categorie_names[$i]")
            );
        }

        $items = $items->whereYear('created_at', date('Y')-1)
        ->groupBy('month_name')
        ->orderBy('month_name', 'desc')
        ->get()
        ->toArray();


        $string = "Toegevoegde items per categorie voor vorig jaar";
        $chartreturn = $this->chart->barChart()
        ->setTitle($string)
        ->setSubtitle('Overzicht van het laatste jaar.')
        ->setXAxis(array_column($items, 'month_name'));

        for($i =0; $i<count($categorie_ids); $i++){
            $chartreturn->addData($categorie_names[$i], array_column($items, $categorie_names[$i]));
        }

        return $chartreturn;
    }
}
