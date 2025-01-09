<?php

namespace App\Controller;

use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $productRepository, int $id): Response
    {
        // $product = $entityManager->getRepository(tuto::class)->find($id);
        $product = $productRepository->findOneById($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id' .$id
            );
        }


        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $product->getName()
        ]);
    }

    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('Unity');
        $product->setSlug('tuto-unity');
        $product->setSubtitle('Lorem ipsum dolor sit amet.');
        $product->setDescription('Lorem ipsum dolor sit amet.');
        $product->setImage('eclipse.jpg');
        $product->setVideo('okVyL-Q3Wno');
        $product->setLink('https://www.youtube.com/watch?v=P4ht5fNI5AQ&t=195s');

        // pour sauvegarder
        $entityManager->persist($product);

        // executer requette sql
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
