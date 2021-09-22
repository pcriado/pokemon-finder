<?php

namespace App\Http\Services;

use Log; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


/**
 * Connector for the Pokeapi remote service
 * 
 * @see https://pokeapi.co/docs/v2
 * 
 * @version 1.0.0
 */
class PokeapiService extends BaseService {

    protected $protocol = null; 

    protected $endpoint = null; 

    protected $cache_ttl_seconds = null; 

    protected $list_cache_key = null; 


    public function __construct()
    {
        parent::__construct();

        $this->protocol = config('pokesearch.pokeapi.protocol', 'https');
        $this->endpoint = config('pokesearch.pokeapi.endpoint', null);
        $this->cache_ttl_seconds = config('pokesearch.pokeapi.cache_ttl_seconds', 43200);

        if (empty($this->endpoint)) {
            throw new \Exception("Error Processing Request; missing Pokeapi Service endpoint; check your config", 500);            
        }        

        try {
            $this->initPokemonCache(); 
        } catch (\Exception $e) {
            Log::error('Unable to init pokemon list cache');
            throw new \Exception("Error Processing Request; pokemon cache is not working", 500);         
        }
        
    }



    /**
     * Cache all the pokemon names from the remote api
     *
     * @return void
     */
    public function initPokemonCache()
    {   
        $cache_key = $this->list_cache_key = sha1('pokemon_primary_name_list');
        
        if (!Cache::has($cache_key)) {

            $url = $this->protocol . '://' . $this->endpoint . '/pokemon';
            $res = $this->makePokeRequest($url);           
            
            if (!empty($res->count)) {
                $url .= '?offset=0&limit=' . $res->count;
                $res = $this->makePokeRequest($url);  
    
                if (!empty($res->results)) {
                    Cache::put($cache_key, $res->results, $this->cache_ttl_seconds);
                }                        
            }
        }
    }



    /**
     * Search pokemons by ID or Name
     *
     * @param string name or partial name
     * 
     * @return array matching pokemons
     */
    public function findPokemon($keyword)
    {
        $matches = [];
        $list = Cache::get($this->list_cache_key); 

        foreach ($list as $item) {
            if (strpos(strtolower($item->name), strtolower($keyword)) !== false) {
                $matches[] = $item; 
            }
        } 

        return $matches; 
    }



    /**
     * Send an http request to the pokeapi endpoint
     *
     * @param string $url
     * 
     * @return object
     */
    protected function makePokeRequest($url)
    {        
        try {

            Log::info('pokeapi request: ' . $url);

            $cache_key = sha1('pokeapiregularrequest'.$url); 

            if (Cache::has($cache_key)) {
                Log::info('pokeapi CACHED');
                return json_decode(Cache::get($cache_key)); 
            }

            $res = Http::get($url);

            if ($res->ok()) {
                Log::info('pokeapi response: '. $res->body());    
                Cache::put($cache_key, $res->body(), $this->cache_ttl_seconds);
                Log::info('pokeapi LIVE');
                return json_decode($res->body()); 
            }
             
            Log::error('pokeapi response error: HTTP ' . $res->status() . ' | ' . $res->body());
            return false;             

        } catch (\Exception $e) {

            Log::error('PokeapiService exception: '.$e->getMessage());
            Log::error($e->getTraceAsString());
            return false; 
        }        
    }




}