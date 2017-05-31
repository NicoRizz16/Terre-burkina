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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/parrains")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class SponsorsController extends Controller
{
    /**
     * @Route("/{page}", name="admin_sponsors", requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = User::NUM_ITEMS;
        $sponsorsList = $repository->getSponsors($page, $nbPerPage);
        $nbPageTotal = ceil(count($sponsorsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/sponsors/sponsors/index.html.twig', array(
            'sponsorsList' => $sponsorsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
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
            return $this->redirectToRoute('admin_sponsors_view_infos', array('id' => $user->getId()));
        }

        return $this->render('admin/sponsors/sponsors/view_edit_infos.html.twig', array(
            'sponsor' => $user,
            'form' => $form->createView()
        ));
    }

}
