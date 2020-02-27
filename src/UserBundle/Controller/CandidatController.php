<?php


namespace UserBundle\Controller;



use FOS\UserBundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CandidatController extends Controller
{
    /*
     public function updateinformationAction(Request $request)
     {
         $userManager = $this->container->get('fos_user.user_manager');
         $user = $userManager->findUserByUsername($this->container->get('security.token_storage')
             ->getToken()
             ->getUser());

         if ($request->isMethod('POST')) {

             $user=$this->container->get('security.token_storage')
                 ->getToken()
                 ->getUser()->setEmail($request->get('Email'));

             $user->setPlainPassword($request->get('PlainPassword'));
             $this->getDoctrine()->getManager()->flush();

             return $this->redirectToRoute('admin_affiche');
         }
         return $this->render('@User/Candidat/Candidat.html.twig', array(
             'user' => $user
         ));
     }
    */
}