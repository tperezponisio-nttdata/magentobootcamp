<?php

namespace NTTData\Pokemon\Block\Index;

use Magento\Backend\Block\Template\Context;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use NTTData\Pokemon\Helper\Data;
use Magento\Store\Model\StoreManagerInterface;

class Index extends \Magento\Framework\View\Element\Template
{
    private Data $helper;
    private $responseFactory;
    private $clientFactory;
    private $apiUrl;
    private $apiEndpoint;
    protected $storeManager;

    public function __construct(
        Context $context,
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Data $helper,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->helper = $helper;
        $this->apiUrl = $this->helper->getUrl();
        $this->apiEndpoint = 'pokemon/'; // ahora el offset esta al pedo, pero es para correr n veces desde donde empieza a traer info
        $this->storeManager = $storeManager;
    }

    private function doRequest(string $uriEndpoint, int $limit = null, int $offset = null, string $requestMethod = Request::HTTP_METHOD_GET): Response
    {
        // Adding the limit and offset parameters to the query if they are provided
        if ($limit !== null && $offset !== null) {
            $uriEndpoint .= '?limit=' . $limit . '&offset=' . $offset;
        }
        $client = $this->clientFactory->create(['config' => ['base_uri' => $this->apiUrl]]);
        try {
            $response = $client->request($requestMethod, $uriEndpoint,);
        } catch (GuzzleException $exception) {
            $response = $this->responseFactory->create(['status' => $exception->getCode(), 'reason' => $exception->getMessage()]);
        }
        return $response;
    }

    // Traigo un array de pokemones.
    public function getPokemonList(int $limit = null, int $offset = null): array
    {        
        // if (!$this->storeViewChecker()) {
        //     return []; // Devuelve un array vacío si el Store View no es el correcto
        // }
        // si me pasan limite y offset se pasan a doRequest, si no sale con los valores por default, limit = 20 y offset = 0
        $response = $this->doRequest($this->apiEndpoint, $limit, $offset);
        return json_decode($response->getBody()->getContents(), true)['results'];
    }

    // Traigo los datos de un pokemon. La uso recorriendo el array de pokemones.
    public function getPokemonDetails(string $url): array
    {
        // 1. Check if the Pokemon details for the given URL is already set in the cache
        if (!isset($this->pokemonDetailsCache[$url])) {
            // 2. If not, perform a request to fetch the Pokemon details
            $response = $this->doRequest(str_replace($this->apiUrl, '', $url));
            $this->pokemonDetailsCache[$url] = json_decode($response->getBody()->getContents(), true);
        }
        return $this->pokemonDetailsCache[$url];
    }

    public function getPokemonId(array $details): int
    {
        return $details['id'];
    }

    public function getPokemonName(array $details): string
    {
        return ucfirst($details['name']);
    }

    public function getPokemonHeight(array $details): int
    {
        return $details['height'];
    }

    public function getPokemonWeight(array $details): int
    {
        return $details['weight'];
    }

    public function getPokemonType(array $details): string
    {
        return ucfirst($details['types'][0]['type']['name']);
    }

    public function getPokemonImage(array $details): string
    {
        return $details['sprites']['other']['official-artwork']['front_default'];
    }

    public function getPokemonGeneration(array $details): string
    {
        $generationsData = $details['sprites']['versions'];
        $generations = array_keys($generationsData);

        return ucfirst(implode(', ', $generations));
    }

    public function getPokemonRegions(string $encountersUrl): string
    {
        $response = $this->doRequest(str_replace($this->apiUrl, '', $encountersUrl));
        $encountersData = json_decode($response->getBody()->getContents(), true);

        // si $encountersData esta vacío o no es un array, devuelve 'N/A'
        if (empty($encountersData) || !is_array($encountersData)) {
            return 'N/A';
        }

        $regions = [];
        foreach ($encountersData as $encounter) {
            $regions[] = $encounter['location_area']['name'];
        }

        return ucwords(implode(', ', $regions));
    }

    // Traigo la info de un pokemon que voy a guardar en la db por su id
    // Datos que traigo: id / name / img_url / type / generations / regions
    public function getPokemonDetailsById(int $id): array
    {
        $urlEndpoint = $this->apiEndpoint . $id;
        $response = $this->doRequest($urlEndpoint);
        $details = json_decode($response->getBody()->getContents(), true);
        $pokemonDetails = [
            // ID lo dejo comentado porque si no no guarda en la db
            // 'id' => $id,
            'name' => $this->getPokemonName($details),
            'img_url' => $this->getPokemonImage($details),
            'type' => $this->getPokemonType($details),
            'generations' => $this->getPokemonGeneration($details),
            'regions' => $this->getPokemonRegions($details['location_area_encounters'])
        ];
        return $pokemonDetails;
    }

    private function storeViewChecker(): bool
    {
        $storeViewCode = $this->storeManager->getStore()->getCode();
        if ($storeViewCode != 'pokemons_store_view') {
            return false;
        }
        return true;
    }
}
