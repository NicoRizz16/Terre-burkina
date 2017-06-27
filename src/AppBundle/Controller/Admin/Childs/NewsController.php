<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 21/05/2017
 * Time: 21:04
 */

namespace AppBundle\Controller\Admin\Childs;

use AppBundle\Entity\Child;
use AppBundle\Entity\ChildGroup;
use AppBundle\Entity\News;
use AppBundle\Form\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/admin/filleuls/nouvelles")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class NewsController extends Controller
{
    /**
     * @Route("/filleul/{id}/ajouter", name="admin_childs_news_child_add", requirements={"id": "\d+"})
     */
    public function childAddAction(Request $request, Child $child)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setIsValid(true);
            $news->setChild($child);
            $news->getChild()->setNewsSeen(false); // Notification de nouvelles

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été ajoutée');
            return $this->redirectToRoute('admin_childs_news_child', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_news_add.html.twig', array(
            'child' => $child,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/filleul/{id}/{page}", name="admin_childs_news_child", requirements={"id": "\d+"})
     */
    public function childIndexAction(Child $child, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:News');

        // Récupération de la liste des nouvelles pour la page demandée
        $nbPerPage = News::NUM_ITEMS_ADMIN;
        $newsList = $repository->getValidChildNewsPaginateByDate($child->getId(), $page, $nbPerPage);
        $nbPageTotal = ceil(count($newsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/childs/childs/view_news.html.twig', array(
            'child' => $child,
            'newsList' => $newsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/filleul/{child_id}/supprimer/{news_id}", name="admin_childs_news_child_delete", requirements={"child_id": "\d+", "news_id": "\d+"})
     * @ParamConverter("child", class="AppBundle:Child", options={"id" = "child_id"})
     * @ParamConverter("news", class="AppBundle:News", options={"id" = "news_id"})
     */
    public function childDeleteAction(Request $request, Child $child, News $news)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été supprimée.');
            return $this->redirectToRoute('admin_childs_news_child', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_news_delete.html.twig', array(
            'form' => $form->createView(),
            'child' => $child,
            'news' => $news
        ));
    }

    /**
     * @Route("/filleul/{child_id}/modifier/{news_id}", name="admin_childs_news_child_edit", requirements={"child_id": "\d+", "news_id": "\d+"})
     * @ParamConverter("child", class="AppBundle:Child", options={"id" = "child_id"})
     * @ParamConverter("news", class="AppBundle:News", options={"id" = "news_id"})
     */
    public function childEditAction(Request $request, Child $child, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été modifiée.');
            return $this->redirectToRoute('admin_childs_news_child', array('id' => $child->getId()));
        }

        return $this->render('admin/childs/childs/view_news_edit.html.twig', array(
            'form' => $form->createView(),
            'child' => $child,
            'news' => $news
        ));
    }

    /**
     * @Route("/groupe/{id}/ajouter", name="admin_childs_news_group_add", requirements={"id": "\d+"})
     */
    public function groupAddAction(Request $request, ChildGroup $childGroup)
    {
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setIsValid(true);
            $news->setGroup($childGroup);
            $this->notifyChildsOfGroup($childGroup); // Notification de nouvelles

            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été ajoutée');
            return $this->redirectToRoute('admin_childs_news_group', array('id' => $childGroup->getId()));
        }

        return $this->render('admin/childs/groups/view_news_add.html.twig', array(
            'group' => $childGroup,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/groupe/{id}/{page}", name="admin_childs_news_group", requirements={"id": "\d+"})
     */
    public function groupIndexAction(ChildGroup $childGroup, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:News');

        // Récupération de la liste des nouvelles pour la page demandée
        $nbPerPage = News::NUM_ITEMS_ADMIN;
        $newsList = $repository->getValidGroupNewsPaginateByDate($childGroup->getId(), $page, $nbPerPage);
        $nbPageTotal = ceil(count($newsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/childs/groups/view_news.html.twig', array(
            'group' => $childGroup,
            'newsList' => $newsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/groupe/{group_id}/supprimer/{news_id}", name="admin_childs_news_group_delete", requirements={"group_id": "\d+", "news_id": "\d+"})
     * @ParamConverter("childGroup", class="AppBundle:ChildGroup", options={"id" = "group_id"})
     * @ParamConverter("news", class="AppBundle:News", options={"id" = "news_id"})
     */
    public function groupDeleteAction(Request $request, ChildGroup $childGroup, News $news)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été supprimée.');
            return $this->redirectToRoute('admin_childs_news_group', array('id' => $childGroup->getId()));
        }

        return $this->render('admin/childs/groups/view_news_delete.html.twig', array(
            'form' => $form->createView(),
            'group' => $childGroup,
            'news' => $news
        ));
    }

    /**
     * @Route("/groupe/{group_id}/modifier/{news_id}", name="admin_childs_news_group_edit", requirements={"group_id": "\d+", "news_id": "\d+"})
     * @ParamConverter("childGroup", class="AppBundle:ChildGroup", options={"id" = "group_id"})
     * @ParamConverter("news", class="AppBundle:News", options={"id" = "news_id"})
     */
    public function groupEditAction(Request $request, ChildGroup $childGroup, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle a bien été modifiée.');
            return $this->redirectToRoute('admin_childs_news_group', array('id' => $childGroup->getId()));
        }

        return $this->render('admin/childs/groups/view_news_edit.html.twig', array(
            'form' => $form->createView(),
            'group' => $childGroup,
            'news' => $news
        ));
    }

    /**
     * @Route("/coordination", name="admin_childs_news_coordination")
     */
    public function coordinationIndexAction()
    {
        $newsList = $this->getDoctrine()->getManager()->getRepository('AppBundle:News')->findBy(array('isValid' => false), array('creationDate' => 'ASC'));

        return $this->render('admin/childs/coordination/index.html.twig', array(
            'newsList' => $newsList
        ));
    }

    /**
     * @Route("/coordination/{id}", name="admin_childs_news_coordination_validate", requirements={"id": "\d+"})
     */
    public function coordinationValidationAction(Request $request, News $news)
    {
        $form = $this->createForm(NewsType::class, $news);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $news->setIsValid(true);
            $news->getChild()->setNewsSeen(false); // Notification de nouvelles
            $em = $this->getDoctrine()->getManager();
            $em->persist($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été validée.');
            return $this->redirectToRoute('admin_childs_news_coordination');
        }

        return $this->render('admin/childs/coordination/validation.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    /**
     * @Route("/coordination/supprimer/{id}", name="admin_childs_news_coordination_delete", requirements={"id": "\d+"})
     */
    public function coordinationDeleteAction(Request $request,  News $news)
    {
        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($news);
            $em->flush();

            $this->addFlash('info', 'La nouvelle "'.$news->getTitle().'" a bien été supprimée.');
            return $this->redirectToRoute('admin_childs_news_coordination');
        }

        return $this->render('admin/childs/coordination/delete.html.twig', array(
            'form' => $form->createView(),
            'news' => $news
        ));
    }

    private function notifyChildsOfGroup(ChildGroup $childGroup){
        foreach ($childGroup->getChilds() as $child){
            $child->setNewsSeen(false);
        }
        $this->getDoctrine()->getManager()->flush();
    }
}
