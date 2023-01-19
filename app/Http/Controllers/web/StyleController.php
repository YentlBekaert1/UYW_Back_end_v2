<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StyleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function web(Request $request)
    {
        $url = 'H:\H_Projectjes\backendUYWV3\public\app_styling.scss';
        //"H:\H_Projectjes\backendUYWV3\public\app_styling.scss"
        ///"/home/upcycleyourwaste/public_html/assets/style/style.css"
        $array = array();

        $myfile = fopen($url, "r");
        $res = fread($myfile,filesize($url));
        // while($BUFFER = fgets($myfile)){
        //     array_push($array, $BUFFER);
        // }
        fclose($myfile);
        array_push($array, $res);
        //dd($array);



        return view('web/change_styles/changestyle', ['test' => $array[0]])->with('message', '');
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = 'H:\H_Projectjes\backendUYWV3\public\app_styling.scss';

        $changeddata = $request->newfile;
        //dd($changeddata);

        $myfile = fopen($url, "w");
        fwrite($myfile, $changeddata);
        fclose($myfile);

        $array = array();
        $myfile = fopen($url, "r");
        $res = fread($myfile,filesize($url));
        // while($BUFFER = fgets($myfile)){
        //     array_push($array, $BUFFER);
        // }
        fclose($myfile);
        array_push($array, $res);


        return redirect()->route('web.style.index')->with('message', 'Style succesvol gewijzigd.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function reset(Request $request)
    {
        $url = 'H:\H_Projectjes\backendUYWV3\public\app_styling.scss';
        $url_reset = 'H:\H_Projectjes\backendUYWV3\public\app_styling_reset.scss';

        //get data from reset file
        $resetfile = fopen($url_reset, "r");
        $url_reset_content = fread($resetfile,filesize($url_reset));
        fclose($resetfile);

        //write data from reset file in style file
        $style_file = fopen($url, "w");
        fwrite($style_file, $url_reset_content);
        fclose($style_file);

        $data_array = array();
        $stylefile = fopen($url, "r");
        $url_content = fread($stylefile,filesize($url));
        fclose($stylefile);
        array_push($data_array, $url_content);


        return redirect()->route('web.style.index')->with('message', 'Style succesvol gereset.');
    }

}
