<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EnfantRepository;
use App\Repository\FemmeRepository;
use App\Repository\HommeRepository;
use App\Repository\FavorisRepository;
use App\Repository\PanierRepository;
use App\Repository\UserRepository;
use App\Entity\Enfant;
use App\Entity\Homme;
use App\Entity\Femme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ModifierProduitTypeEnfant;
use App\Form\ModifierProduitTypeFemmeType;
use App\Form\ModifierProduitTypeHommeType;

class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(EnfantRepository $enfantRepository, FemmeRepository $femmeRepository, HommeRepository $hommeRepository): Response
    {
         $femmes = $femmeRepository->findAll();
         $hommes = $hommeRepository->findAll();
         $enfants = $enfantRepository->findAll(); 

         return $this->render('base/index.html.twig',  [
            'enfants' => $enfants,
            'femmes' => $femmes,
            'hommes' => $hommes,
        ]);
    }

    #[Route('/lunettesenfant', name: 'app_lunettesenfant')]
    public function enfant(EnfantRepository $enfantRepository, FavorisRepository $favorisRepository): Response
    {
        $enfants = $enfantRepository->findAll(); 
        $favoris = $favorisRepository->findAll();

        return $this->render('base/lunettesenfant.html.twig', [
            'enfants' => $enfants,
            'favoris' => $favoris,
        ]);
    }

    #[Route('/lunettesfemme', name: 'app_lunettesfemme')]
    public function femme(FemmeRepository $femmeRepository, FavorisRepository $favorisRepository): Response
    {
        $femmes = $femmeRepository->findAll();
        $favoris = $favorisRepository->findAll();

        return $this->render('base/lunettesfemme.html.twig', [
            'femmes' => $femmes,
            'favoris' => $favoris,
        ]);
    }

    #[Route('/lunetteshomme', name: 'app_lunetteshomme')]
    public function homme(HommeRepository $hommeRepository, FavorisRepository $favorisRepository): Response
    {
        $hommes = $hommeRepository->findAll();
        $favoris = $favorisRepository->findAll();

        return $this->render('base/lunetteshomme.html.twig', [
            'hommes' => $hommes,
            'favoris' => $favoris,
        ]);
    }

    #[Route('/admin-liste_produits', name: 'app_liste_produits', methods: ['GET', 'POST'])]
    public function listeProduits(Request $request, EnfantRepository $enfantRepository, FemmeRepository $femmeRepository, HommeRepository $hommeRepository): Response
    {
        $lunettesEnfants = $enfantRepository->findAll();
        $lunettesFemmes = $femmeRepository->findAll();
        $lunettesHommes = $hommeRepository->findAll();

        return $this->render('base/liste_produits.html.twig', [
            'lunettes_e' => $lunettesEnfants,
            'lunettes_f' => $lunettesFemmes,
            'lunettes_h' => $lunettesHommes,
        ]);
    }

   #[Route('/modifier-produit-enfant/{id}', name: 'app_modifier_produit_enfant')]
   public function modifierProduitEnfant(Request $request, Enfant $enfant, EntityManagerInterface $em): Response
   {
      $form = $this->createForm(ModifierProduitTypeEnfant::class, $enfant);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em->persist($enfant);
         $em->flush();
         $this->addFlash('notice', 'Produit modifié');
         return $this->redirectToRoute('app_liste_produits');
      }

      return $this->render('base/modifier_produit.html.twig', [
         'form' => $form->createView()
      ]);
   }

   #[Route('/modifier-produit-femme/{id}', name: 'app_modifier_produit_femme')]
   public function modifierProduitFemme(Request $request, Femme $femme, EntityManagerInterface $em): Response
   {
      $form = $this->createForm(ModifierProduitTypeFemmeType::class, $femme);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em->persist($femme);
         $em->flush();
         $this->addFlash('notice', 'Produit modifié');
         return $this->redirectToRoute('app_liste_produits');
      }

      return $this->render('base/modifier_produit.html.twig', [
         'form' => $form->createView()
      ]);
   }

   #[Route('/modifier-produit-homme/{id}', name: 'app_modifier_produit_homme')]
   public function modifierProduitHomme(Request $request, Homme $homme, EntityManagerInterface $em): Response
   {
      $form = $this->createForm(ModifierProduitTypeHommeType::class, $homme);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
         $em->persist($homme);
         $em->flush();
         $this->addFlash('notice', 'Produit modifié');
         return $this->redirectToRoute('app_liste_produits');
      }

      return $this->render('base/modifier_produit.html.twig', [
         'form' => $form->createView()
      ]);
   }

   #[Route('/supprimer-produit-enfant/{id}', name: 'app_supprimer_produit_enfant')]
   public function supprimerProduitEnfant(Enfant $enfant, EntityManagerInterface $em): Response
   {
      $em->remove($enfant);
      $em->flush();
      $this->addFlash('notice', 'Produit enfant supprimé');
      return $this->redirectToRoute('app_liste_produits');
   }

   #[Route('/supprimer-produit-femme/{id}', name: 'app_supprimer_produit_femme')]
   public function supprimerProduitFemme(Femme $femme, EntityManagerInterface $em): Response
   {
      $em->remove($femme);
      $em->flush();
      $this->addFlash('notice', 'Produit femme supprimé');
      return $this->redirectToRoute('app_liste_produits');
   }

   #[Route('/supprimer-produit-homme/{id}', name: 'app_supprimer_produit_homme')]
   public function supprimerProduitHomme(Homme $homme, EntityManagerInterface $em): Response
   {
      $em->remove($homme);
      $em->flush();
      $this->addFlash('notice', 'Produit homme supprimé');
      return $this->redirectToRoute('app_liste_produits');
   }


#[Route('/ajouter-produit-enfant', name: 'app_ajouter_produit_enfant')]
public function ajouterProduitEnfant(Request $request, EntityManagerInterface $em): Response
{
    $enfant = new Enfant();
    $form = $this->createForm(ProduitType::class, $enfant);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($enfant);
        $em->flush();
        $this->addFlash('notice', 'Produit enfant ajouté');
        return $this->redirectToRoute('app_liste_produits');
    }

    return $this->render('produit/ajouter.html.twig', [
        'form' => $form->createView(),
    ]);
}

   #[Route('/ajouter-produit-femme', name: 'app_ajouter_produit_femme')]
   public function ajouterProduitFemme(Request $request, EntityManagerInterface $em): Response
   {
      $femme = new Femme();
      $form = $this->createForm(ProduitType::class, $femme);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $em->persist($femme);
         $em->flush();
         $this->addFlash('notice', 'Produit femme ajouté');
         return $this->redirectToRoute('app_liste_produits');
      }

      return $this->render('produit/ajouter.html.twig', [
         'form' => $form->createView(),
      ]);
   }

   #[Route('/ajouter-produit-homme', name: 'app_ajouter_produit_homme')]
   public function ajouterProduitHomme(Request $request, EntityManagerInterface $em): Response
   {
      $homme = new Homme();
      $form = $this->createForm(ProduitType::class, $homme);

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $em->persist($homme);
         $em->flush();
         $this->addFlash('notice', 'Produit homme ajouté');
         return $this->redirectToRoute('app_liste_produits');
      }

      return $this->render('produit/ajouter.html.twig', [
         'form' => $form->createView(),
      ]);
   }

   #[Route('/recherche-produit', name: 'app_recherche')]
   public function rechercheProduit(Request $request, EntityManagerInterface $entityManager): Response
   {
      $searchTerm = $request->query->get('q');

      $enfants = $entityManager->getRepository(Enfant::class)->findBySearchTerm($searchTerm);

      $hommes = $entityManager->getRepository(Homme::class)->findBySearchTerm($searchTerm);

      $femmes = $entityManager->getRepository(Femme::class)->findBySearchTerm($searchTerm);

      return $this->render('votre_template.html.twig', [
         'enfants' => $enfants,
         'hommes' => $hommes,
         'femmes' => $femmes,
      ]);
   }

    #[Route('/private-panier', name: 'app_panier')]
    public function panier(PanierRepository $panierRepository): Response
    {
        $panier = $panierRepository->findAll();

        return $this->render('base/panier.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/mentionslegales', name: 'app_mentionslegales')]
    public function mentionsLegales(): Response
    {
        return $this->render('base/mentionslegales.html.twig');
    }
}
