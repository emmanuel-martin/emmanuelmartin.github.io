<?php


$from = 'Emmanuel Martin <helloiamemmanuel@gmail.com>';

$sendTo = 'Emmanuel Martin <helloiamemmanuel@gmail.com>';

$subject = 'Message from my website';

$fields = array('InputName' => 'Name', 'InputEmail' => 'Email', 'InputSubject' => 'Subject', 'InputMessage' => 'Message'); 

$okMessage = 'Thank you for the message, I will get back to you soon!';

$errorMessage = 'There was an error while submitting the form. Please try again later';



error_reporting(E_ALL & ~E_NOTICE);

try
{

    if(count($_POST) == 0) throw new \Exception('Form is empty');
            
    $emailText = "Someone has send you a message \n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
        'From: ' . $from,
        'Reply-To: ' . $from,
        'Return-Path: ' . $from,
    );
    
    // Send email
    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
}
else {
    echo $responseArray['message'];
}
