<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produits')]
class ProduitsController extends AbstractController
{
    #[Route('/', name: 'app_produits_index', methods: ['GET'])]
    public function index(ProduitsRepository $produitsRepository): Response
    {
        return $this->render('produits/index.html.twig', [
            'produits' => $produitsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_produits_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produits();
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les données téléchargées via le bouton "fichier-image"
            $image = $form->get('fichier-image')->getData();

            // Si un fichier a été envoyé (l'usage du bouton est facultatif)
            if ($image) {
                // On fabrique un nom de fichier unique avec l'id du chateau
                // Pour que l'id soit défini, il faut enregistrer l'entité dans la BDD (qui génère la clé)
                $produit->setPhoto("tmp"); // il faut un nom de fichier temporaire (not null)
                $entityManager->persist($produit);
                $entityManager->flush();
                // Ensuite on fixe le nom du fichier en utilisant l'extension (devinée d'après le type mime)
                $filename = 'image-'.$produit->getId().'.'.$image->guessExtension();
                // Enregistre le nom du fichier dans l'entité
                $produit->setPhoto($filename);
                // Renomme le fichier téléchargé et le déplace dans le dossier "uploads" (à mettre dans "public")
                $image->move('uploads', $filename);
            }
            // Enregistrement final (si aucun fichier n'est envoyé ou pour mettre à jour le nom du ficher)
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produits/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_show', methods: ['GET'])]
    public function show(Produits $produit): Response
    {
        return $this->render('produits/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produits_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitsType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('fichier-image')->getData();

            if ($image) {
                if (file_exists('uploads/' . $produit->getPhoto()))
                    unlink('uploads/' . $produit->getPhoto());

                $filename = 'image-'.$produit->getId().'.'.$image->guessExtension();
                $produit->setPhoto($filename);
                $image->move('uploads', $filename);
            }
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('produits/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_produits_delete', methods: ['POST'])]
    public function delete(Request $request, Produits $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            // Teste si un fichier a été téléchargé
            if (file_exists('uploads/' . $produit->getPhoto()))
                // Si oui le supprime
                unlink('uploads/' . $produit->getPhoto());
            // Supprime l'entité
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_produits_index', [], Response::HTTP_SEE_OTHER);
    }
}
