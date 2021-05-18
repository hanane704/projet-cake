<?php 

namespace App\Service;
use App\Entity\Cake;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private $sessionInterface;

    public function __construct(SessionInterface $sessionInterface)
    {
        $this->sessionInterface = $sessionInterface;
    }
    public function get()
    {
        return $this->sessionInterface->get('cart',[
        'elements'=> [],
        'total'=> 0.0

        
        ]);
    }
    // Ajouter un gateau dans un panier
    public function add(Cake $cake)
    {
        $cart = $this->get();
        $cakeId = $cake->getId();
        if (!isset($cart['elements'][$cakeId] ))
        {
            $cart['elements'][$cakeId] =[
                'cake' =>$cake,
                'quantiy'=> 0
            ];
        }
        $cart['total'] = $cart['total'] + $cake->getPrice();
        $cart['elements'][$cakeId]['quantiy'] = $cart['elements'][$cakeId]['quantiy'] + 1;

        $this->sessionInterface->set('cart',$cart);
    }
    // supprimer un gateau dans un panier 
    public function remove(Cake $cake)
    {
        $cart = $this->get();
        $cakeId = $cake->getId();
        if (!isset($cart['elements'][$cakeId] )){
            return;
        }
        // si j'ai mon gateau
        $cart['total'] = $cart['total'] - $cake->getPrice();
        $cart['elements'][$cakeId]['quantiy'] = $cart['elements'][$cakeId]['quantiy'] - 1;
        // si j'ai une quantite Zero 
        if ($cart['elements'][$cakeId]<= 0 ){
            //   j'enlever completement le gateau
            unset($cart['elements'][$cakeId]);
        }
        $this->sessionInterface->set('cart',$cart);
    }
    // On vider le panier
    public function clear()
    {

        $this->sessionInterface->remove('cart');
    }
}