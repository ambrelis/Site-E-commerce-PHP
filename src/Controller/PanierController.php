<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produits;
use App\Entity\User;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/panier')]
class PanierController extends AbstractController
{
    #[Route('/', name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        $user = $this->getUser();
        $paniers = $panierRepository->findBy(['user' => $user]);
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }
    #[Route('/admin', name: 'app_panier_index_admin', methods: ['GET'])]
    public function indexadmin(PanierRepository $panierRepository): Response
    {
        $paniers = $panierRepository->findAll();
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/add-produit/{id}', name: 'app_panier_add_produit', methods: ['GET', 'POST'])]
    public function addProduit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        // Obtenez l'utilisateur connecté
        $user = $this->getUser();

        // Récupérez la quantité à partir de la requête
        $quantite = $request->request->get('quantity', 1);

        // Créez un nouveau panier associé à l'utilisateur et au produit avec la quantité spécifiée
        $panier = new Panier();
        $panier->setUser($user);
        $panier->setProduit($produit);
        $panier->setQuantite($quantite);

        // Persistez et flush le panier
        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->redirectToRoute('app_panier_index');
    }

}