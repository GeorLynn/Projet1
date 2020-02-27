<?php


namespace CommentQuizBundle\Controller;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class QuizController extends Controller
{

    public function DemandeAction(Request $request)
    {
        $user = $this->getUser();
        if($user->getRoles()[0]=="SPECTATEUR")
        {
            return $this->render('@CommentQuiz/Default/demmandes.html.twig');
        }
        else
        {
            return $this->render('default\index.html.twig');
        }
    }
    public function theatreAction(Request $req)
    {
        $em = $this->getDoctrine()->getManager();
        $questions= $em->getRepository("CommentQuizBundle:Question")->findBy(['sujet'=>'theatre']);
        return $this->render('@CommentQuiz/Default/Quizz.html.twig',array("questions"=>$questions));
    }
    public function sportAction()
    {
        $em = $this->getDoctrine()->getManager();
        $questions= $em->getRepository("CommentQuizBundle:Question")->findBy(['sujet'=>'sport']);
        return $this->render('@CommentQuiz/Default/question.html.twig',array("questions"=>$questions));
    }
    public function musiqueAction()
    {
        $em = $this->getDoctrine()->getManager();
        $questions= $em->getRepository("CommentQuizBundle:Question")->findBy(['sujet'=>'musique']);
        return $this->render('@CommentQuiz/Default/question.html.twig',array("questions"=>$questions));
    }
    public function danseAction()
    {
        $em = $this->getDoctrine()->getManager();
        $questions= $em->getRepository("CommentQuizBundle:Question")->findBy(['sujet'=>'danse']);
        return $this->render('@CommentQuiz/Default/question.html.twig',array("questions"=>$questions));
    }
    public function validerAction(Request $request)
    {
         if($request->isMethod('post')) {
             $note = $request->get('scoree');
         }
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        if($note>0){
            $user->addRole("ROLE_CANDIDAT");
            $em->flush();
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('ahmedbenabdallah1111@gmail.com')
                ->setPassword('wgcaeyxslreekvns');
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message('vous etes accepter en tant que candidat'))
                ->setFrom('ahmedbenabdallah1111@gmail.com')

                ->setTo($this->getUser()->getEmail());

            $mailer->send($message);
            return $this->render('@CommentQuiz/Default/test.html.twig',array("note"=>$note));
        }else{
            $transport = (new \Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('ahmedbenabdallah1111@gmail.com')
                ->setPassword('wgcaeyxslreekvns');
            $mailer = new \Swift_Mailer($transport);

            // Create a message
            $message = (new \Swift_Message('vous etes pas accepter en tant que candidat'))
                ->setFrom('ahmedbenabdallah1111@gmail.com')

                ->setTo($this->getUser()->getEmail());

            $mailer->send($message);
            return $this->render('@CommentQuiz/Default/test.html.twig',array("note"=>$note));
        }
       return $this->render('@CommentQuiz/Default/test.html.twig',array("note"=>$note));
    }
}