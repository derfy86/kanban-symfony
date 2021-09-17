<?php
namespace App\Controller;

use App\Entity\Card;
use App\Repository\CardRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

 

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

 
    public function getAllCards(CardRepository $repository): Response
    {
      $encoders = [ new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];

      $serializer = new Serializer($normalizers, $encoders);
      $cards = $this->repository->findAll();
      $data = $serializer->serialize($cards, 'json');
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/cards_add")
     * @param CardRepository $repository
     * @return Response
     * @return Request
     */

    public function createCard(CardRepository $repository, Request $request): Response
    {
      $content = $request->request->get('content');
      $color = $request->request->get('color');
      $list_id = $request->request->get('list_id');
   
      $card = new Card();
      $card->setContent(content: $content)
      ->setPosition(position: 0)
      ->setColor(color: $color)
      ->setListId(list_id: $list_id);
      $em = $this->getDoctrine()->getManager();
      $em->persist($card);
      $em->flush();
      return new Response(json_encode($card));
    }
}  