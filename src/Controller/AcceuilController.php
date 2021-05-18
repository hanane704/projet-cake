<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/acceuil", name="acceuil_index")
     */
    public function index(CakeRepository $cakeRepository): Response
    {
        return $this->render('acceuil/index.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);

    }
}
