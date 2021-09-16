<?php
namespace App\Controller;

use App\Entity\ListContainer;
use App\Repository\ListContainerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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

    public function getAllLists(ListContainerRepository $repository): Response
    {
      $listContainer = $this->repository->findAll();
      return new Response(json_encode($listContainer));
    }

    
    /**
     * @Route("/lists/add")
     * @param ListContainerRepository $repository
     * @return Response
     * @return Request
     */

    public function createList(ListContainerRepository $repository, Request $request): Response
    {
      $form = $request->request->get('name');
      $list = new ListContainer();
      $list->setName(name: 'first')
      ->setPosition(position: 0);
      $em = $this->getDoctrine()->getManager();
      $em->persist($list);
      $em->flush();
      return new Response(json_encode($list));
    }
}  