<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\User;
use AppBundle\Form\CreateUserType;
use AppBundle\Form\EditUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/utilisateurs")
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
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        // Les ADMIN ne sont modifiables que par les SUPER_ADMIN, le SUPER_ADMIN n'est pas modifiable
        if(($user->hasRole('ROLE_ADMIN') && !$currentUser->hasRole('ROLE_SUPER_ADMIN')) ||
            $user->hasRole(('ROLE_SUPER_ADMIN'))){
            $this->addFlash('error', 'Vous ne pouvez pas changer l\'état d\'activation de l\'utilisateur "'.$user->getUsername().'".');
            return $this->redirectToRoute('admin_users');
        }

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
                if(!$currentUser->hasRole('ROLE_SUPER_ADMIN')){
                    $this->addFlash('error', 'Vous ne pouvez pas accorder le rôle administrateur');
                    return $this->redirectToRoute('admin_users');
                }
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
        $this->addFlash('info', 'Le nouveau rôle de l\'utilisateur "'.$user->getUsername().'" a bien été enregistré.');
        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/ajouter", name="admin_users_add")
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(CreateUserType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $successfullyRegistered = $this->register($post['email'], $post['username'], $post['role'], $post['password']);
            if($successfullyRegistered){
                // L'utilisateur est bien enregistré
                $this->addFlash('info', 'L\'utilisateur "'.$post['username'].'" a bien été enregistré.');
                // Envois du mail avec les données de connexion si demandé
                if($post['send_mail']){
                    $sender = $this->get('send.account_data');
                    $sender->sendAccountData($post['email'], $post['username'], $post['password']);
                }
            } else {
                // L'utilisateur existe déjà
                $this->addFlash('error', 'Ce nom d\'utilisateur ou cette adresse e-mail est déjà utilisée.');
            }

            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    private function register($email, $username, $role, $password)
    {
        $userManager = $this->get('fos_user.user_manager');

        $email_exist = $userManager->findUserByEmail($email);
        $username_exist = $userManager->findUserByUsername($username);
        if($email_exist || $username_exist){
            return false;
        }
        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEmailCanonical(strtolower($email));
        $user->setEnabled(1);
        $user->setPlainPassword($password);
        $user->setRoles(array($role));
        $userManager->updateUser($user);

        return true;
    }

    /**
     * @Route("/supprimer/{id}", name="admin_users_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, User $user)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        // Les ADMIN ne sont supprimables que par les SUPER_ADMIN sauf si il s'agit de leur propre compte, le SUPER_ADMIN n'est pas supprimable
        if(($user->hasRole('ROLE_ADMIN') && !$currentUser->hasRole('ROLE_SUPER_ADMIN') && ($currentUser->getId() != $user->getId())) ||
            $user->hasRole(('ROLE_SUPER_ADMIN'))){
            $this->addFlash('error', 'Vous ne pouvez pas supprimer l\'utilisateur "'.$user->getUsername().'".');
            return $this->redirectToRoute('admin_users');
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();

            $this->addFlash('info', 'L\'utilisateur "'.$user->getUsername().'" a bien été supprimé.');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users/delete.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_users_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, User $user)
    {
        $currentUser = $this->get('security.token_storage')->getToken()->getUser();
        // Les ADMIN ne peuvent modifier que leur propre compte ou tous les rôles en dessous d'eux.
        if(($user->hasRole('ROLE_ADMIN') && !$currentUser->hasRole('ROLE_SUPER_ADMIN') && ($currentUser->getId() != $user->getId())) ||
            ($user->hasRole('ROLE_SUPER_ADMIN') && ($currentUser->getId() != $user->getId()) )){
            $this->addFlash('error', 'Vous ne pouvez pas modifier l\'utilisateur "'.$user->getUsername().'".');
            return $this->redirectToRoute('admin_users');
        }

        $form = $this->get('form.factory')->create(EditUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userManager = $this->get('fos_user.user_manager');
            // Vérification que le nom d'utilisateur demandé n'est pas déjà pris par un autre utilisateur
            $userWithSameUsername = $userManager->findUserByUsername($user->getUsername());
            if($userWithSameUsername->getId() != $user->getId()){
                $this->addFlash('error', 'Le nom d\'utilisateur "'.$user->getUsername().'" est déjà utilisé.');
                return $this->redirectToRoute('admin_users');
            }
            // Vérification que l'adresse email demandée n'est pas déjà prise par un autre utilisateur
            $userWithSameEmail = $userManager->findUserByEmail($user->getEmail());
            if($userWithSameEmail->getId() != $user->getId()){
                $this->addFlash('error', 'L\'adresse email "'.$user->getEmail().'" est déjà réservée à un autre utilisateur.');
                return $this->redirectToRoute('admin_users');
            }
            // Mise à jour de l'utilisateur
            $userManager->updateUser($user);
            $this->addFlash('info', 'L\'utilisateur "'.$user->getUsername().'" a bien été modifié.');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/users/edit.html.twig', array(
            'form' => $form->createView(),
            'user' => $user
        ));
    }
}