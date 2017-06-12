<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 11:25
 */

namespace AppBundle\Controller\Visitor;

use AppBundle\Entity\Post;
use AppBundle\Form\BlogSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class NewsController extends Controller
{
    /**
     * @Route("/blog/{page}", name="blog", requirements={"page": "\d*"})
     */
    public function blogIndexAction(Request $request, $page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post');

        $searchForm = $this->createForm(BlogSearchType::class);
        $searchForm->handleRequest($request);
        if($searchForm->isSubmitted()){
            $post = $searchForm->getData();
            $search = $post['search'];
            $listPosts = $repository->getPublishedPostsLike($search);
            $nbPageTotal = 1;

        } else {
            // Récupération de la liste des articles pour la page demandée
            $nbPerPage = Post::VISITOR_NUM_ITEMS;
            $listPosts = $repository->getPublishedPosts($page, $nbPerPage);
            $nbPageTotal = ceil(count($listPosts)/$nbPerPage);

            if($page>$nbPageTotal && $page != 1){
                throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
            }
        }

        return $this->render('visitor/news/blog_index.html.twig', array(
            'listPosts' => $listPosts,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'searchForm' => $searchForm->createView()
        ));
    }

    /**
     * @Route("/blog/{slug}", name="blog_view")
     */
    public function postViewAction(Post $post)
    {
        // SI L'ARTICLE N'EST PAS PUBLIÉ SEUL LES ADMINS ET MODERATEURS PEUVENT LE VOIR
        if(!$post->getPublished() && !$this->get('security.authorization_checker')->isGranted('ROLE_MODERATOR')){
            throw $this->createAccessDeniedException();
        }

        // Récupération des 3 derniers articles
        $lastPosts = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post')->findBy(array('published' => true), array('creationDate' => 'DESC'), 3, 0);

        return $this->render('visitor/news/blog_view.html.twig', array(
            'post' => $post,
            'lastPosts' => $lastPosts
        ));
    }

    /**
     * @Route("/lettre/{id}", name="letter")
     */
    public function letterAction($id = null)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Letter');

        if($id){
            $letter = $repository->find($id);
        } else {
            $letter = $repository->getLastLetter();
        }
        $previousLetter = $repository->getPreviousLetter($letter->getCreationDate());
        $nextLetter = $repository->getNextLetter($letter->getCreationDate());

        return $this->render('visitor/news/letter.html.twig', array(
            'letter' => $letter,
            'previousLetter' => $previousLetter,
            'nextLetter' => $nextLetter,
        ));
    }
}