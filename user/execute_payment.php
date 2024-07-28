<?php
require '../vendor/autoload.php';

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;

$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential(
          'Aak3zB3-x8fyGMq4NRSZ4X3NvdPH1uS4gggiuIf0mZ13B7stKASAnTQXFvv0YhVi9l_us5wjEJlGl93Q',
        'EDjMleH-thkjzCpD_s8Y5h20lqbNDRdO7Y5C1MK5ummXYIUFrVh_HkQf5RDg3umVdPJ4M2I6qGG1__E1'
    )
);

if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
    $paymentId = $_GET['paymentId'];
    $payment = Payment::get($paymentId, $apiContext);
    $execution = new PaymentExecution();
    $execution->setPayerId($_GET['PayerID']);

    try {
        $result = $payment->execute($execution, $apiContext);
        echo "Payment successful";
    } catch (PayPal\Exception\PayPalConnectionException $ex) {
        echo $ex->getData();
    }
}
?>
