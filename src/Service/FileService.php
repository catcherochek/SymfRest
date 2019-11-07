<?php
namespace  App\Service;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class FileService
 * For reading json from file
 * @package App\Service
 */
class FileService{
    private $cache;
    public function __construct()
    {
        $this->cache  = new FilesystemAdapter();
        //new FilesystemAdapter('', 0, "cache");
       // $this->cache = new FilesystemAdapter();
    }

    /** Reads all data from file
     * @param String $path -www.google.com
     * @param String $type - GET POST
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Psr\Http\Client\ClientExceptionInterface
     *
     */
    public function read($objname){
        $cachePool = $this->cache;
        //$demoOne = $cachePool->getItem($objname);
        if ($cachePool->hasItem($objname))
        {
            $demoOne = $cachePool->getItem($objname);
            return $demoOne->get();

        }else{
            return false;
        }
    //    if (!$this->cache->has($objname)) {
    //        return false;
    //    }
    //    return $this->cache->get($objname);
    }

    /**
     * Writes data to cache
     * @param String $objname  www.google.com
     * @param String $obj - xpath
     * @param String $ttl - seconds
     * @return array - of results
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function write(String $objname,$obj, $ttl = 3600)
    {
        $demoString = $this->cache->getItem($objname);
        $demoString->set($obj);
        $demoString->expiresAfter($ttl);
        $this->cache->save($demoString);


    }

    /**clear all
     *
     */
    public function clear(){

    }
}

