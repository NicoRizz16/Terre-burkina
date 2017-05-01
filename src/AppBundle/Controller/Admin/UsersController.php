<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/users")
 * @Security("has_role('ROLE_ADMIN')")
 */
class UsersController extends Controller
{
    /**
     * @Route("/{page}", name="admin_users", requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:User');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = User::NUM_ITEMS;
        $usersList = $repository->getUsers($page, $nbPerPage);
        $nbPageTotal = ceil(count($usersList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/users/index.html.twig', array(
            'usersList' => $usersList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/basculer-etat/{id}", name="admin_users_toggle_state", requirements={"id": "\d+"})
     */
    public function toggleStateAction(User $user)
    {
        $user->setEnabled(!$user->isEnabled());
        $message = $user->isEnabled() ? "activé." : "désactivé.";

        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info', 'L\'utilisateur "'.$user->getUsername().'" est maintenant '.$message);

        return $this->redirectToRoute('admin_users');
    }

    // NUMEROTATION ROLES
    // ======================
    // ROLE_ADMIN = 0
    // ROLE_MODERATOR = 1
    // ROLE_COORDINATOR = 2
    // ROLE_SPONSOR = 3
    /**
     * @Route("definir-role/{id}/{role}", name="admin_users_role", requirements={"id": "\d+", "role": "[0-4]"})
     */
    public function setRoleAction(User $user, $role)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();

        // Les ADMIN ne sont modifiables que par les SUPER_ADMIN, le SUPER_ADMIN n'a pas un rôle modifiable
        if(($user->hasRole('ROLE_ADMIN') && !$currentUser->hasRole('ROLE_SUPER_ADMIN')) ||
            $user->hasRole(('ROLE_SUPER_ADMIN'))){
            $this->addFlash('error', 'Vous ne pouvez pas modifier le rôle de l\'utilisateur "'.$user->getUsername().'".');
            return $this->redirectToRoute('admin_users');
        }

       $em = $this->getDoctrine()->getManager();
        switch ($role){
            case 0:
                $user->setRoles(array('ROLE_ADMIN'));
                break;
            case 1:
                $user->setRoles(array('ROLE_MODERATOR'));
                break;
            case 2:
                $user->setRoles(array('ROLE_COORDINATOR'));
                break;
            case 3:
                $user->setRoles(array('ROLE_SPONSOR'));
                break;
        }
        $em->persist($user);
        $em->flush();
        $this->addFlash('info', 'L\'utilisateur "'.$user->getUsername().'" a bien changé de rôle.');
        return $this->redirectToRoute('admin_users');
    }
}