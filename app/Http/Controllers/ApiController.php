<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Api base controller adds before filter
 * 
 * @version 1.0.0
 */
class ApiController extends Controller {

    protected $request; 


    public function __construct(Request $request)
    {        
        $this->request = $request;
        
        $this->beforeFilter();
    }



    public function beforeFilter()
    {
        //
    }

}