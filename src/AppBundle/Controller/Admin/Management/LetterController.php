<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:15
 */

namespace AppBundle\Controller\Admin\Management;

use AppBundle\Entity\Letter;
use AppBundle\Entity\Post;
use AppBundle\Form\LetterType;
use AppBundle\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/gestion/lettres")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class LetterController extends Controller
{
    /**
     * @Route("/{page}", name="admin_management_letters", requirements={"page": "\d*"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Letter');

        // Récupération de la liste des lettres pour la page demandée
        $nbPerPage = Letter::NUM_ITEMS;
        $lettersList = $repository->getLetters($page, $nbPerPage);
        $nbPageTotal = ceil(count($lettersList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/management/letter/index.html.twig', array(
            'lettersList' => $lettersList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/ajouter", name="admin_management_letters_add")
     */
    public function addAction(Request $request)
    {
        $letter = new Letter();
        $form = $this->createForm(LetterType::class, $letter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $letter->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($letter);
            $em->flush();

            $this->addFlash('info', 'La lettre a bien été ajoutée');
            return $this->redirectToRoute('admin_management_letters');
        }

        return $this->render('admin/management/letter/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_management_letters_edit", requirements={"id": "\d+"})
     */
    public function editLetterAction(Request $request, Letter $letter)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->hasRole('ROLE_MODERATOR')){
            if($letter->getIsPublished() || (!$letter->getIsPublished() && ($user->getId() != $letter->getAuthor()->getId()))){
                $this->addFlash('error', 'Vous n\'avez par le droit de modifier cette lettre.');
                return $this->redirectToRoute('admin_management_letters');
            }
        }

        $form = $this->createForm(LetterType::class, $letter);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($letter);
            $em->flush();

            $this->addFlash('info', 'La lettre a bien été modifiée');
            return $this->redirectToRoute('admin_management_letters');
        }

        return $this->render('admin/management/letter/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="admin_management_letters_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Letter $letter)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->hasRole('ROLE_MODERATOR')){
            if($letter->getIsPublished() || (!$letter->getIsPublished() && ($user->getId() != $letter->getAuthor()->getId()))){
                $this->addFlash('error', 'Vous n\'avez pas le droit de supprimer cette lettre.');
                return $this->redirectToRoute('admin_management_letters');
            }
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($letter);
            $em->flush();

            $this->addFlash('info', 'La lettre a bien été supprimée');
            return $this->redirectToRoute('admin_management_letters');
        }

        return $this->render('admin/management/letter/delete.html.twig', array(
            'form' => $form->createView(),
            'letter' => $letter
        ));
    }

    /**
     * @Route("/basculer-statut/{id}", name="admin_management_letters_toggle_published", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function togglePublishedAction(Letter $letter)
    {
        $letter->setIsPublished(!$letter->getIsPublished());
        $message = $letter->getIsPublished() ? "publiée." : "en attente de publication.";

        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info', 'La lettre du '.$letter->getCreationDate()->format('d/m/Y').' est maintenant '.$message);

        return $this->redirectToRoute('admin_management_letters');
    }
}