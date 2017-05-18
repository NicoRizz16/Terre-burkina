<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin\Childs;

use AppBundle\Entity\Child;
use AppBundle\Form\ChildType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/admin/filleuls")
 * @Security("has_role('ROLE_MODERATOR')")
 */
class ChildsController extends Controller
{
    /**
     * @Route("/{page}", name="admin_childs", requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Child');

        // Récupération de la liste des utilisateurs pour la page demandée
        $nbPerPage = Child::NUM_ITEMS;
        $childsList = $repository->getChilds($page, $nbPerPage);
        $nbPageTotal = ceil(count($childsList)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/childs/childs/index.html.twig', array(
            'childsList' => $childsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }

    /**
     * @Route("/ajouter", name="admin_childs_add")
     */
    public function addAction(Request $request)
    {
        $child = new Child();
        $form = $this->createForm(ChildType::class, $child);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            $em->flush();

            $this->addFlash('info', 'Le filleul "'.$child->getFirstName().' '.$child->getLastName().'" a bien été enregistré.');
            return $this->redirectToRoute('admin_childs');
        }

        return $this->render('admin/childs/childs/add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }

    /**
     * @Route("/{id}/infos", name="admin_childs_view_infos", requirements={"id": "\d+"})
     */
    public function viewAction(Child $child)
    {
        return $this->render('admin/childs/childs/view_infos.html.twig', array(
            'child' => $child
        ));
    }
}
