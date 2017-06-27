<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 18/05/2017
 * Time: 10:50
 */

namespace AppBundle\Controller\Admin\Sponsors;


use AppBundle\Entity\Document;
use AppBundle\Entity\SponsorGroup;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_MODERATOR')")
 */
class DocumentsController extends Controller
{
    /**
     * @Route("/admin/parrains/{id}/documents", name="admin_sponsors_documents", requirements={"id": "\d+"})
     */
    public function indexAction(User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain dont vous souhaitez consulter les documents n\'existe pas.');
        }

        $documents = $this->getDoctrine()->getManager()->getRepository('AppBundle:Document')->findBy(array('user' => $user), array('order' => 'DESC'));

        return $this->render('admin/sponsors/sponsors/view_documents.html.twig', array(
            'sponsor' => $user,
            'documents' => $documents
        ));
    }

    /**
     * @Route("/admin/parrains/{id}/documents/ajouter", name="admin_sponsors_documents_add", requirements={"id": "\d+"})
     */
    public function addAction(User $user)
    {
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw new NotFoundHttpException('Le parrain auquel vous souhaitez ajouter des documents n\'existe pas.');
        }

        return $this->render('admin/sponsors/sponsors/view_documents_add.html.twig', array(
            'sponsor' => $user
        ));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/snippet/document/delete", name="ajax_snippet_document_delete")
     */
    public function ajaxSnippetDocumentDeleteAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $documentID = $request->query->get('documentId');

        $document = $em->getRepository('AppBundle:Document')->findOneBy(array('id' => $documentID));

        $em->remove($document);
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET"})
     * @Route("/ajax/snippet/document/up", name="ajax_snippet_document_up")
     */
    public function ajaxSnippetDocumentUpAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();
        $documentID = $request->query->get('documentId');

        $document = $em->getRepository('AppBundle:Document')->findOneBy(array('id' => $documentID));
        $document->setOrder(new \DateTime());
        $em->flush();

        return new JsonResponse(array('success' => true));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/snippet/document/send/{id}", name="ajax_snippet_document_send", requirements={"id": "\d+"})
     */
    public function ajaxSnippetDocumentSendAction(Request $request, User $user)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file');

        $document = new Document();
        $document->setOriginalName($file->getClientOriginalName());
        $document->setFile($file);
        $document->setUser($user);
        $em->persist($document);

        $user->setDocumentConsulted(false); // Notification de documents
        $em->flush();

        //infos sur le document envoyé
        return new JsonResponse(array('success' => true));
    }

    /**
     * @Route("/admin/groupe/{id}/documents", name="admin_sponsors_group_documents", requirements={"id": "\d+"})
     */
    public function groupIndexAction(SponsorGroup $group)
    {
        $documents = $this->getDoctrine()->getManager()->getRepository('AppBundle:Document')->findBy(array('group' => $group), array('order' => 'DESC'));

        return $this->render('admin/sponsors/groups/view_documents.html.twig', array(
            'group' => $group,
            'documents' => $documents
        ));
    }

    /**
     * @Route("/admin/groupe/{id}/documents/ajouter", name="admin_sponsors_group_documents_add", requirements={"id": "\d+"})
     */
    public function groupAddAction(SponsorGroup $group)
    {
        return $this->render('admin/sponsors/groups/view_documents_add.html.twig', array(
            'group' => $group
        ));
    }

    /**
     * @Method({"GET", "POST"})
     * @Route("/ajax/group/snippet/document/send/{id}", name="ajax_group_snippet_document_send", requirements={"id": "\d+"})
     */
    public function ajaxGroupSnippetDocumentSendAction(Request $request, SponsorGroup $group)
    {
        if (!$request->isXmlHttpRequest()){
            return new JsonResponse(array('message' => 'You can access this only using AJAX !'), 400);
        }

        $em = $this->getDoctrine()->getManager();

        $file = $request->files->get('file');

        $document = new Document();
        $document->setOriginalName($file->getClientOriginalName());
        $document->setFile($file);
        $document->setGroup($group);
        $em->persist($document);

        $this->notifyUsersOfGroup($group); // Notifications de documents
        $em->flush();

        //infos sur le document envoyé
        return new JsonResponse(array('success' => true));
    }

    private function notifyUsersOfGroup(SponsorGroup $group){
        foreach ($group->getUsers() as $user){
            $user->setDocumentConsulted(false);
        }
        $this->getDoctrine()->getManager()->flush();
    }

}