<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Log;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();
        return $this->json($products, 200, [], ['groups' => 'product:read']);
    }

    #[Route('/{id}', name: 'product_show', methods: ['GET'])]
    public function show(Product $product): JsonResponse
    {
        return $this->json($product);
    }

    #[Route('/new', name: 'product_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, TypeRepository $typeRepository, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product = new Product();
        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);
        
        $category = $categoryRepository->find($data['category_id']);
        $type = $typeRepository->find($data['type_id']);
        
        if ($category && $type) {
            $product->setCategory($category);
            $product->setType($type);

            $entityManager->persist($product);
            $entityManager->flush();

            $this->logAction('create', 'product', $product->getId(), $entityManager);

            $json = $serializer->serialize($product, 'json', ['groups' => 'product:read']);
        }

        return new JsonResponse($json, 201, [], true);
    }

    #[Route('/{id}/edit', name: 'product_edit', methods: ['PUT'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, TypeRepository $typeRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $product->setName($data['name']);
        $product->setPrice($data['price']);
        $product->setDescription($data['description']);

        $category = $categoryRepository->find($data['category_id']);
        $type = $typeRepository->find($data['type_id']);

        if ($category && $type) {
            $product->setCategory($category);
            $product->setType($type);

            $entityManager->flush();

            $this->logAction('update', 'product', $product->getId(), $entityManager);

            return $this->json($product);
        }

        return $this->json(['error' => 'Invalid category or type'], 400);
    }

    #[Route('/{id}', name: 'product_delete', methods: ['DELETE'])]
    public function delete(Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($product);
        $entityManager->flush();

        $this->logAction('delete', 'product', $product->getId(), $entityManager);

        return $this->json(['message' => 'Product deleted successfully']);
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
