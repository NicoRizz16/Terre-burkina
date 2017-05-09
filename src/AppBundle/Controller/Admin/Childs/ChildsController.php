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

/**
 * @Route("/admin/filleuls")
 */
class ChildsController extends Controller
{
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
            return $this->redirectToRoute('admin_management_newsletter');
        }

        return $this->render('admin/childs/childs/add.html.twig', array(
                'form' => $form->createView()
            )
        );
    }
}
