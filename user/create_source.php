<?php
// Include your database configuration file
include '../include/connection.php';

// Get the PayMongo API key
$apiKey = 'sk_test_pbJTNvbSPCjEV8VVyWdHgdVs';

// Get the form data
$amount = $_POST['amount'] * 100; // Convert to centavos
$description = $_POST['description'];

// Initialize cURL
$curl = curl_init();

$data = [
    'data' => [
        'attributes' => [
            'amount' => $amount,
            'type' => 'gcash',
            'currency' => 'PHP',
            'redirect' => [
                'success' => 'https://5177-180-190-216-44.ngrok-free.app/BHNK/user/success.php',
                'failed' => 'https://5177-180-190-216-44.ngrok-free.app/BHNK/user/failed.php'
            ],
            'description' => $description
        ]
    ]
];

curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.paymongo.com/v1/sources",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic c2tfdGVzdF9wYkpUTnZiU1BDakVWOFZWeVdkSGdkVnM6 ",
        "Content-Type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $response = json_decode($response, true);

    if (isset($response['data']['id'])) {
        $sourceId = $response['data']['id'];
        $checkoutUrl = $response['data']['attributes']['redirect']['checkout_url'];

        // Record the payment details in the database
        $stmt = $conn->prepare("INSERT INTO tblpayments (source_id, amount, description, status) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("siss", $sourceId, $amount, $description, $status);

        $status = 'pending'; // Initial status

        if ($stmt->execute()) {
            // Redirect the user to the GCash payment URL
            header("Location: " . $checkoutUrl);
            exit();
        } else {
            echo "Database error: " . $stmt->error;
        }
    } else {
        echo "Error: " . json_encode($response);
    }
}
?>
