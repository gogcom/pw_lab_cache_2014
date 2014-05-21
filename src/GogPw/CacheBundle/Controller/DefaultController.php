<?php

namespace GogPw\CacheBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('GogPwCacheBundle:Default:index.html.twig', array('name' => $name));
    }
}
