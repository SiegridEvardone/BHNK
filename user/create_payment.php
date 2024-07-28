<?php
require '../vendor/autoload.php';

use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Payment;

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
        'Aak3zB3-x8fyGMq4NRSZ4X3NvdPH1uS4gggiuIf0mZ13B7stKASAnTQXFvv0YhVi9l_us5wjEJlGl93Q',
        'EDjMleH-thkjzCpD_s8Y5h20lqbNDRdO7Y5C1MK5ummXYIUFrVh_HkQf5RDg3umVdPJ4M2I6qGG1__E1'
    )
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amountValue = $_POST['amount'];

    $payer = new Payer();
    $payer->setPaymentMethod("paypal");

    $amount = new Amount();
    $amount->setCurrency("PHP") // Set currency to PHP
           ->setTotal($amountValue);    // Use the posted amount

    $transaction = new Transaction();
    $transaction->setAmount($amount)
                ->setDescription("Payment description");

    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl("localhost:8080\BHNK\user\execute_payment.php")
                 ->setCancelUrl("localhost:8080\BHNK\user\error.php");

    $payment = new Payment();
    $payment->setIntent("sale")
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

    try {
        $payment->create($apiContext);
        echo $payment->getApprovalLink();
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
        echo $ex->getData();
    }
}
?>
