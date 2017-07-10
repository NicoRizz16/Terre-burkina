<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin\Childs;

use AppBundle\Entity\Child;
use AppBundle\Form\ChildAssignGroupType;
use AppBundle\Form\ChildType;
use AppBundle\Form\EditChildInfosType;
use AppBundle\Form\EditChildSponsorshipType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin/filleuls")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class ChildsController extends Controller
{
    /**
     * @Route("/ajouter", name="admin_childs_add")
     */
    public function addAction(Request $request)
    {
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $this->addFlash('info', 'Le filleul "'.$child->getFirstName().' '.$child->getLastName().'" a bien été enregistré.');
            $this->get('app.add_record')->addRecord('Ajout du filleul "'.$child->getFullName().'".');
            return $this->redirectToRoute('admin_childs');
        }

        return $this->render('admin/childs/childs/add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/{id}/infos", name="admin_childs_view_infos", requirements={"id": "\d+"})
     */
    public function viewAction(Child $child)
    {
        return $this->render('admin/childs/childs/view_infos.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/supprimer", name="admin_childs_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Child $child)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($child);
            $em->flush();

            $this->addFlash('info', 'Le filleul "'.$child->getFullName().'" a bien été supprimé.');
            $this->get('app.add_record')->addRecord('Suppression du filleul "'.$child->getFullName().'".');
            return $this->redirectToRoute('admin_childs');
        }

        return $this->render('admin/childs/childs/delete.html.twig', array(
            'form' => $form->createView(),
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/modifier/infos", name="admin_childs_view_infos_edit", requirements={"id": "\d+"})
     */
    public function editInfosAction(Request $request, Child $child)
    {
        $form = $this->createForm(EditChildInfosType::class, $child);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $this->addFlash('info', 'Les informations sur le filleul "'.$child->getFullName().'" ont bien été enregistrées.');
            $this->get('app.add_record')->addRecord('Modification des informations du filleul "'.$child->getFullName().'".');
            return $this->redirectToRoute('admin_childs_view_infos', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_edit_infos.html.twig', array(
            'child' => $child,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/modifier/parrainage", name="admin_childs_view_sponsorship_edit", requirements={"id": "\d+"})
     */
    public function editSponsorshipAction(Request $request, Child $child)
    {
        $form = $this->createForm(EditChildSponsorshipType::class, $child);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $this->addFlash('info', 'Les informations sur le filleul "'.$child->getFullName().'" ont bien été enregistrées.');
            $this->get('app.add_record')->addRecord('Modification des informations du filleul "'.$child->getFullName().'".');
            return $this->redirectToRoute('admin_childs_view_infos', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_edit_sponsorship.html.twig', array(
            'child' => $child,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/groupes", name="admin_childs_view_groups", requirements={"id": "\d+"})
     */
    public function groupsAction(Child $child)
    {
        return $this->render('admin/childs/childs/view_groups.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/groupes/assigner", name="admin_childs_view_groups_assign", requirements={"id": "\d+"})
     */
    public function assignGroupAction(Request $request, Child $child)
    {
        $form = $this->createForm(ChildAssignGroupType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post = $form->getData();

            $group = $em->getRepository('AppBundle:ChildGroup')->find($post['group']);
            if(!$group){
                $this->addFlash('error', 'Le groupe que vous essayez d\'ajouter à ce filleul n\'existe pas.');
                return $this->redirectToRoute('admin_childs_view_groups', array('id' => $child->getId()));
            }
            if($child->hasGroup($group)){
                $this->addFlash('error', 'Le filleul appartient déjà à ce groupe.');
                return $this->redirectToRoute('admin_childs_view_groups', array('id' => $child->getId()));
            }

            $child->addGroup($group);
            $em->persist($child);
            $em->flush();

            $this->addFlash('info', 'Le filleul a bien été ajouté au groupe "'.$group->getName().'".');
            return $this->redirectToRoute('admin_childs_view_groups', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_groups_assign.html.twig', array(
            'child' => $child,
            'form' => $form->createView()
        ));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/child/{id}/group/remove", name="ajax_child_group_remove", requirements={"id": "\d+"})
     */
    public function ajaxGroupRemoveAction(Request $request, Child $child)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $groupID = $request->request->get('groupID');

        $group = $em->getRepository('AppBundle:ChildGroup')->find($groupID);

        $child->removeGroup($group);
        $em->persist($child);
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Route("/liste/{by}/{order}/{page}", name="admin_childs", defaults={"by": "lastName", "order": "ASC"}, requirements={"page": "\d+"})
     */
    public function indexAction($by, $order, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Child');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = Child::NUM_ITEMS;
        $childsList = $repository->getChilds($page, $nbPerPage, $by, $order);
        $nbPageTotal = ceil(count($childsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/childs/childs/index.html.twig', array(
            'childsList' => $childsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'by' => $by,
            'order' => $order
        ));
    }
}
