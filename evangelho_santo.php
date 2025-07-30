<?php
// API da Liturgia Diária para obter o Evangelho e o Santo do dia
$url = "https://liturgia.up.railway.app/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$evangelhoTexto = "Evangelho não disponível no momento.";
$evangelhoReferenciaCompleta = "Referência não disponível.";
$evangelhoEvangelistaLivro = "Evangelista/Livro não disponível.";
$evangelhoVersiculos = "Versículos não disponíveis.";
$santo = "Santo não disponível.";

if ($http_code == 200 && $response) {
    $data = json_decode($response, true);

    // Evangelho
    $evangelhoTexto = $data['evangelho']['texto'] ?? "Evangelho não disponível.";
    $evangelhoReferenciaCompleta = $data['evangelho']['referencia'] ?? "Referência não disponível.";

    if ($evangelhoReferenciaCompleta !== "Referência não disponível.") {
        $primeiroEspaco = strpos($evangelhoReferenciaCompleta, ' ');
        if ($primeiroEspaco !== false) {
            $nomeLivro = substr($evangelhoReferenciaCompleta, 0, $primeiroEspaco);
            $versiculos = substr($evangelhoReferenciaCompleta, $primeiroEspaco + 1);
            $evangelhoEvangelistaLivro = "São " . $nomeLivro;
            $evangelhoVersiculos = $versiculos;
        } else {
            $evangelhoEvangelistaLivro = "São " . $evangelhoReferenciaCompleta;
            $evangelhoVersiculos = "";
        }
    }

    // Santo
    $santo = $data['santo']['nome'] ?? "Santo não disponível.";
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evangelho do dia</title>
    <link rel="stylesheet" href="../Estilos/estilo.css">
    <link rel="website icon" type="image/png" href="../Imagens/PNG/Brasão branco.png">
</head>
<body>
    <header>
        <img src="../Imagens/PNG/Brasão Principal.png" alt="Logo da Paróquia">
        <h1>Evangelho do Dia</h1>
        <nav>
            <ul>
                <li><a href="../index.html">Home</a></li>
                <li><a href="../Eventos/eventos.html">Eventos</a></li>
                <li><a href="../Eventos/horario.html">Horários de Missa</a></li>
                <li><a href="../Contato/contatos.php">Contato</a></li>
                <li><a href="evangelho_santo.php">Evangelho</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="evangelho-do-dia">
            <h2>Evangelho do Dia</h2>
            <h3>Proclamação do Evangelho de Jesus Cristo segundo <?php echo htmlspecialchars($evangelhoEvangelistaLivro); ?> <?php echo htmlspecialchars($evangelhoVersiculos); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($evangelhoTexto)); ?></p>
            <p class="palavra-salvacao">Palavra da Salvação.</p> 
            <p class="gloria-senhor">Glória a vós, Senhor.</p> 
            <p>Reflita sobre a Palavra de Deus para o dia de hoje.</p>
        </section>
    
        <section id="leitura-extra">
            <h2>Para Aprofundar</h2>
            <p>Recomendamos a leitura completa da Bíblia e a vida dos santos para maior conhecimento e edificação espiritual. Visite a seção de Horários de Missa para participar da celebração diária da Palavra e da Eucaristia.</p>
            <a href="../Eventos/horario.html" class="btn-voltar">Ver Horários de Missa</a>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Paróquia Nossa Senhora de Fátima</p>
    </footer>
</body>
</html>
