<?php

namespace App\Controller;

use App\Entity\Enfant;
use App\Entity\Homme;
use App\Entity\Femme;
use App\Entity\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    #[Route('/private-panier-enfant/{id}', name: 'app_panier_enfant')]
    public function ajouterEnfant(Enfant $enfant, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($enfant->toPanier());
        $entityManager->flush();

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-panier-homme/{id}', name: 'app_panier_homme')]
    public function ajouterHomme(Homme $homme, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($homme->toPanier());
        $entityManager->flush();

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/private-panier-femme/{id}', name: 'app_panier_femme')]
    public function ajouterFemme(Femme $femme, EntityManagerInterface $entityManager): Response
    {
        $entityManager->persist($femme->toPanier());
        $entityManager->flush();

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/{id}/supprimer', name: 'app_panier_supprimer')]
    public function supprimerProduit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produitId = $request->get('id');
        $panierRepository = $entityManager->getRepository(Panier::class);
        $panier = $panierRepository->find($produitId);

        if (!$panier) {
            throw $this->createNotFoundException('Le produit avec l\'ID ' . $produitId . ' n\'existe pas.');
        }

        $entityManager->remove($panier);
        $entityManager->flush();


        return $this->redirectToRoute('app_panier');
    }
}
