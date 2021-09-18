<?php
namespace App\Controller;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

 

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

    public function getAllTags(TagRepository $repository): Response
    {
      $encoders = [ new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $serializer = new Serializer($normalizers, $encoders);

      $tag = $this->repository->findAll();
      $data = $serializer->serialize($tag, 'json');
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/tags/{id}")
     * @param Tag $repository
     * @return Response
     */

    public function getOneCard(Tag $repository, $id): Response
    {
      $encoders = [ new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $serializer = new Serializer($normalizers, $encoders);

      $tag = $this->repository->find($id);
      $data = $serializer->serialize($tag, 'json');
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/tags_add")
     * @param TagRepository $repository
     * @return Response
     * @return Request
     */
    
    public function createTag(TagRepository $repository, Request $request): Response
    {
      $encoders = [ new JsonEncoder()];
      $normalizers = [new ObjectNormalizer()];
      $serializer = new Serializer($normalizers, $encoders);

      $name = $request->request->get('name');
      $color = $request->request->get('color');

      $tag = new Tag();
      $tag->setName(name: $name)
      ->setColor(color: $color);
      $em = $this->getDoctrine()->getManager();
      $em->persist($tag);
      $em->flush();
      $data = $serializer->serialize($tag, 'json');
      $response = new Response();
      $response->setContent(
        $data
      );
      return $response;
    }

    /**
     * @Route("/tags/delete/{id}")
     * @param Tag $repository
     * @return Response
     */
  
    public function deleteList(Tag $repository, $id): Response
    {
      $tag = $this->repository->find($id);
      $em = $this->getDoctrine()->getManager();
      $em->remove($tag);
      $em->flush();
      return new Response('done');
    }
}  