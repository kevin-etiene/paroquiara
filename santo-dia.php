<?php
// Configurações de conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "santos_catolicos");

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obtém a data de hoje no formato Mês-Dia (ex: 07-21)
$dataHoje = date("m-d");

// Prepara a consulta SQL para buscar santos pela data de festa
$sql = "SELECT nome, descricao FROM santos WHERE DATE_FORMAT(data_festa, '%m-%d') = ?";
$stmt = $conn->prepare($sql);

// Verifica se a preparação da consulta falhou
if ($stmt === false) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Vincula o parâmetro e executa a consulta
$stmt->bind_param("s", $dataHoje);
$stmt->execute();
$stmt->bind_result($nomeSanto, $descricaoSanto);

// Início do HTML
echo "<!DOCTYPE html>";
echo "<html lang='pt-BR'>";
echo "<head>";
echo "    <meta charset='UTF-8'>";
echo "    <meta name='viewport' content='width=device-width, initial-scale=1.0'>";
echo "    <title>Santo(s) do Dia</title>";
echo "    <link rel='stylesheet' href='../Estilos/santos.css'>"; // <-- Verifique este caminho!
echo "    <link rel='website icon' type='image/png' href='../Imagens/PNG/Brasão branco.png'>";
echo "</head>";
echo "<body>";

echo "<h1>Santo(s) do Dia " . date("d/m") . "</h1>";

$santosEncontrados = false; // Flag para controlar se algum santo foi encontrado

// ABRE O CONTAINER PRINCIPAL DO GRID AQUI! ESTE É CRUCIAL PARA O FLEXBOX.
echo "<div class='santos-grid-container'>";

// Loop para buscar e exibir todos os santos para a data de hoje
while ($stmt->fetch()) {
    $santosEncontrados = true; // Um santo foi encontrado

    // Codifica o nome do santo para a URL da Wikipedia
    $tituloWiki = urlencode($nomeSanto);
    $urlWiki = "https://pt.wikipedia.org/w/api.php?action=query&titles={$tituloWiki}&prop=pageimages&format=json&pithumbsize=500";

    // Usa cURL para fazer a requisição à API da Wikipedia (mais robusto que file_get_contents)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlWiki);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'MeuAppDeSantos/1.0 (seu_email@exemplo.com)'); // User-Agent é obrigatório pela API da Wikipedia
    $resposta = curl_exec($ch);
    
    // Verifica por erros cURL
    if (curl_errno($ch)) {
        error_log("Erro cURL ao buscar imagem para {$nomeSanto}: " . curl_error($ch));
        $dados = null; // Garante que $dados seja nulo em caso de erro
    } else {
        $dados = json_decode($resposta, true);
    }
    curl_close($ch);

    $imagem = 'https://via.placeholder.com/300x400?text=Sem+Imagem'; // Imagem padrão
    
    // Tenta obter a URL da imagem da Wikipedia
    if (isset($dados['query']['pages']) && !empty($dados['query']['pages'])) {
        $pagina = array_values($dados['query']['pages'])[0];
        if (isset($pagina['thumbnail']['source'])) {
            $imagem = $pagina['thumbnail']['source'];
        }
    }

    // Exibe o cartão de cada santo
    echo "<div class='santo-container'>";
    echo "    <h2>$nomeSanto</h2>";
    echo "    <img src='$imagem' alt='Imagem de $nomeSanto' class='santo-imagem'><br>";
    echo "    <p>$descricaoSanto</p>";
    echo "</div>"; // Fecha o santo-container individual
}

// FECHA O CONTAINER PRINCIPAL DO GRID AQUI!
echo "</div>"; // Fecha .santos-grid-container

// Mensagem se nenhum santo for encontrado
if (!$santosEncontrados) {
    echo "<p style='text-align: center; margin-top: 50px; font-size: 1.2em; color: #777;'>Nenhum santo encontrado para hoje.</p>";
}

// Link para voltar
echo '<a href="../index.html" class="back-button">Voltar para a Página Inicial</a>';

// Fim do HTML
echo "</body>";
echo "</html>";

// Fecha a declaração e a conexão com o banco de dados
$stmt->close();
$conn->close();
?>