<?php

$base_url = 'guyb7local.com';

if (empty($_POST['contact_name']) && empty($_POST['contact_email']) && empty($_POST['contact_content'])) {
    complete(false, 'error-empty');
    exit;
} else if (preg_match('/http/', $_POST['contact_content']) && (empty($_POST['contact_captcha']) || !preg_match('/(Y7xp33|6Bp9Hz)/i', $_POST['contact_captcha']))) {
    complete(false, 'error-captcha');
    exit;
} else {
    send_email();
}

function send_email() {
    $name = empty($_POST['contact_name']) ? 'Anonymous' : $_POST['contact_name'];
    $address = empty($_POST['contact_email']) ? '[NO_EMAIL]' : $_POST['contact_email'];
    $message = empty($_POST['contact_content']) ? '[NO_MESSAGE]' : preg_replace('/\n/', '<br/>', $_POST['contact_content']);
    
    $html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width" />
        <title>GuyB7 Contact - Message from ' . $name . '</title>
    </head>
    <body>
        <div style="font-weight:bold">Name:</div>
            ' . $name . '
        <br><br>
        <div style="font-weight:bold">Email:</div>
            ' . $address . '
        <br><br>
        <div style="font-weight:bold">Message:</div>
            ' . $message . '
    </body>
</html>';
    
    require_once dirname(__FILE__) . '/phpmailer/PHPMailerAutoload.php';
    $email = new PHPMailer();
    $email->isSMTP();
    $email->SMTPDebug = 0;
    $email->Host = 'smtp.gmail.com';
    $email->Port = 587;
    $email->SMTPSecure = 'tls';
    $email->SMTPAuth = true;
    $email->Username = 'guy@correlife.org';
    $email->Password = 'VnxiPILk9cmge93U18';
    $email->setFrom('guyb7@correlife.org', 'GuyB7');
    $email->addReplyTo('guyb7@correlife.org', 'GuyB7');
    $email->Subject = 'GuyB7 site - Contact from ' . $name;
    $email->addAddress('guy.br7@gmail.com');
    $email->msgHTML($html);
    if (!$email->send()) {
        complete(false);
    } else {
        complete();
    }
}

function complete($success = true, $error = false) {
    if (!empty($_POST['ajax']) && $_POST['ajax'] == 'true') {
        header('Content-Type: application/json');
        if ($success) {
            echo json_encode(array('success' => $success), JSON_NUMERIC_CHECK);
        } else {
            echo json_encode(array('success' => $success, 'error' => $error), JSON_NUMERIC_CHECK);
        }
    } else {
        $html = str_replace('<body>', '<body class="message-email-'. ($success ? 'success' : 'fail') . '">', file_get_contents(dirname(__FILE__) . '/../index.html'));
        echo $html;
    }
}
