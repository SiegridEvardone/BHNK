<?php
// Include your database connection file
include('../include/pdoconnect.php');

// Check if PDO object is successfully created
if (!$pdo) {
    die("PDO connection failed.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Prepare SQL statement to update room data
        $query = "UPDATE tblrooms SET room_number = :roomNumber, description = :description, rent_price = :rentPrice";

        // Check if an image file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            // Handle image upload
            $image = $_FILES['image'];
            $imagePath = 'uploads/' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);

            // Append image column to the SQL query
            $query .= ", image = :image";
        }

        $query .= " WHERE id = :roomId";

        // Prepare and execute the SQL statement
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':roomNumber', $_POST['roomNumber']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':rentPrice', $_POST['rentPrice']);
        if (isset($imagePath)) {
            $stmt->bindParam(':image', $imagePath);
        }
        $stmt->bindParam(':roomId', $_POST['roomId']);
        $stmt->execute();

        // Redirect to rooms page after successful update
        header('Location: rooms.php');
        exit();
    } catch (PDOException $e) {
        // Handle PDO exceptions
        die("PDO error: " . $e->getMessage());
    } catch (Exception $e) {
        // Handle other exceptions
        die("Error: " . $e->getMessage());
    }
} else {
    // If the form is not submitted, redirect to an error page or display an error message
    header('Location: error.php');
    exit();
}
?>
