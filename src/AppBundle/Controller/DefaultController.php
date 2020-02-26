<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commentaire;
use AppBundle\Entity\User;
use AppBundle\Entity\Users;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CommentaireType;
use AppBundle\Form\RechercheType;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/admin", name="test")
     */
    public function AdminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/admin/admin.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }


    /**
     * @Route("/users", name="testy")
     */
    public  function listeUtilisateurAction()
    {
        $users=$this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('default/users/listerUsers.html.twig',array('users'=>$users));
    }

    /**
     * @Route("/articles", name="artA")
     */
    public  function listeArticleAAction()
    {
        $art=$this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('Article/listeArticleA.html.twig',array('art'=>$art));
    }
    /**
     * @Route("/commentaires", name="comment")
     */
    public  function listeCommentAction()
    {
        $com=$this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return $this->render('Commentaire/listeComment.html.twig',array('com'=>$com));
    }

    /**
     * @Route("/users/{id}", name="Update")
     */
    public function updateUtilisateurAction(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(User::class)->find($id);

        if($request->isMethod('POST'))
        {
            $user->setUsername($request->get('username'));
            $user->setEmail($request->get('email'));
            $user->setPassword($request->get('password'));

            $em->flush();

            return $this->redirectToRoute('testy');

        }

        return $this->render('default/update/updateUsers.html.twig',array('user'=>$user));
    }

    /**
     * @Route("/delete/{id}", name="Delete")
     */
    public function deleteUtilisateurAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele=$em->getRepository(User::class)->find($id);

        $em->remove($modele);
        $em->flush();

        return $this->redirectToRoute('testy');



    }
    /**
     * @Route("/deleteA/{id}", name="DeleteA")
     */
    public function deleteArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele=$em->getRepository(Article::class)->find($id);

        $em->remove($modele);
        $em->flush();

        return $this->redirectToRoute('artA');



    }
    /**
     * @Route("/deleteC/{id}", name="DeleteC")
     */
    public function deleteCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $modele=$em->getRepository(Commentaire::class)->find($id);

        $em->remove($modele);
        $em->flush();

        return $this->redirectToRoute('comment');



    }

    /**
     * @Route("/listerA", name="la")
     */
    public function listeArticleAction()
    {
        $user = $this->getUser();

        echo "Bonjour    "  .$user;

        $articles=$this->getDoctrine()->getRepository(Article::class)->findAll();
        return $this->render('Article/listeArticle.html.twig',array('articles'=>$articles));

        $commentaire=$this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return $this->render('Article/listeArticle.html.twig',array('commentaire'=>$commentaire));
    }


    /**
     * @Route("/det/{id}", name="det")
     */
    public function detArticleAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article=$em->getRepository(Article::class)->find($id);

        return $this->render('Article/detArticle.html.twig',array('article'=>$article));
    }

    /**
     * @Route("/listerC", name="lc")
     */
    public function listeCommentaireAction()
    {
        $user = $this->getUser();

        echo "Bonjour    "  .$user;

        $commentaire=$this->getDoctrine()->getRepository(Commentaire::class)->findAll();
        return $this->render('Commentaire/listC.html.twig',array('commentaire'=>$commentaire));
    }

    /**
     * @Route("/addA", name="aa")
     */
    public function ajouterArticleAction(Request $request)
    {
        $user = $this->getUser();


        echo "Bonjour    "  .$user;
        $article= new Article();
        $article->setDateAjout(new \DateTime('now'));


        $article->setUser($user);
        $form= $this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute("la");
        }else{
            return $this->render("Article/addArt.html.twig",array("form"=>$form->createView()));
        }


    }

    /**
     * @Route("/addC", name="ac")
     */
    public function ajouterCommentaireAction(Request $request)
    {
        $user = $this->getUser();


        echo "Bonjour    "  .$user;

        $commentaire= new Commentaire();

            $commentaire->setDateAjout(new \DateTime());
        $commentaire->setUser($user);
        $form= $this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request)->isValid();
        if ($form->isSubmitted() && $form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute("la");
            echo "good";
        }
        return $this->render("Commentaire/addCom.html.twig",array("form"=>$form->createView()));

    }
    /**
     * @Route("/article/{id}", name="art")
     */
    public function articleAction($id)
    {
        $user = $this->getUser();

        echo "Bonjour    "  .$user;

        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);

        echo $article->getTitre();

        if(null == $article)
        {
            throw new NotFoundHttpException("L'annonce d'id".$id."n'existe pas"
            );
        }

        $commentaires = $em->getRepository('AppBundle:Commentaire')->findArticle($id);

        foreach ($commentaires as $comments)
        {
            echo $comments->getContenu();
        }


        return $this->render('Article/article.html.twig', array(
           'article'=>$article,
           'commentaires'=>$commentaires,
        ));


    }

    /**
     * @Route("/Forum", name="forum")
     */

    public function forumAction()
    {
        return $this->render('Forum/index.html.twig');
    }

    /**
     * @Route("/recArticle", name="ra")
     */
    public function rechercherAction(Request $request)
    {
        $user = $this->getUser();

        echo "Bonjour    "  .$user;
        $article = new Article();

        $form= $this->createForm(RechercheType::class,$article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $articles = $this->getDoctrine()->getRepository(Article::class)->findBy(array('titre'=>$article->getTitre()));
        }else{
            $articles = $this->getDoctrine()->getRepository(Article::class)->findAll();

        }
        return $this->render("Article/rechercheArticle.html.twig",array("form"=>$form->createView(),'articles'=>$articles));
    }
}