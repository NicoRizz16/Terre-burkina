<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Donation;
use AppBundle\Entity\Record;
use AppBundle\Form\DonationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Route("/admin/registre")
 * @Security("has_role('ROLE_ADMIN')")
 */
class RecordsController extends Controller
{

    /**
     * @Route("/{page}", name="admin_records", requirements={"page": "\d+"})
     */
    public function indexAction($page = 1)
    {
        if($page<1){
            throw new NotFoundHttpException('Page "'.$page.'"inexistante.');
        }

        $this->removeOldRecords();

        $repository = $this->getDoctrine()->getManager()->getRepository('AppBundle:Record');

        // Récupération de la liste des donations pour la page demandée
        $nbPerPage = Record::NUM_ITEMS;
        $records = $repository->getRecords($page, $nbPerPage);
        $nbPageTotal = ceil(count($records)/$nbPerPage);

        if($page>$nbPageTotal && $page != 1){
            throw $this->createNotFoundException('La page "'.$page.'" n\'existe pas.');
        }

        return $this->render('admin/records/index.html.twig', array(
            'records' => $records,
            'nbPageTotal' => $nbPageTotal,
            'page' => $page
        ));
    }


    private function removeOldRecords()
    {
        $em = $this->getDoctrine()->getManager();

        // Suppression des actions qui datent de plus de 3 mois
        $date = (new \DateTime())->modify('-3 months');
        $records = $em->getRepository('AppBundle:Record')->getRecordsOlderThan($date);
        foreach ($records as $record)
        {
            $em->remove($record);
        }
        $em->flush();
    }


}