<?php

namespace App\Controller;

use App\Entity\Receipe;
use App\Form\ReceipeType;
use App\Repository\ReceipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/receipe")
 */
class AdminReceipeController extends AbstractController
{
    /**
     * @Route("/", name="admin_receipe_index", methods={"GET"})
     */
    public function index(ReceipeRepository $receipeRepository): Response
    {
        return $this->render('admin_receipe/index.html.twig', [
            'receipes' => $receipeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_receipe_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $receipe = new Receipe();
        $form = $this->createForm(ReceipeType::class, $receipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($receipe);
            $entityManager->flush();

            return $this->redirectToRoute('admin_receipe_index');
        }

        return $this->render('admin_receipe/new.html.twig', [
            'receipe' => $receipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_receipe_show", methods={"GET"})
     */
    public function show(Receipe $receipe): Response
    {
        return $this->render('admin_receipe/show.html.twig', [
            'receipe' => $receipe,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_receipe_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Receipe $receipe): Response
    {
        $form = $this->createForm(ReceipeType::class, $receipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_receipe_index');
        }

        return $this->render('admin_receipe/edit.html.twig', [
            'receipe' => $receipe,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_receipe_delete", methods={"POST"})
     */
    public function delete(Request $request, Receipe $receipe): Response
    {
        if ($this->isCsrfTokenValid('delete'.$receipe->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($receipe);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_receipe_index');
    }
}
