<?php
namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

 

class TagController extends AbstractController
{
    /**
     *  @var TagRepository
     */
    private $repository;

    public function __construct(TagRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @Route("/tags")
     * @param TagRepository $repository
     * @return Response
     */

    public function index(TagRepository $repository): Response
    {
      $Tag = $this->repository->findAll();
      return new Response(json_encode($Tag));
    }
}  