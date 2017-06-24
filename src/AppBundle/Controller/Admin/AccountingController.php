<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Donation;
use AppBundle\Entity\News;
use AppBundle\Form\ChildNewsType;
use AppBundle\Form\DonationType;
use AppBundle\Form\GroupNewsType;
use AppBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/comptabilite")
 * @Security("has_role('ROLE_ADMIN')")
 */
class AccountingController extends Controller
{

    /**
     * @Route("/dons/{page}", name="admin_accounting_donations", requirements={"page": "\d+"})
     */
    public function donationsAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Donation');

        // Récupération de la liste des donations pour la page demandée
        $nbPerPage = Donation::NUM_ITEMS;
        $donationsList = $repository->getDonations($page, $nbPerPage);
        $nbPageTotal = ceil(count($donationsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/accounting/donations/historic.html.twig', array(
            'donationsList' => $donationsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/dons/ajouter", name="admin_accounting_donations_add")
     */
    public function donationAddAction(Request $request)
    {
        $donation = new Donation();
        $form = $this->createForm(DonationType::class, $donation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($donation);
            $em->flush();

            $this->addFlash('info', 'Le don a bien été ajouté');
            return $this->redirectToRoute('admin_accounting_donations');
        }

        return $this->render('admin/accounting/donations/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dons/supprimer/{id}", name="admin_accounting_donations_delete", requirements={"id": "\d+"})
     */
    public function donationDeleteAction(Donation $donation){
        $em = $this->getDoctrine()->getManager();
        $em->remove($donation);
        $em->flush();
        $this->addFlash('info', 'Le don a bien été supprimé.');
        return $this->redirectToRoute('admin_accounting_donations');
    }


}