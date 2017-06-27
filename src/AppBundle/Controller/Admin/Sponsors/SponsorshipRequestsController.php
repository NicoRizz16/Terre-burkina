<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 04/06/2017
 * Time: 21:58
 */


namespace AppBundle\Controller\Admin\Sponsors;

use AppBundle\Entity\SponsorshipRequest;
use AppBundle\Entity\User;
use AppBundle\Form\EditRequestSponsorshipType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @Route("/admin/parrains/demandes")
 * @Security("has_role('ROLE_ADMIN')")
 */
class SponsorshipRequestsController extends Controller
{
    /**
     * @Route("/", name="admin_sponsors_requests")
     */
    public function indexAction()
    {
        $sponsorshipRequestsList = $this->getDoctrine()->getManager()->getRepository('AppBundle:SponsorshipRequest')->findAll();

        return $this->render('admin/sponsors/requests/index.html.twig', array(
            'sponsorshipRequestsList' => $sponsorshipRequestsList
        ));
    }

    /**
     * @Route("/changer-statut/{id}", name="admin_sponsors_requests_toggle_state", requirements={"id": "\d+"})
     */
    public function toggleStateAction(SponsorshipRequest $sponsorshipRequest)
    {
        if($sponsorshipRequest->getIsValid()){
            $sponsorshipRequest->setIsValid(false);
            $this->get('app.add_record')->addRecord('Invalidation de la demande de parrainage de "'.$sponsorshipRequest->getEmail().'".');

        } else {
            if($sponsorshipRequest->getIsSponsorshipRequest() && ($sponsorshipRequest->getChild() == null)){
                $this->addFlash('error', 'Vous devez associer un filleul en attente de parrain à une demande de parrainage avant de la valider.');
                return $this->redirectToRoute('admin_sponsors_requests');
            }
            $sponsorshipRequest->setIsValid(true);
            $this->get('app.add_record')->addRecord('Validation de la demande de parrainage de "'.$sponsorshipRequest->getEmail().'".');
            $now = new \DateTime();
            $sponsorshipRequest->setExpirationDate($now->modify('+2 month'));
            // Envois de l'url de la demande par mail lors de la validation
            $this->get('send.request_url')->sendRequestUrl($sponsorshipRequest, $this->generateUrl('sponsorship_request_response', array('token' => $sponsorshipRequest->getToken()), UrlGeneratorInterface::ABSOLUTE_URL));
        }

        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info', 'L\'état de la demande a bien été modifié.');
        return $this->redirectToRoute('admin_sponsors_requests');
    }

    /**
     * @Route("/modifier/{id}", name="admin_sponsors_requests_edit", requirements={"id": "\d+"})
     */
    public function editAction(Request $request, SponsorshipRequest $sponsorshipRequest)
    {
        $form = $this->createForm(EditRequestSponsorshipType::class, $sponsorshipRequest);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $isChildTaken = $em->getRepository('AppBundle:SponsorshipRequest')->findOneBy(array('child' => $sponsorshipRequest->getChild()));
            if($isChildTaken && ($isChildTaken->getId() != $sponsorshipRequest->getId())){
                $this->addFlash('error', 'Le filleul sélectionné est déjà associé à une autre demande de parrainage.');
                return $this->redirectToRoute('admin_sponsors_requests');
            }
            if(!$sponsorshipRequest->getChild()){
                $sponsorshipRequest->setIsValid(false);
            }
            $em->flush();
            $this->get('app.add_record')->addRecord('Modification de la demande de parrainage de "'.$sponsorshipRequest->getEmail().'".');
            $this->addFlash('info', 'La demande de parrainage a bien été modifiée.');
            return $this->redirectToRoute('admin_sponsors_requests');
        }

        return $this->render('admin/sponsors/requests/edit.html.twig', array(
            'form' => $form->createView(),
            'sponsorshipRequest' => $sponsorshipRequest
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="admin_sponsors_requests_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, SponsorshipRequest $sponsorshipRequest)
    {
        $form = $this->get('form.factory')->create();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sponsorshipRequest);
            $em->flush();
            $this->addFlash('info', 'La demande a bien été supprimée.');
            $this->get('app.add_record')->addRecord('Suppression de la demande de parrainage de "'.$sponsorshipRequest->getEmail().'".');
            return $this->redirectToRoute('admin_sponsors_requests');
        }

        return $this->render('admin/sponsors/requests/delete.html.twig', array(
            'form' => $form->createView(),
            'sponsorshipRequest' => $sponsorshipRequest
        ));
    }

    /**
     * @Route("/creer-utilisateur/{id}", name="admin_sponsors_requests_create_user", requirements={"id": "\d+"})
     */
    public function createUserAction(Request $request, SponsorshipRequest $sponsorshipRequest)
    {
        $form = $this->get('form.factory')->create();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $this->createAccountWithRequest($sponsorshipRequest);
            $em->remove($sponsorshipRequest);
            $em->flush();
            $this->addFlash('info', 'Le compte a bien été créé.');
            $this->get('app.add_record')->addRecord('Création du compte pour la demande de parrainage de "'.$sponsorshipRequest->getEmail().'".');
            return $this->redirectToRoute('admin_sponsors_requests');
        }

        return $this->render('admin/sponsors/requests/create_user.html.twig', array(
            'form' => $form->createView(),
            'sponsorshipRequest' => $sponsorshipRequest
        ));
    }

    private function createAccountWithRequest(SponsorshipRequest $sponsorshipRequest)
    {
        $userManager = $this->get('fos_user.user_manager');

        $username = strtolower($sponsorshipRequest->getFirstName().$sponsorshipRequest->getLastName());
        $password = uniqid();

        $username_exist = $userManager->findUserByUsername($username);
        if($username_exist){
            $i = 1;
            do{
                $newUsername = $username.$i;
                $username_exist = $userManager->findUserByUsername($newUsername);
                $i++;
            }while($username_exist);
            $username = $newUsername;
        }

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($sponsorshipRequest->getEmail());
        $user->setCivility($sponsorshipRequest->getCivility());
        $user->setFirstName($sponsorshipRequest->getFirstName());
        $user->setLastName($sponsorshipRequest->getLastName());
        $user->setPhone($sponsorshipRequest->getPhone());
        $user->setAdress($sponsorshipRequest->getAddress());
        $user->setDateOfBirth($sponsorshipRequest->getDateOfBirth());
        $user->setPaymentChoice($sponsorshipRequest->getPaymentChoice());
        $user->addChild($sponsorshipRequest->getChild());
        $user->setEnabled(1);
        $user->setPlainPassword($password);
        $user->setRoles(array('ROLE_SPONSOR'));

        $userManager->updateUser($user);

        $sponsorshipRequest->getChild()->setSponsor($user);
        $this->getDoctrine()->getManager()->flush();

        $this->get('send.account_data')->sendAccountData($user);
    }
}