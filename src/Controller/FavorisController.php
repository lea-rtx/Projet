<?php

namespace App\Controller;

use App\Entity\Enfant;
use App\Entity\Femme;
use App\Entity\Homme;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    #[Route('/private-favoris-enfant/{id}', name: 'app_favoris_enfant')]
    public function aimerenfant(Enfant $enfant, EntityManagerInterface $em): Response
    {
        if ($this->getUser()->getAimer()->contains($enfant)) {
            $this->getUser()->removeAimer($enfant);
        } else {
            $this->getUser()->addAimer($enfant);
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_lunettesenfant');
    }

    #[Route('/private-favoris-homme/{id}', name: 'app_favoris_homme')]
    public function aimerhomme(Homme $homme, EntityManagerInterface $em): Response
    {
        if ($this->getUser()->getAimerHomme()->contains($homme)) {
            $this->getUser()->removeAimerHomme($homme);
        } else {
            $this->getUser()->addAimerHomme($homme);
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_lunetteshomme');
    }

    #[Route('/private-favoris-femme/{id}', name: 'app_favoris_femme')]
    public function aimerfemme(Femme $femme, EntityManagerInterface $em): Response
    {
        if ($this->getUser()->getAimerFemme()->contains($femme)) {
            $this->getUser()->removeAimerFemme($femme);
        } else {
            $this->getUser()->addAimerFemme($femme);
        }
        $em->persist($this->getUser());
        $em->flush();
        return $this->redirectToRoute('app_lunettesfemme');
    }
}