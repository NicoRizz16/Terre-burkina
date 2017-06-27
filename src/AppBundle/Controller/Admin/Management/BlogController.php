<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 10/05/2017
 * Time: 21:15
 */

namespace AppBundle\Controller\Admin\Management;


use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
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

    /**
     * @Route("/ajouter", name="admin_management_posts_add")
     */
    public function addAction(Request $request)
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('info', 'L\'article "'.$post->getTitle().'" a bien été ajouté');
            $this->get('app.add_record')->addRecord('Ajout d\'un article au blog : "'.$post->getTitle().'".');
            return $this->redirectToRoute('admin_management_posts');
        }

        return $this->render('admin/management/blog/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/modifier/{id}", name="admin_management_posts_edit", requirements={"id": "\d+"})
     */
    public function editPostAction(Request $request, Post $post)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->hasRole('ROLE_MODERATOR')){
            if($post->getPublished() || (!$post->getPublished() && ($user->getId() != $post->getAuthor()->getId()))){
                $this->addFlash('error', 'Vous n\'avez par le droit de modifier cet article.');
                return $this->redirectToRoute('admin_management_posts');
            }
        }

        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('info', 'L\'article "'.$post->getTitle().'" a bien été modifié');
            $this->get('app.add_record')->addRecord('Modification de l\'article du blog : "'.$post->getTitle().'".');
            return $this->redirectToRoute('admin_management_posts');
        }

        return $this->render('admin/management/blog/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/supprimer/{id}", name="admin_management_posts_delete", requirements={"id": "\d+"})
     */
    public function deleteAction(Request $request, Post $post)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if($user->hasRole('ROLE_MODERATOR')){
            if($post->getPublished() || (!$post->getPublished() && ($user->getId() != $post->getAuthor()->getId()))){
                $this->addFlash('error', 'Vous n\'avez pas le droit de supprimer cet article.');
                return $this->redirectToRoute('admin_management_posts');
            }
        }

        $form = $this->get('form.factory')->create();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($post);
            $em->flush();

            $this->addFlash('info', 'L\'article "'.$post->getTitle().'" a bien été supprimé');
            $this->get('app.add_record')->addRecord('Suppression de l\'article du blog : "'.$post->getTitle().'".');
            return $this->redirectToRoute('admin_management_posts');
        }

        return $this->render('admin/management/blog/delete.html.twig', array(
            'form' => $form->createView(),
            'post' => $post
        ));
    }

    /**
     * @Route("/basculer-statut/{id}", name="admin_management_posts_toggle_published", requirements={"id": "\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function togglePublishedAction(Request $request, Post $post)
    {
        $post->setPublished(!$post->getPublished());
        $message = $post->getPublished() ? "publié." : "en attente de publication.";

        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('info', 'L\'article "'.$post->getTitle().'" est maintenant '.$message);
        $this->get('app.add_record')->addRecord('Changement d\'état de l\'article du blog "'.$post->getTitle().'" : '.$message);

        return $this->redirectToRoute('admin_management_posts');
    }
}