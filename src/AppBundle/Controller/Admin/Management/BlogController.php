<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:15
 */

namespace AppBundle\Controller\Admin\Management;


use AppBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/gestion/blog")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class BlogController extends Controller
{
    /**
     * @Route("/{page}", name="admin_management_posts", requirements={"page": "\d*"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Post');

        // Récupération de la liste des articles pour la page demandée
        $nbPerPage = Post::NUM_ITEMS;
        $listPosts = $repository->getPosts($page, $nbPerPage);
        $nbPageTotal = ceil(count($listPosts)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/management/blog/index.html.twig', array(
            'listPosts' => $listPosts,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }
}