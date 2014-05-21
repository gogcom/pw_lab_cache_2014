<?php

namespace GogPw\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CacheController extends Controller
{

    const SLEEP_TIME = 3;
    const MEMCACHE_TTL = 5;

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

    private function getResponse()
    {
        sleep(self::SLEEP_TIME);
        return 'Task response.';
    }
}
