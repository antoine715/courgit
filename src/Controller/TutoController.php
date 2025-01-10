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
    // public function index(EntityManagerInterface $entityManager, int $id): Response
    {
        // Récupérer l'entité Tuto avec l'ID passé en paramètre
        // $product = $entityManager->getRepository(Tuto::class)->find($id);
        $product = $productRepository->findOneById($id);

        if (!$product) {
            // Lever une exception si aucun produit n'est trouvé
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        // Retourner la réponse avec la vue Twig, et passer le produit
        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $product->getName(),  // Utiliser $product et non $product6
        ]);
    }

    #[Route('/add-t', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        // Créer un nouvel objet Tuto
        $product = new Tuto();
        $product->setName('Unity');
        $product->setSlug('tuto-unity');
        $product->setSubtitle('Lorem ipsum dolor sit amet.');
        $product->setDescription('Lorem ipsum dolor sit amet.');
        $product->setImage('Unity');
        $product->setVideo('Unity');
        $product->setLink('google.fr');

        // Persister l'objet dans la base de données
        $entityManager->persist($product);
        $entityManager->flush();

        // Retourner une réponse indiquant que le produit a été sauvegardé
        return new Response('Saved new product with id ' . $product->getId());
    }
}
