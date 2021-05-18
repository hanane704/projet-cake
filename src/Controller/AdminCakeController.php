<?php

namespace App\Controller;
use App\Entity\Cake;
use App\Form\CakeType;
use App\Repository\CakeRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/cake")
 */
class AdminCakeController extends AbstractController
{
    /**
     * @Route("/", name="admin_cake_index", methods={"GET"})
     */
    public function index(CakeRepository $cakeRepository): Response
    {
        return $this->render('admin_cake/index.html.twig', [
            'cakes' => $cakeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_cake_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $cake = new Cake();
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
              /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $imageFilename = $fileUploader->upload($imageFile);
            $cake->setImageFilename($imageFilename);
        }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cake);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cake_index');
        }

        return $this->render('admin_cake/new.html.twig', [
            'cake' => $cake,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cake_show", methods={"GET"})
     */
    public function show(Cake $cake): Response
    {
        return $this->render('admin_cake/show.html.twig', [
            'cake' => $cake,
        ]);
    }

    /**
     * @Route("/edit", name="admin_cake_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cake $cake, FileUploader $fileUploader ): Response
    {
        $form = $this->createForm(CakeType::class, $cake);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
                 /** @var UploadedFile $imageFile */
        $imageFile = $form->get('image')->getData();
        if ($imageFile) {
            $imageFileName = $fileUploader->upload($imageFile);
            $cake->setImageFilename($imageFilename);
        }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_cake_index');
        }

        return $this->render('admin_cake/edit.html.twig', [
            'cake' => $cake,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cake_delete", methods={"POST"})
     */
    public function delete(Request $request, Cake $cake): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cake->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cake);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_cake_index');
    }
}
