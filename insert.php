<?php
include "db.php";

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Make sure PHPMailer folder structure is correct:
// PHPMailer-master/src/PHPMailer.php
// PHPMailer-master/src/SMTP.php
// PHPMailer-master/src/Exception.php
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Get form data safely
$name    = isset($_POST['Name']) ? mysqli_real_escape_string($conn, $_POST['Name']) : '';
$email   = isset($_POST['Email']) ? mysqli_real_escape_string($conn, $_POST['Email']) : '';
$contact = isset($_POST['Contact']) ? mysqli_real_escape_string($conn, $_POST['Contact']) : '';
$time    = isset($_POST['Time']) ? mysqli_real_escape_string($conn, $_POST['Time']) : '';
$date    = isset($_POST['Date']) ? mysqli_real_escape_string($conn, $_POST['Date']) : '';
$price   = isset($_POST['Price']) ? mysqli_real_escape_string($conn, $_POST['Price']) : '';

// Insert into database
$sql = "INSERT INTO customer (Name, Email, Contact, Time, Date, Price)
        VALUES ('$name', '$email', '$contact', '$time', '$date', '$price')";

if(mysqli_query($conn, $sql)) {

    $mail = new PHPMailer(true);

    try {
        // Enable verbose debug output (for testing)
        $mail->SMTPDebug = 0; // Change to 2 to see debug info

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'tamannaibrahimi77@gmail.com'; // Your Gmail
        $mail->Password   = 'cywr xtwm lfje qrvj';         // 16-digit App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender & recipient
        $mail->setFrom('tamannaibrahimi77@gmail.com', 'GlamGlow Salon');
        $mail->addAddress($email, $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "Appointment Confirmation - GlamGlow Beauty Salon";
        $mail->Body    = "
            <h3>Dear $name,</h3>
            <p>Thank you for booking your appointment with <b>GlamGlow Beauty Salon</b>.</p>
            <p><b>Appointment Details:</b></p>
            <ul>
                <li><b>Date:</b> $date</li>
                <li><b>Time:</b> $time</li>
                <li><b>Price:</b> Rs. $price</li>
            </ul>
            <p>We look forward to serving you!</p>
            <br>
            <p>Regards,<br>GlamGlow Beauty Salon</p>
        ";

        $mail->send();

        // Redirect on success
        header("Location: booking.html?success=1");
        exit();

    } catch (Exception $e) {
        // Display email error
        echo "Email could not be sent. Error: {$mail->ErrorInfo}";
    }

} else {
    // Display database error
    echo "Database Error: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
