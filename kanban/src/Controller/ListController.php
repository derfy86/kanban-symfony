<?php
namespace App\Controller;

use App\Entity\ListContainer;
use App\Repository\ListContainerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 

class ListController extends AbstractController
{
    /**
     *  @var ListContainerRepository
     */
    private $repository;

    public function __construct(ListContainerRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @Route("/lists")
     * @param ListContainerRepository $repository
     * @return Response
     */

    public function index(ListContainerRepository $repository): Response
    {
      $listContainer = $this->repository->findAll();
      return new Response($listContainer);
    }
}  