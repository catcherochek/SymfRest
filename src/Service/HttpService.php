<?php
namespace  App\Service;

use Buzz\Client\FileGetContents;
use DOMXPath;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HttpService
 * For Scrapping from page
 * @package App\Service
 */
class HttpService{
    private $browser;
    public function __construct()
    {

    }

    /** Reads all data from url
     * @param String $path -www.google.com
     * @param String $type - GET POST
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     */
    public function readData(String $path, String $type = "GET"){
        if (strpos($path,'http')===false)
            $path = 'http://'.$path;
        $request = new Request('GET', $path);

        $client = new FileGetContents(new Psr17Factory(), ['allow_redirects' => true]);
        return  $response = $client->sendRequest($request, ['timeout' => 4]);
    }

    /**
     * Reads htmlm gets xpath values from it
     * @param String $path  www.google.com
     * @param String $xpath - xpath
     * @param String $type - GET, POST .....
     * @return array - of results
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function readDatabyXPath(String $path, String $xpath, String $type = "GET")
    {
        $out = $this->readData($path,$type)->getBody()->getContents();

        $doc = new \DOMDocument();
        @$doc->loadHTML(($out));
        $document = new DOMXPath($doc);
        $hrefs = $document->query($xpath);
        $urlarray = array();
        foreach ($hrefs as $url) {
            $urlarray[] = $url;
        }
        return  $urlarray;
    }
}

