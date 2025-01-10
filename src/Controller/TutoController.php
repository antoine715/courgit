<?php

namespace App\Controller;

use App\Entity\Tuto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    #[Route('/tuto', name: 'app_tuto')]
    public function index(): Response
    {
        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
        ]);
    }

    #[Route('/add-t', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('Unity');
        $product->setSlug('tuto-unity');
        $product->setSubtitle('Lorem ipsum dolor sit amet.');
        $product->setDescription('Lorem ipsum dolor sit amet.');
        $product->setImage('Unity');
        $product->setVideo('Unity');
        $product->setLink('google.fr');
        
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
