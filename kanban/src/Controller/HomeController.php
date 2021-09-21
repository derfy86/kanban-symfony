<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 

class HomeController extends AbstractController
{
    /**
     * @Route("/")
     * @return Response
     */

    public function index(): Response
    {
      return $this->render('base.html.twig');
    }
}  