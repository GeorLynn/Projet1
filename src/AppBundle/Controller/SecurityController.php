<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SecurityController extends Controller
{
    /**
     * @Route("/add")
     */
    public function addAction()
    {
        return $this->render('AppBundle:Security:add.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/listerA")
     */
    public function redirectAction()
    {

        $authChecker = $this->container->get('security.authorization_checker');

        if($authChecker->isGranted('ROLE_USER'))
        {
            return $this->render('Article/listeArticle.html.twig');
        }
        elseif ($authChecker->isGranted('ROLE_ADMIN'))
        {
            return $this->render('default/admin/admin.html.twig');
        }
        else
        {
            return $this->render('@FOSUser/Security/login.html.twig');
        }

    }

}
