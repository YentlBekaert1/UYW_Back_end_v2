<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class OffersInCategory
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $categories =  \App\Models\Categories::get()->all();
        $categories_names =  \App\Models\Categories::query()->pluck('name')->toArray();
        $data_array = array();
        foreach ($categories as $categorie){
            $offers =  \App\Models\Offers::query()->where('categories_id', '=', $categorie->id)->count();
            array_push($data_array, $offers);
        }


        return $this->chart->donutChart()
            ->setTitle('Items per categorie')
            ->addData($data_array)
            ->setLabels($categories_names);
    }
}
