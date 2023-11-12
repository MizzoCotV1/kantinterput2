<?php
require __DIR__ . '/vendor/autoload.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'] ?? '';

    // Implement Twilio API or your preferred method to send the WhatsApp message
    // Example: Use Twilio WhatsApp API
    // You'll need to replace the placeholder values with your Twilio credentials
    $twilioAccountSid = 'AC52d04f56a85b1d90e1ed11d05a69892b';
    $twilioAuthToken = '4f623f8eb7a7252e1d5a6679bf195548';
    $twilioPhoneNumber = '+14155238886';

    $client = new Twilio\Rest\Client($twilioAccountSid, $twilioAuthToken);

    $message = $client->messages->create(
        "whatsapp:+6285157171344",
        [
            "from" => "whatsapp:" . $twilioPhoneNumber,
            "body" => $message,
        ]
    );

    // Output success or failure based on the result of the API call
    if ($message->errorCode == null) {
        echo "WhatsApp message sent successfully!";
    } else {
        echo "Error sending WhatsApp message. Please try again.";
    }
}
?>
