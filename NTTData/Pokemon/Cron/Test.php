<?php

namespace NTTData\Pokemon\Cron;

use Psr\Log\LoggerInterface;
use NTTData\Pokemon\Block\Index\Index;
use NTTData\Pokemon\Model\PokemonsFactory;
use NTTData\Pokemon\Model\ResourceModel\Pokemons\Collection as PokemonsCollection;

class Test
{
    protected $logger;
    protected Index $apiManager;
    protected PokemonsFactory $pokemonsFactory;
    protected PokemonsCollection $pokemonsCollection;

    public function __construct(
        LoggerInterface $logger,
        Index $apiManager,
        PokemonsFactory $pokemonsFactory,
        PokemonsCollection $pokemonsCollection)
    {
        $this->logger = $logger;
        $this->apiManager = $apiManager;
        $this->pokemonsFactory = $pokemonsFactory;
        $this->pokemonsCollection = $pokemonsCollection;
    }
    
    public function execute()
    {
        // me fijo cuantos pokemons hay en la db
        $count = $this->pokemonsCollection->count();
        // establezco el offset para la peticion a la api
        $offset = $count + 1;
        // establezco el limite de pokemons a traer, random entre 1 y 50
        
        $limit = rand(1, 50);        
        // hago la peticion a la api
        $pokemonList = $this->apiManager->getPokemonList($limit, $offset);        
        
        // recorro el array de pokemones y voy creando uno por uno y guardando en la db
        foreach ($pokemonList as $pokemon) {
            $details = $this->apiManager->getPokemonDetails($pokemon['url']);
            $model = $this->pokemonsFactory->create();
            $id = $this->apiManager->getPokemonId($details);
            $model->setData($this->apiManager->getPokemonDetailsById($id));            
            $model->save();
        }

        $this->logger->info(__('%1 pokemons cargados', $limit));
    }
}
