<?php

namespace NTTData\Pokemon\Block\Index;

// declare(strict_types=1);

use Magento\Backend\Block\Template\Context;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use NTTData\Pokemon\Helper\Data;

class Index extends \Magento\Framework\View\Element\Template
{
    private Data $helper;
    private $responseFactory;
    private $clientFactory;
    private $apiUrl;
    private $apiEndpoint;

    public function __construct(
        Context $context,
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory,
        Data $helper
    ) {
        parent::__construct($context);
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
        $this->helper = $helper;
        $this->apiUrl = $this->helper->getUrl();
        $this->apiEndpoint = $this->helper->getEndpoint();
    }

    private function doRequest(string $uriEndpoint, string $requestMethod = Request::HTTP_METHOD_GET): Response
    {
        $client = $this->clientFactory->create(['config' => ['base_uri' => $this->apiUrl]]);
        try {
            $response = $client->request($requestMethod, $uriEndpoint,);
        } catch (GuzzleException $exception) {
            $response = $this->responseFactory->create(['status' => $exception->getCode(), 'reason' => $exception->getMessage()]);
        }
        return $response;
    }

    // Traigo un array de pokemones.
    public function getPokemonList(): array
    {
        $response = $this->doRequest($this->apiEndpoint);
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

    // No encuentro de donde salen las generaciones.    
    public function getPokemonGeneration(array $details): string
    {
        // Placeholder
        return '';
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
}
