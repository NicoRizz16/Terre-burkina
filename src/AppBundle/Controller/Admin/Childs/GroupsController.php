<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 19/05/2017
 * Time: 16:49
 */

namespace AppBundle\Controller\Admin\Childs;


use AppBundle\Entity\ChildGroup;
use AppBundle\Form\ChildGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/filleuls/groupes")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class GroupsController extends Controller
{
    /**
     * @Route("/", name="admin_childs_groups")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:ChildGroup')->findBy(array(), array('name' => 'ASC'));

        return $this->render('admin/childs/groups/index.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @Route("/ajouter", name="admin_childs_groups_add")
     */
    public function addAction(Request $request)
    {
        $childGroup = new ChildGroup();
        $form = $this->createForm(ChildGroupType::class, $childGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($childGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe "'.$childGroup->getName().'" a bien été enregistré.');
            return $this->redirectToRoute('admin_childs_groups');
        }

        return $this->render('admin/childs/groups/add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/supprimer/{id}", name="admin_childs_groups_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, ChildGroup $childGroup)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($childGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe "'.$childGroup->getName().'" a bien été supprimé.');
            return $this->redirectToRoute('admin_childs_groups');
        }

        return $this->render('admin/childs/groups/delete.html.twig', array(
            'form' => $form->createView(),
            'childGroup' => $childGroup
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_childs_groups_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, ChildGroup $childGroup)
    {

        $form = $this->createForm(ChildGroupType::class, $childGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($childGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe a bien été renommé "'.$childGroup->getName().'".');
            return $this->redirectToRoute('admin_childs_groups');
        }

        return $this->render('admin/childs/groups/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

}