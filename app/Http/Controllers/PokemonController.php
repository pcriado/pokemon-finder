<?php

namespace App\Http\Controllers;

use Log;
use App\Http\Controllers\ApiController;
use App\Http\Services\PokeapiService;

/**
 * Pokemon controller handles all pokemon search functions
 * 
 * @version 1.0.0
 */
class PokemonController extends ApiController {


    /**
     * GET
     *  /api/v1/pokesearch?keyword=
     * 
     * Search partial and full pokemon name
     *
     * @return object json response
     */
    public function search()
    {
        try {

            $keyword = $this->request->input('keyword', null);

            if (empty($keyword)) {
                return response()->json(['error' => 'Missing parameters'], 400);
            }

            $pokapi = new PokeapiService(); 

            $res = $pokapi->findPokemon($keyword); 
    
            return response()->json($res, 200);

        } catch (\Exception $e) {

            Log::error('PokemonController search exception ' . $e->getMessage() . ' | ' . $e->getTraceAsString());
            return response()->json(['error' => 'Application error', 'message' => $e->getMessage()], 500);
        }
    }




}