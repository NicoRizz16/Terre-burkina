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

/**
 * @Route("/admin/users")
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
    public function toggleStateAction(Request $request, User $user)
    {
        $user->setEnabled(!$user->isEnabled());
        $message = $user->isEnabled() ? "activé." : "désactivé.";

        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info', 'L\'utilisateur "'.$user->getUsername().'" est maintenant '.$message);

        return $this->redirectToRoute('admin_users');
    }
}