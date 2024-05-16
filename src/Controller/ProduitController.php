<?php

namespace App\Controller;

use App\Entity\Homme;
use App\Entity\Femme;
use App\Entity\Enfant;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProduitController extends AbstractController
{
    #[Route('/ajouter-produit-enfant', name: 'app_ajouter_produit_enfant')]
    public function ajouterProduitEnfant(Request $request, EntityManagerInterface $entityManager): Response
    {
        $enfant = new Enfant();
        $form = $this->createForm(ProduitType::class, $enfant);
        return $this->handleFormSubmission($request, $entityManager, $enfant, $form);
    }

    #[Route('/ajouter-produit-homme', name: 'app_ajouter_produit_homme')]
    public function ajouterProduitHomme(Request $request, EntityManagerInterface $entityManager): Response
    {
        $homme = new Homme();
        $form = $this->createForm(ProduitType::class, $homme, [
            'data_class' => Homme::class,
        ]);        
        
        return $this->handleFormSubmission($request, $entityManager, $homme, $form);
    }

    #[Route('/ajouter-produit-femme', name: 'app_ajouter_produit_femme')]
    public function ajouterProduitFemme(Request $request, EntityManagerInterface $entityManager): Response
    {
        $femme = new Femme();
        $form = $this->createForm(ProduitType::class, $femme, [
            'data_class' => Femme::class,
        ]);
        
        return $this->handleFormSubmission($request, $entityManager, $femme, $form);
    }

    #[Route('/recherche-produit', name: 'app_recherche')]
    public function rechercheProduit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $searchTerm = $request->query->get('q');

        $enfants = $entityManager->getRepository(Enfant::class)->searchByTerm($searchTerm);
        $hommes = $entityManager->getRepository(Homme::class)->searchByTerm($searchTerm);
        $femmes = $entityManager->getRepository(Femme::class)->searchByTerm($searchTerm);

        $results = array_merge($enfants, $hommes, $femmes);

        return $this->render('base/resultats.html.twig', [
            'results' => $results,
        ]);

    }

    private function handleFormSubmission(Request $request, EntityManagerInterface $entityManager, $entity, $form): Response
    {
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleImageUpload($form, $entity);
            
            $entityManager->persist($entity);
            $entityManager->flush();
            
            $this->addFlash('success', 'Le produit a été ajouté avec succès.');
            return $this->redirectToRoute('app_liste_produits');
        }
        
        return $this->render('base/ajouter.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function handleImageUpload($form, $entity)
    {
        $imageFile = $form->get('image')->getData();

        if ($imageFile) {
            $imageDirectory = $this->getParameter('images_directory');
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension(); 
            $imageFile->move($imageDirectory, $imageName); 

            $entity->setImage($imageName);
        }
    }
}
