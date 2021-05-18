<?php 

namespace App\Service;
use Stripe\StripeClient;

class PaymentService
{
    private $cartService;
    private $stripe;

    public function __construct(CartService $cartService)
    {
    $this->cartService = $cartService;
    $this->stripe = new StripeClient('sk_test_51IhFw2JrcklKXoIYnWmftrceKBNmZKTSBywsHoY7jQ50KFT8V9kyhz53oo0fpOfYt691eg1sCGkv5PKuMkTizhBO005NhG3N2A');
}
// cree une demande de  paiement 
public function create(): string
{
    $cart = $this->cartService->get();
    $items = [];
    // parcour mon panier
          foreach ($cart['elements'] as $cakeId => $element)
               {
        // cree une nouveau element 
        $items[] = [
            'amount'=> $element['cake']->getPrice()*100,
            'quantity' => $element['quantiy'],
            'currency' =>'eur',
            'name'=> $element['cake']->getName()
                                        ];
                        }
    
    $proctocol = $_SERVER['HTTPS'] ? 'https' : 'http';
    $host = $_SERVER['SERVER_NAME'];
    $successUrl = $proctocol . '://'.$host . '/payment/success/{CHECKOUT_SESSION_ID}';
    $failureUrl = $proctocol . '://'.$host . '/payment/failure/{CHECKOUT_SESSION_ID}';
    $session = $this->stripe->checkout->sessions->create([
        'success_url' =>$successUrl,
        'cancel_url'=>$failureUrl,
        'payment_method_types'=>['card'],
        'mode'=>'payment',
        'line_items' => $items
    ]);
    return $session->id;

}
}