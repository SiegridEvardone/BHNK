<?php
include('../include/connection.php');

// Get the webhook payload
$input = file_get_contents('php://input');
$event_json = json_decode($input, true);

if ($event_json['data']['attributes']['status'] == 'succeeded') {
    $payment_id = $event_json['data']['id'];
    $amount = $event_json['data']['attributes']['amount'];
    $currency = $event_json['data']['attributes']['currency'];
    
    // Update your database based on the payment status
    $sql = "INSERT INTO tblpayments (id, amount, currency) VALUES ('$payment_id', '$amount', '$currency')";
    if ($db->query($sql) === TRUE) {
        echo "Payment record inserted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $db->error;
    }
}

$db->close();
?>
