<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CoreController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
      return [];
    }
}
