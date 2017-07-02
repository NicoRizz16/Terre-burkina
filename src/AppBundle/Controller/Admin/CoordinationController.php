<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\News;
use AppBundle\Form\ChildNewsType;
use AppBundle\Form\GroupNewsType;
use AppBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/coordination")
 * @Security("has_role('ROLE_COORDINATOR')")
 */
class CoordinationController extends Controller
{
    /**
     * @Route("", name="admin_coordination")
     */
    public function indexAction()
    {
        $newsList = $this->getDoctrine()->getManager()->getRepository('AppBundle:News')->findBy(array('isValid' => false), array('creationDate' => 'DESC'));

        return $this->render('admin/coordination/index.html.twig', array(
            'newsList' => $newsList
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_coordination_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, News $news)
    {
        if($news->getIsValid()){
            throw $this->createAccessDeniedException('Vous ne pouvez pas modifier une nouvelle déjà validée');
        }

        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été modifiée.');
            return $this->redirectToRoute('admin_coordination');
        }

        return $this->render('admin/coordination/edit.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="admin_coordination_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, News $news)
    {
        if($news->getIsValid()){
            throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer une nouvelle déjà validée');
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été supprimée.');
            return $this->redirectToRoute('admin_coordination');
        }

        return $this->render('admin/coordination/delete.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    /**
     * @Route("/filleul/ajouter", name="admin_coordination_child_add")
     */
    public function childAddAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(ChildNewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été ajoutée');
            return $this->redirectToRoute('admin_coordination');
        }

        return $this->render('admin/coordination/add_child.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/groupe/ajouter", name="admin_coordination_group_add")
     */
    public function groupAddAction(Request $request)
    {
        $news = new News();
        $form = $this->createForm(GroupNewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été ajoutée');
            return $this->redirectToRoute('admin_coordination');
        }

        return $this->render('admin/coordination/add_group.html.twig', array(
            'form' => $form->createView()
        ));
    }


}