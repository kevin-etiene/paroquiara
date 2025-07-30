<?php
// Inclua o autoloader do Composer.
// O caminho foi ajustado para ser relativo ao diretório atual,
// assumindo que a pasta 'vendor' está um nível acima da pasta 'Contato'.
require __DIR__ . 'contatos.php'; // Caminho corrigido para o autoloader do Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitiza os dados do formulário para segurança
    $nome = htmlspecialchars(trim($_POST['nome']));
    $email_remetente = htmlspecialchars(trim($_POST['email'])); // Este é o e-mail de quem preencheu o formulário
    $assunto_form = htmlspecialchars(trim($_POST['assunto'])); // Novo campo 'assunto'
    $mensagem = htmlspecialchars(trim($_POST['mensagem']));

    // Verifica se os campos obrigatórios estão preenchidos
    if (empty($nome) || empty($email_remetente) || empty($assunto_form) || empty($mensagem)) {
        echo "Por favor, preencha todos os campos obrigatórios.";
        exit;
    }

    // Configuração do PHPMailer
    $mail = new PHPMailer(true); // 'true' habilita exceções para erros, útil para depuração

    try {
        // Configurações do Servidor SMTP (Exemplo com Gmail)
        $mail->isSMTP();                                    // Indica que vai usar SMTP
        $mail->Host       = 'smtp.gmail.com';               // Servidor SMTP do Gmail
        $mail->SMTPAuth   = true;                           // Habilita autenticação SMTP
        $mail->Username   = 'SEU_EMAIL_DO_GMAIL@gmail.com'; // **Seu e-mail do Gmail que vai ENVIAR o e-mail**
        $mail->Password   = 'SUA_SENHA_DE_APP_DO_GMAIL';    // **Sua Senha de App do Gmail (NÃO a senha normal!)**
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Habilita criptografia TLS
        $mail->Port       = 587;                            // Porta TCP para conectar (587 para TLS/STARTTLS)
        $mail->CharSet    = 'UTF-8';                        // Garante que caracteres especiais funcionem

        // Remetente do e-mail (quem está realmente enviando via SMTP)
        // Deve ser o mesmo e-mail do Username configurado acima
        $mail->setFrom('SEU_EMAIL_DO_GMAIL@gmail.com', 'Secretaria Paroquial');

        // Destinatário do e-mail (para onde as mensagens do formulário serão enviadas)
        // ESTA LINHA JÁ ENVIA PARA O EMAIL DESEJADO: kevin.gti@fcarpvirtual.com
        //$mail->addAddress('kevin.gti@fcarpvirtual.com', 'Kevin Contato Paroquial'); // E-mail paroquial

        // Adiciona um "Reply-To" para que você possa responder diretamente ao usuário
        $mail->addReplyTo($email_remetente, $nome);

        // Conteúdo do E-mail
        $mail->isHTML(false); // Define o formato do e-mail como texto puro (mude para 'true' se quiser HTML)
        $mail->Subject = "Mensagem do Site - Assunto: " . $assunto_form; // Inclui o assunto do formulário
        $mail->Body    = "Nome: " . $nome . "\n"
                       . "E-mail: " . $email_remetente . "\n"
                       . "Assunto: " . $assunto_form . "\n\n" // Inclui o assunto no corpo
                       . "Mensagem:\n" . $mensagem;

        $mail->send();
        echo "Mensagem enviada com sucesso! A secretaria da paróquia responderá em breve.";

    } catch (Exception $e) {
        echo "Erro ao enviar mensagem. Por favor, tente novamente mais tarde. Detalhes do erro: {$mail->ErrorInfo}";
    }
} else {
    // Redireciona se a página for acessada diretamente sem um POST
    header("Location: contato.php");
    exit;
}
?>
