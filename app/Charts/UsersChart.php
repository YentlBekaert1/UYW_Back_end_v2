<?php

namespace App\Charts;

use App\Models\Offers;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class UsersChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {

        // $current_day= now()->day;
        // //dd($current_day);

        // $usersPermonth = array();
        // $currentYear = 0;
        // for($i = 100; $i > 0; $i--) {
        //     if($current_day == 0){
        //         $current_day = 365 + now()->format('L');
        //         $currentYear++;
        //     }
        //      $usersinday =  User::select(
        //         DB::raw("COUNT(*) as count"),
        //         DB::raw("DATE(created_at) as day_name")
        //     )->whereYear('created_at', date('Y'))
        //     ->whereDay('created_at', $current_day)
        //     ->groupBy('day_name')
        //     ->orderBy('day_name', 'desc')
        //     ->get()
        //     ->toArray();



        //     array_push($usersPermonth,array_shift($usersinday));
        //     $current_day--;
        // }
        // //dd($usersPermonth);

        // array_reverse($usersPermonth);

        $users = DB::table("users")
        ->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DATE(created_at) as day_name"))
        ->where('created_at', '>', now()->subDays(30)->endOfDay())
        ->groupBy('day_name')
        ->orderBy('day_name', 'desc')
        ->get()
        ->toArray();
        //dd($users);

        return $this->chart->lineChart()
            ->setTitle('Nieuwe gebruikers in de laatste 30 dagen')
            ->addLine('new users', array_column($users, 'count'))
            ->setXAxis(array_column($users, 'day_name'))
            ->setColors(['#ffc63b', '#ff6384']);
    }
}
