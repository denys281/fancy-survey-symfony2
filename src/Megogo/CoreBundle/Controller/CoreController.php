<?php

namespace Megogo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Megogo\CoreBundle\Form\UserType as UserType;
use Megogo\CoreBundle\Entity\User as User;

class CoreController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {

        $registrationForm = $this->createForm(new UserType(), new User(),
            [
                'action' => $this->generateUrl('homepage'),
                'method' => 'POST'
            ]
        )->createView();
        return ['registrationForm' => $registrationForm];
    }
}
