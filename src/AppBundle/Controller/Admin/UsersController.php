<?php
/**
 * Created by PhpStorm.
 * User: Nicolas
 * Date: 30/04/2017
 * Time: 10:48
 */

namespace AppBundle\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/admin/users")
 */
class UsersController extends Controller
{
    /**
     * @Route("/", name="admin_users")
     */
    public function indexAction()
    {
        return $this->render('admin/users/index.html.twig');
    }

}