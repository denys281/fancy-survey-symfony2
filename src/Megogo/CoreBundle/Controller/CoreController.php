<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('MegogoCoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
