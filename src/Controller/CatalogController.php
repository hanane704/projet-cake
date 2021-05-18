<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Form\Cake1Type;
use App\Repository\CakeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/catalog")
 */
class CatalogController extends AbstractController
{
    /**
     * @Route("/", name="catalog_index", methods={"GET"})
     */
    public function index(CakeRepository $cakeRepository): Response
    {
        return $this->render('catalog/index.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}", name="catalog_show", methods={"GET"})
     */
    public function show(Cake $cake): Response
    {
        return $this->render('catalog/show.html.twig', [
            'cake' => $cake,
        ]);
    }

    
}
