<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/05/2017
 * Time: 21:04
 */

namespace AppBundle\Controller\Admin\Childs;

use AppBundle\Entity\Child;
use AppBundle\Entity\Result;
use AppBundle\Form\ResultType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/filleuls/resultats")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class ResultsController extends Controller
{
    /**
     * @Route("/filleul/{id}/ajouter", name="admin_childs_result_add", requirements={"id": "\d+"})
     */
    public function addAction(Request $request, Child $child)
    {
        $result = new Result();
        $form = $this->createForm(ResultType::class, $result);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $result->setChild($child);

            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();

            $this->addFlash('info', 'Le résultat "'.$result->getYear().'" a bien été ajouté');
            return $this->redirectToRoute('admin_childs_results', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_result_add.html.twig', array(
            'child' => $child,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/filleul/{id}", name="admin_childs_results", requirements={"id": "\d+"})
     */
    public function indexAction(Child $child)
    {

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Result');

        // Récupération de la liste des nouvelles pour la page demandée
        $results = $repository->getChildResultsByDate($child->getId());

        return $this->render('admin/childs/childs/view_results.html.twig', array(
            'child' => $child,
            'results' => $results
        ));
    }

    /**
     * @Route("/filleul/{child_id}/supprimer/{result_id}", name="admin_childs_result_delete", requirements={"child_id": "\d+", "result_id": "\d+"})
     * @ParamConverter("child", class="AppBundle:Child", options={"id" = "child_id"})
     * @ParamConverter("result", class="AppBundle:Result", options={"id" = "result_id"})
     */
    public function deleteAction(Request $request, Child $child, Result $result)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($result);
            $em->flush();

            $this->addFlash('info', 'Le résultat "'.$result->getYear().'" a bien été supprimé.');
            return $this->redirectToRoute('admin_childs_results', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_result_delete.html.twig', array(
            'form' => $form->createView(),
            'child' => $child,
            'result' => $result
        ));
    }

    /**
     * @Route("/filleul/{child_id}/modifier/{result_id}", name="admin_childs_result_edit", requirements={"child_id": "\d+", "result_id": "\d+"})
     * @ParamConverter("child", class="AppBundle:Child", options={"id" = "child_id"})
     * @ParamConverter("result", class="AppBundle:Result", options={"id" = "result_id"})
     */
    public function editAction(Request $request, Child $child, Result $result)
    {
        $form = $this->createForm(ResultType::class, $result);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($result);
            $em->flush();

            $this->addFlash('info', 'Le résultat a bien été modifié.');
            return $this->redirectToRoute('admin_childs_results', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_result_edit.html.twig', array(
            'form' => $form->createView(),
            'child' => $child,
            'result' => $result
        ));
    }

}
