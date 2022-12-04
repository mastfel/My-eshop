<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default_home", methods={"GET"})
     */
    public function home(EntityManagerInterface $entityManager): Response
    {


        return $this->render('default/home.html.twig', [
            'produits' => $entityManager->getRepository(Produit::class)->findBy(['deletedAt' => null])
        ]);
    }
}

