<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Secretaria Paroquial</title>
    <link rel="stylesheet" href="../Estilos/estilo.css">
        <link rel="website icon" type="image/png" href="../Imagens/PNG/Brasão branco.png">

</head>
<body>
    <header>
        <img src="../Imagens/PNG/Brasão Principal.png" alt="Logo da Paróquia"> <h1>Secretaria Paroquial</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../Eventos/evento.php">Eventos</a></li>
                <li><a href="../Eventos/horarios.html">Horários de Missa</a></li>
                <li><a href="contatos.php">Contato</a></li>
                <li><a href="../Evangelho/evangelho_santo.php">Evangelho e Santo do Dia</a></li>
            </ul>
        </nav>
    </header>

    <section id="formulario-contato">
        <h2>Fale com a Secretaria da Paróquia</h2>
        <p>Preencha o formulário abaixo para entrar em contato com a secretaria da paróquia. Responderemos o mais breve possível!</p>
        <form action="processa_contato.php" method="POST">
            <label for="nome">Seu Nome Completo:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="email">Seu Melhor E-mail:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="assunto">Assunto:</label>
            <input type="text" id="assunto" name="assunto" required placeholder="Ex: Dúvida sobre Batismo, Agendamento, Informações Gerais"><br><br>

            <label for="mensagem">Sua Mensagem:</label><br>
            <textarea id="mensagem" name="mensagem" rows="6" required placeholder="Descreva sua solicitação ou pergunta aqui..."></textarea><br><br>

            <button type="submit">Enviar Mensagem</button>
        </form>
    </section>

    <footer>
        <p>&copy; 2025 Paróquia Nossa Senhora de Fátima</p>
    </footer>
</body>
</html>