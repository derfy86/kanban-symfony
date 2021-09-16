<?php
namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 

class CardController extends AbstractController
{
    /**
     *  @var CardRepository
     */
    private $repository;

    public function __construct(CardRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @Route("/cards")
     * @param CardRepository $repository
     * @return Response
     */

    public function index(CardRepository $repository): Response
    {
      $Card = $this->repository->findAll();
      return new Response(json_encode($Card));
    }
}  