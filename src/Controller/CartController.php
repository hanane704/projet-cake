<?php

namespace App\Controller;
use App\Service\CartService;
use App\Entity\Cake;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(CartService $cartService): Response
    {
        $cart =$cartService->get();
        return $this->render ('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart'=> $cart
        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function add(CartService $cartService, Cake $cake): Response
    {  
        $cartService->add($cake);
       return $this->redirectToRoute('cart_index');
    
    }
     /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */
    public function remove(CartService $cartService, Cake $cake): Response
    {
        $cartService->remove($cake);
       return $this->redirectToRoute('cart_index');
    
    }
     /**
     * @Route("/cart/clear", name="cart_clear")
     */
    public function clear(CartService $cartService): Response
    {
        $cartService->clear();
       return $this->redirectToRoute('cart_index');
    
    }
}
