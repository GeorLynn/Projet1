<?php


namespace CommentQuizBundle\Controller;


use  CommentQuizBundle\Entity\Commentaire;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CommentaireController extends Controller
{
    //============================Métier:Commentaire======================================================================
    public function affichecommentaireAction($id,Request $request){
        //recuperer la publication  à partir de leur id
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository("CommentQuizBundle:Publication")->find($id);
        //afficher tous les commentaire

        $commentaires = $em->getRepository("CommentQuizBundle:Commentaire")->findBy(["publication" => $publication , "actif" => 1]);
        $pagination  = $this->get('knp_paginator')->paginate(
            $commentaires,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/
        );
        return $this->render('@CommentQuiz\Commentaire\affiche.html.twig' , [ "User" => $this->getUser(), "commentaires" => $pagination , "publication" => $publication]);
    }
    public function ajoutercommentAction($id,Request $request)
    {
        $commentaire = new Commentaire();
        $commentaire->setContenu($request->get("contenu"));
        $commentaire->setCreatedAt(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository("CommentQuizBundle:Publication")->find($id);
        $commentaire->setPublication($publication);
        $commentaire->setActif(0);
        $commentaire->setUser($this->getUser());
        $em->persist($commentaire);
        $em->flush();
        $router = $this->container->get('router');
        return new RedirectResponse($router->generate('afficheCommentaire', ["id" => $id]));
    }

    public function supprimercommentAction($id)
    {
        //recuperer le commentaire à supprimer à partir de leur id
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("CommentQuizBundle:Commentaire")->find($id);
        $idpub = $commentaire->getPublication()->getId();
        //remove $commentaire
        $em->remove($commentaire);
        $em->flush();
        $router = $this->container->get('router');
        return new RedirectResponse($router->generate('afficheCommentaire', ["id" => $idpub]));
    }

    public function affichecommentairedashboardAction(Request $request){

        //afficher tous les commentaire non comfirmer
        $em = $this->getDoctrine()->getManager();
        $commentaires = $em->getRepository("CommentQuizBundle:Commentaire")->findBy(["actif" => 0]);

        $pagination  = $this->get('knp_paginator')->paginate(
            $commentaires,
            $request->query->get('page', 1)/*le numéro de la page à afficher*/,
            3/*nbre d'éléments par page*/
        );
        return $this->render('@CommentQuiz\Commentaire\affichedashboard.html.twig' , [  "commentaires" => $pagination]);
    }
    public function changeretatAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository("CommentQuizBundle:Commentaire")->find($id);
        $commentaire->setActif(1);
        $em->persist($commentaire);
        $em->flush();
        $router = $this->container->get('router');
        return new RedirectResponse($router->generate('Commentaire_list_dashboard'));
    }

}