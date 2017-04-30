<?php

/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 29/04/2017
 * Time: 10:54
 */

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class MainController extends Controller
{
    /**
     * @Route("/", name="admin_board")
     */
    public function indexAction()
    {
        return $this->render('admin/board/index.html.twig');
    }
}
