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
use AppBundle\Entity\FollowUpExport;
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
        $followUpExportList = array();

        // Tous les filleuls
        $childs = $em->getRepository('AppBundle:Child')->findBy(array(), array('lastName' => 'ASC'));
        foreach ($childs as $child){
            $followUpExport = new FollowUpExport();
            // Transfert des données vers FollowUpExport

            // STATUS PARRAINAGE
            //const STATUT_ATTENTE_PARRAIN = 0;
            //const STATUT_ATTENTE_VIREMENT = 1;
            //const STATUT_ATTENTE_ESPACE_FASOMA = 2;
            //const STATUT_EN_COURS = 3;
            //const STATUT_URGENT = 4;
            switch($child->getSponsorshipStatus()){
                case 0:
                    $followUpExport->setStatutParrainage('En attente de parrain');
                    break;
                case 1:
                    $followUpExport->setStatutParrainage('En attente de virement');
                    break;
                case 2:
                    $followUpExport->setStatutParrainage('En attente d\'espace FASOMA');
                    break;
                case 3:
                    $followUpExport->setStatutParrainage('En cours de parrainage');
                    break;
                case 4:
                    $followUpExport->setStatutParrainage('URGENT');
                    break;
            }

            $followUpExport->setFilleulNom($child->getLastName());
            $followUpExport->setFilleulPrenom($child->getfirstName());
            $followUpExport->setFilleulSexe($child->getSex());
            $followUpExport->setFilleulDateDeNaissance($child->getDateOfBirth()->format('d/m/Y'));
            $followUpExport->setFilleulAdresse($child->getFollowUpAdress());
            $followUpExport->setFilleulEcole($child->getSchool());
            $followUpExport->setFilleulClasse($child->getClass());
            $followUpExport->setFilleulSituationFamiliale($child->getFamilySituation());
            $followUpExport->setRemarque($child->getSponsorshipNote());

            if($child->getCoordinator() != null){
                $followUpExport->setCoordinateur($child->getCoordinator()->getUsername());
            }

            //CONST TYPE DE PARRAINAGE
            //const PARRAINAGE_CLASSIQUE = 0;
            //const PARRAINAGE_AUTRE = 1;
            //const PARRAINAGE_MAISON_LUC = 2;
            switch($child->getSponsorshipType()){
                case 0:
                    $followUpExport->setTypeParrainage('Classique');
                    break;
                case 1:
                    $followUpExport->setTypeParrainage('Autre');
                    break;
                case 2:
                    $followUpExport->setTypeParrainage('Maison de Luc');
                    break;
            }

            if($child->getSponsor() != null){ // INFOS SUR LE PARRAIN SI IL EXISTE
                $followUpExport->setParrainNom($child->getSponsor()->getLastName());
                $followUpExport->setParrainPrenom($child->getSponsor()->getFirstName());
                $followUpExport->setParrainAdresse($child->getSponsor()->getAdress());
                $followUpExport->setParrainTelephone($child->getSponsor()->getPhone());
                $followUpExport->setParrainEmail($child->getSponsor()->getEmail());
                $followUpExport->setParrainModeDeVersement($child->getSponsor()->getPaymentChoice());
            }

            // INFOS SUR LE SUIVI SI IL EXISTE ET QUE LA DATE CORRESPOND
            $followUp = $child->getFollowUp();
            if($followUp != null){
                if(((new \DateTime('now')) < $followUp->getEndYearDate()) && ((new \DateTime('now')) >= $followUp->getBeginYearDate()))
                {
                    // TOUT SUIVI
                    if($followUp->getLetter1() or $followUp->getPhoto1() or $followUp->getNews1() or $followUp->getResult1()){
                        $followUpExport->setSuiviJanvier('oui');
                    }
                    if($followUp->getLetter2() or $followUp->getPhoto2() or $followUp->getNews2() or $followUp->getResult2()){
                            $followUpExport->setSuiviFevrier('oui');
                    }
                    if($followUp->getLetter3() or $followUp->getPhoto3() or $followUp->getNews3() or $followUp->getResult3()){
                        $followUpExport->setSuiviMars('oui');
                    }
                    if($followUp->getLetter4() or $followUp->getPhoto4() or $followUp->getNews4() or $followUp->getResult4()){
                        $followUpExport->setSuiviAvril('oui');
                    }
                    if($followUp->getLetter5() or $followUp->getPhoto5() or $followUp->getNews5() or $followUp->getResult5()){
                        $followUpExport->setSuiviMai('oui');
                    }
                    if($followUp->getLetter6() or $followUp->getPhoto6() or $followUp->getNews6() or $followUp->getResult6()){
                        $followUpExport->setSuiviJuin('oui');
                    }
                    if($followUp->getLetter7() or $followUp->getPhoto7() or $followUp->getNews7() or $followUp->getResult7()){
                        $followUpExport->setSuiviJuillet('oui');
                    }
                    if($followUp->getLetter8() or $followUp->getPhoto8() or $followUp->getNews8() or $followUp->getResult8()){
                        $followUpExport->setSuiviAout('oui');
                    }
                    if($followUp->getLetter9() or $followUp->getPhoto9() or $followUp->getNews9() or $followUp->getResult9()){
                        $followUpExport->setSuiviSeptembre('oui');
                    }
                    if($followUp->getLetter10() or $followUp->getPhoto10() or $followUp->getNews10() or $followUp->getResult10()){
                        $followUpExport->setSuiviOctobre('oui');
                    }
                    if($followUp->getLetter11() or $followUp->getPhoto11() or $followUp->getNews11() or $followUp->getResult11()){
                        $followUpExport->setSuiviNovembre('oui');
                    }
                    if($followUp->getLetter12() or $followUp->getPhoto12() or $followUp->getNews12() or $followUp->getResult12()){
                        $followUpExport->setSuiviDecembre('oui');
                    }
                    
                    // SUIVI LETTRE
                    if($followUp->getLetter1()){$followUpExport->setSuiviJanvierLettre('oui');}
                    if($followUp->getLetter2()){$followUpExport->setSuiviFevrierLettre('oui');}
                    if($followUp->getLetter3()){$followUpExport->setSuiviMarsLettre('oui');}
                    if($followUp->getLetter4()){$followUpExport->setSuiviAvrilLettre('oui');}
                    if($followUp->getLetter5()){$followUpExport->setSuiviMaiLettre('oui');}
                    if($followUp->getLetter6()){$followUpExport->setSuiviJuinLettre('oui');}
                    if($followUp->getLetter7()){$followUpExport->setSuiviJuilletLettre('oui');}
                    if($followUp->getLetter8()){$followUpExport->setSuiviAoutLettre('oui');}
                    if($followUp->getLetter9()){$followUpExport->setSuiviSeptembreLettre('oui');}
                    if($followUp->getLetter10()){$followUpExport->setSuiviOctobreLettre('oui');}
                    if($followUp->getLetter11()){$followUpExport->setSuiviNovembreLettre('oui');}
                    if($followUp->getLetter12()){$followUpExport->setSuiviDecembreLettre('oui');}

                    // SUIVI PHOTO
                    if($followUp->getPhoto1()){$followUpExport->setSuiviJanvierPhoto('oui');}
                    if($followUp->getPhoto2()){$followUpExport->setSuiviFevrierPhoto('oui');}
                    if($followUp->getPhoto3()){$followUpExport->setSuiviMarsPhoto('oui');}
                    if($followUp->getPhoto4()){$followUpExport->setSuiviAvrilPhoto('oui');}
                    if($followUp->getPhoto5()){$followUpExport->setSuiviMaiPhoto('oui');}
                    if($followUp->getPhoto6()){$followUpExport->setSuiviJuinPhoto('oui');}
                    if($followUp->getPhoto7()){$followUpExport->setSuiviJuilletPhoto('oui');}
                    if($followUp->getPhoto8()){$followUpExport->setSuiviAoutPhoto('oui');}
                    if($followUp->getPhoto9()){$followUpExport->setSuiviSeptembrePhoto('oui');}
                    if($followUp->getPhoto10()){$followUpExport->setSuiviOctobrePhoto('oui');}
                    if($followUp->getPhoto11()){$followUpExport->setSuiviNovembrePhoto('oui');}
                    if($followUp->getPhoto12()){$followUpExport->setSuiviDecembrePhoto('oui');}

                    // SUIVI NOUVELLES
                    if($followUp->getNews1()){$followUpExport->setSuiviJanvierNouvelle('oui');}
                    if($followUp->getNews2()){$followUpExport->setSuiviFevrierNouvelle('oui');}
                    if($followUp->getNews3()){$followUpExport->setSuiviMarsNouvelle('oui');}
                    if($followUp->getNews4()){$followUpExport->setSuiviAvrilNouvelle('oui');}
                    if($followUp->getNews5()){$followUpExport->setSuiviMaiNouvelle('oui');}
                    if($followUp->getNews6()){$followUpExport->setSuiviJuinNouvelle('oui');}
                    if($followUp->getNews7()){$followUpExport->setSuiviJuilletNouvelle('oui');}
                    if($followUp->getNews8()){$followUpExport->setSuiviAoutNouvelle('oui');}
                    if($followUp->getNews9()){$followUpExport->setSuiviSeptembreNouvelle('oui');}
                    if($followUp->getNews10()){$followUpExport->setSuiviOctobreNouvelle('oui');}
                    if($followUp->getNews11()){$followUpExport->setSuiviNovembreNouvelle('oui');}
                    if($followUp->getNews12()){$followUpExport->setSuiviDecembreNouvelle('oui');}

                    // SUIVI RESULTATS
                    if($followUp->getResult1()){$followUpExport->setSuiviJanvierResultat('oui');}
                    if($followUp->getResult2()){$followUpExport->setSuiviFevrierResultat('oui');}
                    if($followUp->getResult3()){$followUpExport->setSuiviMarsResultat('oui');}
                    if($followUp->getResult4()){$followUpExport->setSuiviAvrilResultat('oui');}
                    if($followUp->getResult5()){$followUpExport->setSuiviMaiResultat('oui');}
                    if($followUp->getResult6()){$followUpExport->setSuiviJuinResultat('oui');}
                    if($followUp->getResult7()){$followUpExport->setSuiviJuilletResultat('oui');}
                    if($followUp->getResult8()){$followUpExport->setSuiviAoutResultat('oui');}
                    if($followUp->getResult9()){$followUpExport->setSuiviSeptembreResultat('oui');}
                    if($followUp->getResult10()){$followUpExport->setSuiviOctobreResultat('oui');}
                    if($followUp->getResult11()){$followUpExport->setSuiviNovembreResultat('oui');}
                    if($followUp->getResult12()){$followUpExport->setSuiviDecembreResultat('oui');}
                }
            }

            $em->persist($followUpExport);
            $followUpExportList[] = $followUpExport;
        }

        // Tous les parrains sans filleul
        $sponsors = $em->getRepository('AppBundle:User')->getSponsorsList();
        foreach ($sponsors as $sponsor){
            if(count($sponsor->getChilds()) == 0){
                $followUpExport = new FollowUpExport();
                // Transfert des données vers FollowUpExport
                $followUpExport->setParrainNom($sponsor->getLastName());
                $followUpExport->setParrainPrenom($sponsor->getFirstName());
                $followUpExport->setParrainAdresse($sponsor->getAdress());
                $followUpExport->setParrainTelephone($sponsor->getPhone());
                $followUpExport->setParrainEmail($sponsor->getEmail());
                $followUpExport->setParrainModeDeVersement($sponsor->getPaymentChoice());

                $em->persist($followUpExport);
                $followUpExportList[] = $followUpExport;
            }
        }

        $data = $serializer->serialize($followUpExportList, 'csv');

        $dataEndYear = (int)(new \DateTime('now'))->format('Y');
        if(((int)(new \DateTime('now'))->format('m'))> 9){
            $dataEndYear++;
        }

        $fileUrl = '../app/Resources/followup/TB_suivi_'.($dataEndYear-1).'_'.$dataEndYear.'.csv';
        if(file_exists($fileUrl)){ // Suppression du fichier si il existe déjà
            unlink($fileUrl);
        }
        $file = fopen($fileUrl, "w"); // Ecriture du fichier
        fwrite($file, $data);
        fclose($file);

        return $this->file($fileUrl);
    }

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
}
