<?php

namespace GogPw\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CacheController extends Controller
{

    const SLEEP_TIME = 3;

    public function nocacheAction()
    {
        $response = $this->getResponse();
        return new Response($response);
    }

    private function getResponse()
    {
        sleep(self::SLEEP_TIME);
        return 'Task response.';
    }
}
