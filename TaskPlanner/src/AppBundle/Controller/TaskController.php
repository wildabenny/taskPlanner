<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\Type\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * @Route("/new")
     * @Template()
     */
    public function newTaskAction(Request $request)
    {
        $task = new Task(date_create('now'));
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form = $this->createForm(FormType::class, $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $task->setUser($user);
            $task->setIsFinished(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('app_task_successtask');
        }
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/success")
     */
    public function successTaskAction()
    {
        return $this->render('AppBundle:Task:successTask.html.twig', array());
        
    }
}