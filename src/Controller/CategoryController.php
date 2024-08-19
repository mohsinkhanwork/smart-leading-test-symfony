<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Log;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findAll();
        return $this->json($categories, 200, [], ['groups' => 'category:read']);
    }

    #[Route('/new', name: 'category_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category = new Category();
        $category->setName($data['name']);

        $entityManager->persist($category);
        $entityManager->flush();

        $this->logAction('create', 'category', $category->getId(), $entityManager);

        return $this->json($category, 201);
    }

    #[Route('/{id}/edit', name: 'category_edit', methods: ['PUT'])]
    public function edit(Request $request, Category $category, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $category->setName($data['name']);
        $entityManager->flush();

        $this->logAction('update', 'category', $category->getId(), $entityManager);

        return $this->json($category);
    }

    #[Route('/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($category);
        $entityManager->flush();

        $this->logAction('delete', 'category', $category->getId(), $entityManager);

        return $this->json(['message' => 'Category deleted successfully']);
    }

    private function logAction(string $action, string $entity, int $entityId, EntityManagerInterface $entityManager): void
    {
        $log = new Log();
        $log->setAction($action);
        $log->setEntity($entity);
        $log->setEntityId($entityId);
        $log->setTimestamp(new \DateTime());

        $entityManager->persist($log);
        $entityManager->flush();
    }
}
