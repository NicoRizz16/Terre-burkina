<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Sponsor;

use AppBundle\Entity\Child;
use AppBundle\Entity\News;
use AppBundle\Entity\Photo;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/fasoma/filleul")
 * @Security("has_role('ROLE_SPONSOR')")
 */
class ChildsController extends Controller
{
    /**
     * @Route("/{id}/informations", name="fasoma_child_infos", requirements={"id": "\d+"})
     */
    public function infosAction(Child $child)
    {
        $user = $this->getUser();
        $this->checkSponsorAccess($user, $child);

        return $this->render('sponsor/child/infos.html.twig', array(
            'child' => $child
        ));
    }

    /**
     * @Route("/{id}/nouvelles/{page}", name="fasoma_child_news", requirements={"id": "\d+"})
     */
    public function newsAction(Child $child, $page = 1)
    {
        $user = $this->getUser();
        $this->checkSponsorAccess($user, $child);

        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $em = $this->getDoctrine()->getManager();

        $nbPerPage = News::NUM_ITEMS;
        $newsList = $em->getRepository('AppBundle:News')->getValidNewsPaginateByDate($child, $page, $nbPerPage);
        $nbPageTotal = ceil(count($newsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        $child->setNewsSeen(true);
        $em->flush();

        return $this->render('sponsor/child/news.html.twig', array(
            'child' => $child,
            'newsList' => $newsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }


    /**
     * @Route("/{id}/photos/{page}", name="fasoma_child_photos", requirements={"id": "\d+"})
     */
    public function photosAction(Child $child, $page = 1)
    {
        $user = $this->getUser();
        $this->checkSponsorAccess($user, $child);

        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }
        $em = $this->getDoctrine()->getManager();

        $nbPerPage = Photo::NUM_ITEMS;
        $photosList = $em->getRepository('AppBundle:Photo')->getPhotosPaginateByOrder($child, $page, $nbPerPage);
        $nbPageTotal = ceil(count($photosList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        $child->setPhotosSeen(true);
        $em->flush();

        return $this->render('sponsor/child/photos.html.twig', array(
            'child' => $child,
            'photosList' => $photosList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/{id}/resultats", name="fasoma_child_results", requirements={"id": "\d+"})
     */
    public function resultsAction(Child $child)
    {
        $user = $this->getUser();
        $this->checkSponsorAccess($user, $child);

        $em = $this->getDoctrine()->getManager();

        $resultsList = $em->getRepository('AppBundle:Result')->findBy(array('child' => $child), array('year' => 'DESC'));

        $child->setResultsSeen(true);
        $em->flush();

        return $this->render('sponsor/child/results.html.twig', array(
            'child' => $child,
            'resultsList' => $resultsList
        ));
    }



    private function checkSponsorAccess(User $user, Child $child){
        if(!$user->hasRole('ROLE_SPONSOR')){
            throw $this->createAccessDeniedException('Seuls les parrains peuvent accéder à l\'espace Fasoma');
        }
        if(!$user->hasChild($child)){
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux informations sur ce filleul.');
        }
    }
}
