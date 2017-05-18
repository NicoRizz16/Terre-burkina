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

class PhotosController extends Controller
{
    /**
     * @Route("/admin/filleuls/{id}/photos", name="admin_childs_photos", requirements={"id": "\d+"})
     */
    public function indexAction(Child $child)
    {
        $photos = $child->getPhotos();

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
     * @Method({"GET", "POST"})
     * @Route("/ajax/snippet/image/send/{id}", name="ajax_snippet_image_send", requirements={"id": "\d+"})
     */
    public function ajaxSnippetImageSendAction(Request $request, Child $child)
    {
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