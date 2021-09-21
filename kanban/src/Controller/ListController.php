<?php
namespace App\Controller;

use App\Entity\ListContainer;
use App\Repository\ListContainerRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

 

class ListController extends AbstractController
{
    /**
     *  @var ListContainerRepository
     */
    private $repository;

    public function seraliz()
    {
      $encoders = [ new JsonEncoder()];
      $normalizer = [new ObjectNormalizer()];
      $serializer = new Serializer($normalizer, $encoders);
      return $serializer;
    }

    public function __construct(ListContainerRepository $repository)
    {
      $this->repository = $repository;
    }

    /**
     * @Route("/lists")
     * @param ListContainerRepository $repository
     * @return Response
     */

    public function getAllLists(ListContainerRepository $repository, SerializerInterface $serializer): Response
    {
      $listContainer = $this->repository->findAll();
      $data = $serializer->serialize($listContainer, 'json', ['groups' => ['list', 'cards_list', 'card']]);
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/lists/{id}")
     * @param ListContainerRepository $repository
     * @return Response
     */

    public function getOneList(ListContainerRepository $repository, $id,  SerializerInterface $serializer): Response
    {
      $listContainer = $this->repository->find($id);
      // $allCards = $listContainer->getCards();
      // $cards = $serializer->serialize($allCards, 'json', ['groups' => ['card', 'lists_card', 'lists']]);
      // dump($cards) ;
      // die();
      // $allCardsJson = $serializer->serialize($allCards, 'json', ['groups' => ['cards_list']]);
      
      // foreach ($allCards as $value)
      //   {
      //     $value2 =  $serializer->serialize($value, 'json', ['groups' => ['card']]);
      //     dump($value2) ;
      //     die();

      //   }
      $data = $serializer->serialize($listContainer, 'json', ['groups' => ['list','cards_list', 'card']]);
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }
    
    /**
     * @Route("/lists_add")
     * @param ListContainerRepository $repository
     * @return Response
     * @return Request
     */
    
    public function createList(ListContainerRepository $repository, Request $request): Response
    {
      $serializer = $this->seraliz();

      $name = $request->request->get('name');

      $list = new ListContainer();
      $list->setName(name: $name)
      ->setPosition(position: 0);
      $em = $this->getDoctrine()->getManager();
      $em->persist($list);
      $em->flush();
      $data = $serializer->serialize($list, 'json', ['groups' => ['list']]);
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/lists/delete/{id}")
     * @param ListContainerRepository $repository
     * @return Response
     */
  
    public function deleteList(ListContainerRepository $repository, $id): Response
    {
      $listContainer = $this->repository->find($id);
      $em = $this->getDoctrine()->getManager();
      $em->remove($listContainer);
      $em->flush();
      return new Response('done');
    }
  }  