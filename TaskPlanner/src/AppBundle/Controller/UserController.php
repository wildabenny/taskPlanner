<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/welcome")
     * @Template("AppBundle:Profile:show.html.twig")
     */
    public function welcomeAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return ['user' => $user];
    }
}