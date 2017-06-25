<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/05/2017
 * Time: 10:43
 */

namespace AppBundle\Controller\Admin\Sponsors;


use AppBundle\Entity\SponsorGroup;
use AppBundle\Form\SponsorGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/parrains/groupes")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class GroupController extends Controller
{
    /**
     * @Route("/", name="admin_sponsors_groups")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groups = $em->getRepository('AppBundle:SponsorGroup')->findBy(array(), array('name' => 'ASC'));

        return $this->render('admin/sponsors/groups/index.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @Route("/ajouter", name="admin_sponsors_groups_add")
     */
    public function addAction(Request $request)
    {
        $sponsorGroup = new SponsorGroup();
        $form = $this->createForm(SponsorGroupType::class, $sponsorGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsorGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe "'.$sponsorGroup->getName().'" a bien été enregistré.');
            $this->get('app.add_record')->addRecord('Création du groupe de parrains "'.$sponsorGroup->getName().'".');
            return $this->redirectToRoute('admin_sponsors_groups');
        }

        return $this->render('admin/sponsors/groups/add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/supprimer/{id}", name="admin_sponsors_groups_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, SponsorGroup $sponsorGroup)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsorGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe "'.$sponsorGroup->getName().'" a bien été supprimé.');
            $this->get('app.add_record')->addRecord('Suppression du groupe de parrains "'.$sponsorGroup->getName().'".');
            return $this->redirectToRoute('admin_sponsors_groups');
        }

        return $this->render('admin/sponsors/groups/delete.html.twig', array(
            'form' => $form->createView(),
            'sponsorGroup' => $sponsorGroup
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_sponsors_groups_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, SponsorGroup $sponsorGroup)
    {

        $form = $this->createForm(SponsorGroupType::class, $sponsorGroup);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sponsorGroup);
            $em->flush();

            $this->addFlash('info', 'Le groupe a bien été renommé "'.$sponsorGroup->getName().'".');
            $this->get('app.add_record')->addRecord('Un groupe de parrain a été renommé en "'.$sponsorGroup->getName().'".');
            return $this->redirectToRoute('admin_sponsors_groups');
        }

        return $this->render('admin/sponsors/groups/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
}