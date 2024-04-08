<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BaseController extends AbstractController
{
 #[Route('/', name: 'app_accueil')]
 public function index(): Response
 {
 return $this->render('base/index.html.twig', [
 
 ]);
 }
 #[Route('/lunettesenfant', name: 'app_lunettesenfant')]
 public function encemoment(): Response
 {
 return $this->render('base/lunettesenfant.html.twig', [
 
 ]);
 }
 #[Route('/lunettesfemme', name: 'app_lunettesfemme')]
 public function nosmenus(): Response
 {
 return $this->render('base/lunettesfemme.html.twig', [
 
 ]);
 }
 #[Route('/lunetteshomme', name: 'app_lunetteshomme')]
 public function nosburgers(): Response
 {
 return $this->render('base/lunetteshomme.html.twig', [
 
 ]);
 }
 #[Route('/100%remboursé', name: 'app_100%remboursé')]
 public function remboursé(): Response
 {
 return $this->render('base/100%remboursé.html.twig', [
 
 ]);
 }
 #[Route('/0%remboursé', name: 'app_0%remboursé')]
 public function nonremboursé(): Response
 {
 return $this->render('base/0%remboursé.html.twig', [
 
 ]);
 }
 #[Route('/panier', name: 'app_panier')]
 public function panier(): Response
 {
 return $this->render('base/panier.html.twig', [
 
 ]);
 }
}
