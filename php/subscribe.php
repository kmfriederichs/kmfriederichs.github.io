<?php
require 'vendor/autoload.php'; // Require the Composer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!$_POST) {
    exit;
}

// Email address verification function
function validateEmail($email)
{
    $pattern = '/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i';
    return preg_match($pattern, $email);
}

if (!defined("PHP_EOL")) {
    define("PHP_EOL", "\r\n");
}

$email = htmlspecialchars($_POST['email']);

if (trim($email) == '') {
    echo '<div class="error_message">Please enter a valid email address.</div>';
    exit();
} else if (!validateEmail($email)) {
    echo '<div class="error_message">You have entered an invalid email address. Please try again.</div>';
    exit();
}

// Configuration options
$address = "katja.milena.friederichs@gmail.com"; // Enter the email address that you want to receive the emails
$e_subject = 'New email subscriber ' . $email . '.'; // Email subject

$mail = new PHPMailer(true);

try {
    // Gmail SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'affectiveshiftings@gmail.com'; // Replace with your Gmail username
    $mail->Password = 'your-gmail-password'; // Replace with your Gmail password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set email headers
    $mail->setFrom($email);
    $mail->addAddress($address);
    $mail->Subject = $e_subject;
    $mail->Body = "New email subscriber: $email";

    // Send the email
    $mail->send();

    // Email has been sent successfully
    echo "<fieldset>";
    echo "<div id='success_page'>";
    echo "<h3>Email Sent Successfully.</h3>";
    echo "<p class='center'>Thank you! We will contact you once we launch the website!</p>";
    echo "</div>";
    echo "</fieldset>";
} catch (Exception $e) {
    // An error occurred while sending the email
    echo '<div class="error_message">An error occurred. Please try again later.</div>';
}
?>
