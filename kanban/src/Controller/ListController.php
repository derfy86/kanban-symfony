<?php
namespace App\Controller;

use App\Entity\ListContainer;
use App\Repository\ListContainerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

 

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
      $encoders = [ new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];

      $serializer = new Serializer($normalizers, $encoders);
      $listContainer = $this->repository->findAll();
      $data = $serializer->serialize($listContainer, 'json');
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
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
      $list->setName(name: $form)
      ->setPosition(position: 0);
      $em = $this->getDoctrine()->getManager();
      $em->persist($list);
      $em->flush();
      return new Response(json_encode($list));
    }
}  