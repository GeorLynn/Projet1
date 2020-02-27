<?php


namespace UserBundle\Controller;


use FOS\UserBundle\Controller\SecurityController;

use Symfony\Component\HttpFoundation\Request;

use UserBundle\Entity\User;


class UserController extends SecurityController
{
//redirection apres login

    public function indexAction()
    {
        $u = $this->getUser();

            switch ($u->getRoles()[0]) {
                case "ADMIN":
                    return $this->render('dashboard.html.twig');
                    break;
                default:
                    return $this->render('default\index.html.twig');
                    break;
            }

    }


//======================================================================================================================
/*//admin
    public function afficherAction()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('@User/Admin/read.html.twig',array('users'=>$users));
    }

    public function voirprofilAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy([
            'id' => $id,
        ]);


        return $this->render('@User/Admin/voirprofil.html.twig', array(
            'user' => $user,
        ));
    }

    public function deleteUserAction(User $user) {
        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        return $this->redirectToRoute('admin_affiche');
    }

    public function updateAction($id,Request $request)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user=$userManager->findUserBy([
            'id' => $id,
        ]);
        if ($request->isMethod('POST')) {

            $user->setEmail($request->get('Email'));

            $user->setPlainPassword($request->get('PlainPassword'));
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_affiche');
        }
        return $this->render('@User/Admin/modif.html.twig', array(
            'user' => $user,
        ));
    }

//======================================================================================================================
*/
}
