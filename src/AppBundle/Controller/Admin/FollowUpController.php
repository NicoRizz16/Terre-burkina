<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Child;
use AppBundle\Entity\FollowUp;
use AppBundle\Entity\User;
use AppBundle\Utils\updateChildFollowUp;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/admin/suivi")
 */
class FollowUpController extends Controller
{
    /**
     * @Route("/{by}/{is_by_a_child_parameter}/{order}/{page}/{coordinator_id}", name="admin_followup", defaults={"by": "lastName", "is_by_a_child_parameter": "true", "order": "ASC", "page": 1}, requirements={"page": "\d+"})
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function indexAction($by, $is_by_a_child_parameter, $order, $page = 1, $coordinator_id = null)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $isByAChildParameter = true;

        if($is_by_a_child_parameter == 'false'){
            $isByAChildParameter = false;
        }

        $coordinator = null;

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Child');

        // Récupération de la liste des filleuls pour la page demandée
        $nbPerPage = FollowUp::NUM_ITEMS;

        // Un coordinateur est-il selectionné ?
        if($coordinator_id == null){ // Récup tous les filleuls
            $childsList = $repository->getFollowUpChilds($page, $nbPerPage, $by, $isByAChildParameter, $order);
        } else { // Recup filleuls du coordinateur
            // Recup coordinateur
            $coordinator = $this->getDoctrine()->getRepository('AppBundle:User')->find($coordinator_id);
            if($coordinator == null){
                throw new NotFoundHttpException('Le coordinateur recherché n\'exsite pas.');
            }
            $childsList = $repository->getFollowUpChilds($page, $nbPerPage, $by, $isByAChildParameter, $order, $coordinator);
        }

        $nbPageTotal = ceil(count($childsList)/$nbPerPage);
        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        // Récupération de la liste des coordinateurs
        $coordinatorsList = $this->getDoctrine()->getRepository('AppBundle:User')->getCoordinators();

        $isByAChildParameter ? $isByAChildParameter = "true" : $isByAChildParameter = "false";

        // Récupération de la liste des sponsors
        $sponsorsList = $this->getDoctrine()->getRepository('AppBundle:User')->getSponsorsList();

        return $this->render('admin/followup/index.html.twig', array(
            'childsList' => $childsList,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page,
            'by' => $by,
            'order' => $order,
            'coordinator_id' => $coordinator_id,
            'isByAChildParameter'=> $isByAChildParameter,
            'coordinatorsList' => $coordinatorsList,
            'coordinator' => $coordinator,
            'sponsorsList' => $sponsorsList
        ));
    }

    /**
     * @Route("/exporter", name="admin_followup_export")
     * @Security("has_role('ROLE_MODERATOR')")
     */
    public function exportCsvAction()
    {
        $encoders = array(new CsvEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $em = $this->getDoctrine()->getManager();

        // Récupération de la liste des objets FollowUpExport
        $followUpExportList = null;
        //$emails = $em->getRepository('AppBundle:Newsletter')->findAll();


        $data = $serializer->serialize($followUpExportList, 'csv');

        $fileUrl = '../app/Resources/followup/suivi.csv';
        if(file_exists($fileUrl)){ // Suppression du fichier si il existe déjà
            unlink($fileUrl);
        }
        $file = fopen($fileUrl, "w"); // Ecriture du fichier
        fwrite($file, $data);
        fclose($file);

        return $this->file($fileUrl);
    }
}
