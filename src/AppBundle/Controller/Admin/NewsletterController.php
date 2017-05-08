<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 06/05/2017
 * Time: 09:09
 */

namespace AppBundle\Controller\Admin;


use AppBundle\Entity\Newsletter;
use AppBundle\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/admin/gestion/newsletter")
 * @Security("has_role('ROLE_ADMIN')")
 */
class NewsletterController extends Controller
{
    /**
     * @Route("/{page}", name="admin_management_newsletter", requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Newsletter');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = Newsletter::NUM_ITEMS;
        $emailsList = $repository->getEmails($page, $nbPerPage);
        $nbPageTotal = ceil(count($emailsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/management/newsletter/index.html.twig', array(
            'emailsList' => $emailsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/ajouter", name="admin_management_newsletter_add")
     */
    public function addAction(Request $request)
    {
        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterType::class, $newsletter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newsletter);
            $em->flush();

            $this->addFlash('info', 'L\'adresse email "'.$newsletter->getEmail().'" a bien été ajoutée à la liste.');
            return $this->redirectToRoute('admin_management_newsletter');
        }

        return $this->render('admin/management/newsletter/add.html.twig', array(
            'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/supprimer/{id}", name="admin_management_newsletter_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Newsletter $newsletter)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($newsletter);
            $em->flush();

            $this->addFlash('info', 'L\'adresse "'.$newsletter->getEmail().'" a bien été supprimée.');
            return $this->redirectToRoute('admin_users');
        }

        return $this->render('admin/management/newsletter/delete.html.twig', array(
            'form' => $form->createView(),
            'newsletter' => $newsletter
        ));
    }

    /**
     * @Route("/exporter", name="admin_management_newsletter_export")
     */
    public function exportCsvAction()
    {
        $encoders = array(new CsvEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();
        $emails = $em->getRepository('AppBundle:Newsletter')->findAll();
        $data = $serializer->serialize($emails, 'csv');

        $fileUrl = '../app/Resources/newsletter/newsletter.csv';
        if(file_exists($fileUrl)){ // Suppression du fichier si il existe déjà
            unlink($fileUrl);
        }
        $file = fopen($fileUrl, "w"); // Ecriture du fichier
        fwrite($file, $data);
        fclose($file);

        return $this->file($fileUrl);
    }
}