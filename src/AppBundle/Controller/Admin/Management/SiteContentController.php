<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:15
 */

namespace AppBundle\Controller\Admin\Management;


use AppBundle\Entity\Action;
use AppBundle\Entity\Gallery;
use AppBundle\Form\ActionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/admin/gestion/contenu")
 * @Security("has_role('ROLE_ADMIN')")
 */
class SiteContentController extends Controller
{
    /**
     * @Route("/galerie", name="admin_management_content_gallery")
     */
    public function galleryIndexAction()
    {
        $photos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Gallery')->findBy(array(), array('order' => 'DESC'));

        return $this->render('admin/management/gallery/index.html.twig', array(
            'photos' => $photos
        ));
    }

    /**
     * @Route("/galerie/ajouter", name="admin_management_content_gallery_add")
     */
    public function galleryAddAction()
    {
        return $this->render('admin/management/gallery/add.html.twig');
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/gallery/delete", name="ajax_gallery_delete")
     */
    public function ajaxGalleryDeleteAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $photoID = $request->query->get('photoId');

        $photo = $em->getRepository('AppBundle:Gallery')->find($photoID);

        $em->remove($photo);
        $em->flush();

        $this->get('app.add_record')->addRecord('Suppression d\'une photo à la galerie photo des parrainages.');

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/gallery/up", name="ajax_gallery_up")
     */
    public function ajaxGalleryUpAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $photoID = $request->query->get('photoId');

        $photo = $em->getRepository('AppBundle:Gallery')->find($photoID);
        $photo->setOrder(new \DateTime());
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/gallery/send", name="ajax_gallery_send")
     */
    public function ajaxGallerySendAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file');

        $gallery = new Gallery();
        $gallery->setImageFile($file);

        $em->persist($gallery);
        $em->flush();

        $this->get('app.add_record')->addRecord('Ajout d\'une photo à la galerie photo des parrainages.');

        //infos sur le document envoyé
        return new JsonResponse(array('success' => true));
    }


    /**
     * @Route("/actions/{page}", name="admin_management_actions", requirements={"page": "\d*"})
     */
    public function actionsIndexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Action');

        // Récupération de la liste des articles pour la page demandée
        $nbPerPage = Action::NUM_ITEMS;
        $actionsList = $repository->getActions($page, $nbPerPage);
        $nbPageTotal = ceil(count($actionsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/management/action/index.html.twig', array(
            'actionsList' => $actionsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/actions/ajouter", name="admin_management_actions_add")
     */
    public function actionsAddAction(Request $request)
    {
        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            $this->addFlash('info', 'L\'action "'.$action->getTitle().'" a bien été ajoutée.');
            $this->get('app.add_record')->addRecord('Ajout de l\'action "'.$action->getTitle().'" à la page "Nos actions".');
            return $this->redirectToRoute('admin_management_actions');
        }

        return $this->render('admin/management/action/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/actions/modifier/{id}", name="admin_management_actions_edit", requirements={"id": "\d+"})
     */
    public function actionsEditAction(Request $request, Action $action)
    {
        $form = $this->createForm(ActionType::class, $action);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($action);
            $em->flush();

            $this->addFlash('info', 'L\'action "'.$action->getTitle().'" a bien été modifiée.');
            $this->get('app.add_record')->addRecord('Modification de l\'action "'.$action->getTitle().'" de la page "Nos actions".');
            return $this->redirectToRoute('admin_management_actions');
        }

        return $this->render('admin/management/action/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/actions/supprimer/{id}", name="admin_management_actions_delete", requirements={"id": "\d+"})
     */
    public function actionsDeleteAction(Request $request, Action $action)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($action);
            $em->flush();

            $this->addFlash('info', 'L\'action "'.$action->getTitle().'" a bien été supprimée.');
            $this->get('app.add_record')->addRecord('Suppression de l\'action "'.$action->getTitle().'" de la page "Nos actions".');

            return $this->redirectToRoute('admin_management_actions');
        }

        return $this->render('admin/management/action/delete.html.twig', array(
            'form' => $form->createView(),
            'action' => $action
        ));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/action/up", name="ajax_action_up")
     */
    public function ajaxActionUpAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $actionID = $request->query->get('actionId');

        $action = $em->getRepository('AppBundle:Action')->find($actionID);
        $action->setPriority(new \DateTime());
        $em->flush();

        return new JsonResponse(array('success' => true));
    }
}