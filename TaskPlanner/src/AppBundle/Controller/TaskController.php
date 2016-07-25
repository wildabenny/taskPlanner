<?php


namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Task;
use AppBundle\Form\Type\FormType;
use AppBundle\Form\Type\FormTypeFromDb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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

    /**
     * @Route("/searchTask", options={"expose"=true})
     */
    public function searchTaskAction()
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->get('request');

        $taskId = intval($request->request->get('id'));

        $task = $em->getRepository('AppBundle:Task')->find($taskId);
        $status = 'error';
        $html = '';
        if ($task) {
            $data = $this->render('AppBundle:Task:showTask.html.twig', array('task' => $task));
            $status = 'success';
            $html = $data->getContent();
        }
        $jsonArray = array(
            'status' => $status,
            'data' => $html
        );

        $response = new Response(json_encode($jsonArray));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }

    /**
     * @Route("/newCategory")
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name')->add('submit', 'submit')->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('app_task_newtask');
        }

        return $this->render('AppBundle:Task:newCategory.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/editTask/{id}")
     * @Template()
     */
    public function editTaskAction(Request $request, $id)
    {
        $task = $this->getDoctrine()->getRepository('AppBundle:Task')->find($id);

        if (!$task) {
            return $this->createNotFoundException("No task found");
        }

        $form = $this->createForm(FormTypeFromDb::class, $task);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_user_welcome');
        }

        return ['form' => $form->createView()];
    }
}