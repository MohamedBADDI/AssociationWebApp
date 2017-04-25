<?php

namespace AclBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AclBundle:Default:index.html.twig');
    }
}
