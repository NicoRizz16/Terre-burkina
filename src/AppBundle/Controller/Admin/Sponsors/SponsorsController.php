<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin\Sponsors;

use AppBundle\Entity\User;
use AppBundle\Form\EditSponsorType;
use AppBundle\Form\SponsorAssignGroupType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin/parrains")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class SponsorsController extends Controller
{
    /**
     * @Route("/{by}/{order}/{page}", name="admin_sponsors", defaults={"by": "lastName", "order": "ASC"}, requirements={"page": "\d+"})
     */
    public function indexAction($by, $order, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = User::NUM_ITEMS;
        $sponsorsList = $repository->getSponsors($page, $nbPerPage, $by, $order);
        $nbPageTotal = ceil(count($sponsorsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/sponsors/sponsors/index.html.twig', array(
            'sponsorsList' => $sponsorsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'by' => $by,
            'order' => $order
        ));
    }

    /**
     * @Route("/{id}/infos", name="admin_sponsors_view_infos", requirements={"id": "\d+"})
     */
    public function viewAction(User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain que vous souhaitez visualiser n\'existe pas.');
        }

        return $this->render('admin/sponsors/sponsors/view_infos.html.twig', array(
            'sponsor' => $user
        ));
    }

    /**
     * @Route("/{id}/modifier/infos", name="admin_sponsors_view_infos_edit", requirements={"id": "\d+"})
     */
    public function editInfosAction(Request $request, User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain dont vous souhaitez modifier les informations n\'existe pas.');
        }

        $form = $this->createForm(EditSponsorType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            $this->addFlash('info', 'Les informations sur le parrain "'.$user->getFullName().'" ont bien été enregistrées.');
            $this->get('app.add_record')->addRecord('Modification des informations du parrain "'.$user->getFullName().'".');
            return $this->redirectToRoute('admin_sponsors_view_infos', array('id' => $user->getId()));
        }

        return $this->render('admin/sponsors/sponsors/view_edit_infos.html.twig', array(
            'sponsor' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/groupes", name="admin_sponsors_view_groups", requirements={"id": "\d+"})
     */
    public function groupsAction(User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain dont vous souhaitez consulter les groupes n\'existe pas.');
        }

        return $this->render('admin/sponsors/sponsors/view_groups.html.twig', array(
            'sponsor' => $user
        ));
    }

    /**
     * @Route("/{id}/groupes/assigner", name="admin_sponsors_view_groups_assign", requirements={"id": "\d+"})
     */
    public function assignGroupAction(Request $request, User $user)
    {
        $form = $this->createForm(SponsorAssignGroupType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $post = $form->getData();

            $group = $em->getRepository('AppBundle:SponsorGroup')->find($post['group']);
            if(!$group){
                $this->addFlash('error', 'Le groupe que vous essayez d\'ajouter à ce parrain n\'existe pas.');
                return $this->redirectToRoute('admin_sponsors_view_groups', array('id' => $user->getId()));
            }
            if($user->hasSponsorGroup($group)){
                $this->addFlash('error', 'Le parrain appartient déjà à ce groupe.');
                return $this->redirectToRoute('admin_sponsors_view_groups', array('id' => $user->getId()));
            }

            $user->addSponsorGroup($group);
            $em->persist($user);
            $em->flush();

            $this->addFlash('info', 'Le parrain a bien été ajouté au groupe "'.$group->getName().'".');
            return $this->redirectToRoute('admin_sponsors_view_groups', array('id' => $user->getId()));
        }

        return $this->render('admin/sponsors/sponsors/view_groups_assign.html.twig', array(
            'sponsor' => $user,
            'form' => $form->createView()
        ));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/sponsor/{id}/group/remove", name="ajax_sponsor_group_remove", requirements={"id": "\d+"})
     */
    public function ajaxGroupRemoveAction(Request $request, User $user)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $groupID = $request->request->get('groupID');

        $group = $em->getRepository('AppBundle:SponsorGroup')->find($groupID);

        $user->removeSponsorGroup($group);
        $em->persist($user);
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

}
