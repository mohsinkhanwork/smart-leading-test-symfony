<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/type')]
class TypeController extends AbstractController
{
    #[Route('/', name: 'type_index', methods: ['GET'])]
    public function index(TypeRepository $typeRepository): JsonResponse
    {
        $types = $typeRepository->findAll();
        return $this->json($types);
    }

    #[Route('/new', name: 'type_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type = new Type();
        $type->setName($data['name']);

        $entityManager->persist($type);
        $entityManager->flush();

        return $this->json($type, 201);
    }

    #[Route('/{id}/edit', name: 'type_edit', methods: ['PUT'])]
    public function edit(Request $request, Type $type, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type->setName($data['name']);
        $entityManager->flush();

        return $this->json($type);
    }

    #[Route('/{id}', name: 'type_delete', methods: ['DELETE'])]
    public function delete(Type $type, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($type);
        $entityManager->flush();

        return $this->json(['message' => 'Type deleted successfully']);
    }
}
