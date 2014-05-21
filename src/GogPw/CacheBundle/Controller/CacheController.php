<?php

namespace GogPw\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CacheController extends Controller
{

    const SLEEP_TIME = 3;
    const MEMCACHE_TTL = 5;
    const XCACHE_TTL = 8;

    public function nocacheAction()
    {
        $response = $this->getResponse();
        return new Response($response);
    }

    public function memcacheAction()
    {
        $response = $this->getResponseFromMemcache();
        return new Response($response);
    }

    public function xcacheAction()
    {
        $response = $this->getResponseFromXcache();
        return new Response($response);
    }

    public function varnishAction()
    {
        $response = $this->getResponse();
        return new Response($response);
    }

    private function getResponseFromMemcache()
    {
        $cacheService = $this->container->get('memcache.default');
        if(!$response = $cacheService->get('memcache_key')) {
            $response = $this->getResponse();
            syslog(5, 'Caching response using memcache.');
            $cacheService->set('memcache_key', $response, self::MEMCACHE_TTL);   
        } else {
            syslog(5, 'Fetched response using memcache.');
        }
    
        return $response;
    }

    private function getResponseFromXcache()
    {
        if (!$response = xcache_get('xcache_key')) {
            $response = $this->getResponse();
            syslog(5, 'Caching response using xcache.');
            xcache_set('xcache_key',$response, self::XCACHE_TTL);
        } else {
            syslog(5, 'Fetched response using xcache.');
        }
    
        return $response;
    }

    private function getResponse()
    {
        sleep(self::SLEEP_TIME);
        return 'Task response.';
    }
}
