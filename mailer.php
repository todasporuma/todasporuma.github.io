<?php

		// Processa apenas solicitações POST.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtenha os campos do formulário e remova os espaços em branco.
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        // $ cont_subject = trim ($ _ POST ["assunto"]);
        $message = trim($_POST["message"]);

        // Verifique se os dados foram enviados para a mala direta.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
           // Defina um código de resposta 400 (solicitação incorreta) e saia.
            http_response_code(400);
            echo "Ops! Ocorreu um problema com o envio. Por favor, preencha o formulário e tente novamente.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "todasporuma19@gmail.com";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        // $email_content .= "Subject: $cont_subject\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Obrigado! Sua mensagem foi enviada.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Opa! Algo deu errado e não conseguimos enviar sua mensagem.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Ocorreu um problema no seu envio, tente novamente.";
    }

?>