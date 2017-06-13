<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:15
 */

namespace AppBundle\Controller\Admin\Management;


use AppBundle\Entity\Gallery;
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

        //infos sur le document envoyé
        return new JsonResponse(array('success' => true));
    }
}