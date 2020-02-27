<?php

namespace CommentQuizBundle\Controller;

use CommentQuizBundle\Entity\Question;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('CommentQuizBundle:Default:index.html.twig');
    }
    public function affichequestionAction()
    {
        $question=$this->getDoctrine()->getRepository(Question::class)->findAll();
        return $this->render('@CommentQuiz/Default/question.html.twig',array('question'=>$question));
    }
    public function modifquestionAction(Request $request, $id)
    {
        $em=$this->getDoctrine()->getManager();
        $question = $em->getRepository(Question::class)->find($id);
        if ($request->isMethod('POST')) {
            $question->setEnonce($request->get('enonce'));
            $question->setrep1($request->get('rep1'));
            $question->setrep2($request->get('rep2'));
            $question->setrep3($request->get('rep3'));
            $question->setCorrect($request->get('correct'));
            $question->setSujet($request->get('sujet'));
            $em->flush();
            return $this->redirectToRoute('affq');
        }
        return $this->render('@CommentQuiz/Default/modif.html.twig', array(
            'question' => $question
        ));
    }
    public function ajoutquestionAction(Request $request)
    {
        $question=new Question();
        $em=$this->getDoctrine()->getManager();
        if ($request->isMethod('POST')) {
            $question->setEnonce($request->get('enonce'));
            $question->setrep1($request->get('rep1'));
            $question->setrep2($request->get('rep2'));
            $question->setrep3($request->get('rep3'));
            $question->setCorrect($request->get('correct'));
            $question->setSujet($request->get('sujet'));
            $validator = $this->get('validator');
            $liste_erreurs = $validator->validate($question);

            if(count($liste_erreurs) > 0) {

                return new Response(print_r($liste_erreurs, true));

            } else {

                $this->addFlash('succes', 'bien !');

            }

            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('affq');
        }
        return $this->render('@CommentQuiz/Default/ajout.html.twig', array(
            'question' => $question
        ));
    }
    public function supprimerAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $question= $em->getRepository(Question::class)->find($id);
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute("affq");
    }

}
