<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 18/05/2017
 * Time: 10:50
 */

namespace AppBundle\Controller\Admin\Childs;


use AppBundle\Entity\Child;
use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_MODERATOR')")
 */
class PhotosController extends Controller
{
    /**
     * @Route("/admin/filleuls/{id}/photos", name="admin_childs_photos", requirements={"id": "\d+"})
     */
    public function indexAction(Child $child)
    {
        $photos = $this->getDoctrine()->getManager()->getRepository('AppBundle:Photo')->findBy(array('child' => $child), array('order' => 'DESC'));

        return $this->render('admin/childs/childs/view_photos.html.twig', array(
            'child' => $child,
            'photos' => $photos
        ));
    }

    /**
     * @Route("/admin/filleuls/{id}/photos/ajouter", name="admin_childs_photos_add", requirements={"id": "\d+"})
     */
    public function addAction(Child $child)
    {
        return $this->render('admin/childs/childs/view_photos_add.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/snippet/image/delete", name="ajax_snippet_image_delete")
     */
    public function ajaxSnippetImageDeleteAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $photoID = $request->query->get('photoId');

        $photo = $em->getRepository('AppBundle:Photo')->findOneBy(array('id' => $photoID));

        $em->remove($photo);
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/snippet/image/up", name="ajax_snippet_image_up")
     */
    public function ajaxSnippetImageUpAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $photoID = $request->query->get('photoId');

        $photo = $em->getRepository('AppBundle:Photo')->findOneBy(array('id' => $photoID));
        $photo->setOrder(new \DateTime());
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/snippet/image/send/{id}", name="ajax_snippet_image_send", requirements={"id": "\d+"})
     */
    public function ajaxSnippetImageSendAction(Request $request, Child $child)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file');

        $photo = new Photo();
        $photo->setImageFile($file);
        $photo->setChild($child);

        $em->persist($photo);
        $em->flush();

        //infos sur le document envoyé
        return new JsonResponse(array('success' => true));
    }
}