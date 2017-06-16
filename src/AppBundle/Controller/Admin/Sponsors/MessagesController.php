<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 01/06/2017
 * Time: 09:22
 */

namespace AppBundle\Controller\Admin\Sponsors;


use AppBundle\Entity\Message;
use AppBundle\Entity\SponsorGroup;
use AppBundle\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/parrains/messages")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class MessagesController extends Controller
{
    /**
     * @Route("/parrain/{id}", name="admin_sponsors_messages_sponsor", requirements={"id": "\d+"})
     */
    public function indexAction(Request $request, User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain dont vous souhaitez consulter les messages n\'existe pas.');
        }

        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->getUserMessages($user);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setUser($user);
            $message->setIsSenderAdmin(true);
            $message->setIsNotificationAdmin(false);
            $user->setMessageConsulted(false); // Notification de message parrain
            $em->persist($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été envoyé au filleul.');
            return $this->redirectToRoute('admin_sponsors_messages_sponsor', array('id' => $user->getId()));
        } elseif($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('error', 'Le message n\'a pas été enregistré car le formulaire contient une ou plusieurs erreurs.');
        }

        $this->removeMessagesNotifications($user); // On enlève les notifications admin de messages non lu

        return $this->render('admin/sponsors/sponsors/view_messages.html.twig', array(
            'form' => $form->createView(),
            'sponsor' => $user,
            'messages' => $messages
        ));
    }


    /**
     * @Route("/parrain/{sponsor_id}/modifier/{message_id}", name="admin_sponsors_messages_sponsor_edit", requirements={"sponsor_id": "\d+", "message_id": "\d+"})
     * @ParamConverter("user", class="AppBundle:User", options={"id" = "sponsor_id"})
     * @ParamConverter("message", class="AppBundle:Message", options={"id" = "message_id"})
     */
    public function sponsorEditAction(Request $request, User $user, Message $message)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain pour lequel vous souhaitez modifier un message n\'existe pas.');
        }
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été modifié.');
            return $this->redirectToRoute('admin_sponsors_messages_sponsor', array('id' => $user->getId()));
        }

        return $this->render('admin/sponsors/sponsors/view_messages_edit.html.twig', array(
            'form' => $form->createView(),
            'sponsor' => $user,
            'message' => $message
        ));
    }

    /**
     * @Route("/parrain/{sponsor_id}/supprimer/{message_id}", name="admin_sponsors_messages_sponsor_delete", requirements={"sponsor_id": "\d+", "message_id": "\d+"})
     * @ParamConverter("user", class="AppBundle:User", options={"id" = "sponsor_id"})
     * @ParamConverter("message", class="AppBundle:Message", options={"id" = "message_id"})
     */
    public function sponsorDeleteAction(Request $request, User $user, Message $message)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain pour lequel vous souhaitez supprimer un message n\'existe pas.');
        }
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été supprimé.');
            return $this->redirectToRoute('admin_sponsors_messages_sponsor', array('id' => $user->getId()));
        }

        return $this->render('admin/sponsors/sponsors/view_messages_delete.html.twig', array(
            'form' => $form->createView(),
            'sponsor' => $user,
            'message' => $message
        ));
    }

    /**
     * @Route("/groupe/{id}", name="admin_sponsors_messages_group", requirements={"id": "\d+"})
     */
    public function groupIndexAction(Request $request, SponsorGroup $group)
    {
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->getGroupMessages($group);

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message->setGroup($group);
            $message->setIsSenderAdmin(true);
            $message->setIsNotificationAdmin(false);
            $this->notifyUsersOfGroup($group); // Notifications de nouveau message
            $em->persist($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été envoyé au groupe.');
            return $this->redirectToRoute('admin_sponsors_messages_group', array('id' => $group->getId()));
        } elseif($form->isSubmitted() && !$form->isValid()){
            $this->addFlash('error', 'Le message n\'a pas été enregistré car le formulaire contient une ou plusieurs erreurs.');
        }

        return $this->render('admin/sponsors/groups/view_messages.html.twig', array(
            'form' => $form->createView(),
            'group' => $group,
            'messages' => $messages
        ));
    }


    /**
     * @Route("/groupe/{group_id}/modifier/{message_id}", name="admin_sponsors_messages_group_edit", requirements={"group_id": "\d+", "message_id": "\d+"})
     * @ParamConverter("group", class="AppBundle:SponsorGroup", options={"id" = "group_id"})
     * @ParamConverter("message", class="AppBundle:Message", options={"id" = "message_id"})
     */
    public function groupEditAction(Request $request, SponsorGroup $group, Message $message)
    {
        $form = $this->createForm(MessageType::class, $message);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été modifié.');
            return $this->redirectToRoute('admin_sponsors_messages_group', array('id' => $group->getId()));
        }

        return $this->render('admin/sponsors/groups/view_messages_edit.html.twig', array(
            'form' => $form->createView(),
            'group' => $group,
            'message' => $message
        ));
    }

    /**
     * @Route("/groupe/{group_id}/supprimer/{message_id}", name="admin_sponsors_messages_group_delete", requirements={"group_id": "\d+", "message_id": "\d+"})
     * @ParamConverter("group", class="AppBundle:SponsorGroup", options={"id" = "group_id"})
     * @ParamConverter("message", class="AppBundle:Message", options={"id" = "message_id"})
     */
    public function groupDeleteAction(Request $request, SponsorGroup $group, Message $message)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();

            $this->addFlash('info', 'Le message a bien été supprimé.');
            return $this->redirectToRoute('admin_sponsors_messages_group', array('id' => $group->getId()));
        }

        return $this->render('admin/sponsors/groups/view_messages_delete.html.twig', array(
            'form' => $form->createView(),
            'group' => $group,
            'message' => $message
        ));
    }


    private function notifyUsersOfGroup(SponsorGroup $group){
        foreach ($group->getUsers() as $user){
            $user->setMessageConsulted(false);
        }
        $this->getDoctrine()->getManager()->flush();
    }


    private function removeMessagesNotifications(User $user){
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Message')->findBy(array('user' => $user, 'isNotificationAdmin' => true));
        foreach ($messages as $message){
            $message->setIsNotificationAdmin(false);
        }
        $em->flush();
    }
}