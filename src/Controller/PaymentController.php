<?php

namespace App\Controller;
use App\Entity\PaymentRequest;
use App\Service\CartService;
use App\Service\Order;
use App\Service\PaymentService;
use DateTime;
use App\Repository\PaymentRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment_index")
     */
    public function index(PaymentService $paymentService): Response
    {
        // cree une session chez stripe
        $sessionId = $paymentService->create();
// on cree un objet avec l'entity paymentRequest
        $paymentRequest = new PaymentRequest();
        $paymentRequest->setCreatedAt(new DateTime());
        $paymentRequest->setStripeSessionId($sessionId);

// on engistre dans la base de donnes  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentRequest);
        $entityManager->flush();



        return $this->render('payment/index.html.twig',[
            'sessionId' => $sessionId
        ]);
    }
    /**
     * @Route("/payment/success{stripeSessionId}", name="payment_success")
     */
    public function success(string $stripeSessionId,PaymentRequestRepository $paymentRequestRepository,CartService $cartService,CakeRepository $CakeRepository): Response
    {
        $paymentRequest = $paymentRequestRepository->findOneBy([
            'stripeSessionId' => $stripeSessionId
        ]);
        if (!$paymentRequest)
        {

   return $this->redirectToRoute('cart_index');
        }

        $paymentRequest->setValidated(true);
        $paymentRequest->setPaidAt(new DateTime());

        $entityManager = $this->getDoctrine()->getManager();

        $order = new Order();
        $order->setCreatedAt(new DateTime());
        $order->setPaymentRequest($paymentRequest);
        $order->setUser($this->getUser());
        $order->setReference(strval(rand(100000, 99999999)));
        $entityManager->persist($order);

        $cart = $cartService->get();
        foreach ($cart['elements'] as $cakeId =>$element){

            $cake = $cakeRepository->find($cakeId);
            $orderedQuantity = new OrderedQuantity();
            $orderedQuantity->setQuantity($element['quantiy']);
            $orderedQuantity->setcake($cake);
            $orderedQuantity->setFromOrder($order);
            $entityManager->persist($orderedQuantity);
        }

        $entityManager->flush();

        $cartService->clear();

        return $this->render('payment/success.html.twig');
    }
     /**
     * @Route("/payment/failure/{stripeSessionId}", name="payment_failure")
     */
    public function failure(string $stripeSessionId,PaymentRequestRepository $paymentRequestRepository): Response
    {
        $paymentRequest = $paymentRequestRepository->findOneBy([
            'stripeSessionId' =>$stripeSessionId
        ]);
        if (!$paymentRequest)
        {

   return $this->redirectToRoute('cart_index');
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($paymentRequest);
        $entityManager->flush();

        return $this->render('payment/failure.html.twig');
    }
}
