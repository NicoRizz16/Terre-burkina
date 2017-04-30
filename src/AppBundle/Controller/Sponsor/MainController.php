<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Sponsor;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/fasoma")
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="fasoma_homepage")
*/
    public function indexAction()
    {
        return $this->render('sponsor/main/index.html.twig');
    }
}
