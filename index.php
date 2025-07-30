<?php
// Inclui o arquivo de configuração do banco de dados
require_once __DIR__ . '/../aministracao/config.php';

// Prepara a consulta SQL para selecionar todas as postagens, ordenadas pela mais recente
// Agora, selecione também a coluna imagem_url
$sql = "SELECT titulo, conteudo, imagem_url, data_criacao FROM posts ORDER BY data_criacao DESC";
$result = $conn->query($sql); // Executa a consulta
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notícias Paroquiais</title>
    <link rel="stylesheet" href="../Estilos/santos.css">
    <link rel="website icon" type="image/png" href="../Imagens/PNG/Brasão branco.png">
    <!--
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 20px; line-height: 1.6; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); max-width: 800px; margin: auto; }
        h1 { text-align: center; color: #0056b3; margin-bottom: 30px; }
        .post { background-color: #f9f9f9; border: 1px solid #e1e1e1; border-radius: 6px; padding: 15px; margin-bottom: 20px; }
        .post h2 { color: #007bff; margin-top: 0; }
        .post p { margin-bottom: 10px; }
        .post .data { font-size: 0.9em; color: #666; text-align: right; }
        .post .post-image { max-width: 100%; height: auto; border-radius: 4px; margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto; }
        .no-posts { text-align: center; color: #666; }
        .admin-link { display: inline-block; margin-bottom: 20px; padding: 10px 15px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        .admin-link:hover { background-color: #218838; }
        /* Opcional: Adicione um efeito visual para o link da imagem */
        .post-image-link { display: block; } /* Para garantir que o link ocupa todo o espaço da imagem */
        .post-image-link:hover img { opacity: 0.8; transition: opacity 0.3s ease; /* Adiciona um pequeno efeito ao passar o mouse */ }
    </style>
-->
</head>
<body>
    <div class="container">
        <h1>Últimas Notícias</h1>
        
        <a href="aministracao/admin.php" class="admin-link">Criar Nova Postagem</a>
        <hr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h2>" . htmlspecialchars($row["titulo"]) . "</h2>";
                
                // Exibe a imagem se houver uma URL
                if (!empty($row["imagem_url"])) {
                    // ADICIONADO: A tag <a> envolvendo a <img>
                    // target="_blank" fará com que a imagem abra em uma nova aba/janela
                    echo "<a href='" . htmlspecialchars($row["imagem_url"]) . "' target='_blank' class='post-image-link'>";
                    echo "<img src='" . htmlspecialchars($row["imagem_url"]) . "' alt='" . htmlspecialchars($row["titulo"]) . "' class='post-image'>";
                    echo "</a>"; // Fecha a tag <a>
                }

                echo "<p>" . nl2br(htmlspecialchars($row["conteudo"])) . "</p>";
                echo "<p class='data'>Publicado em: " . date("d/m/Y H:i", strtotime($row["data_criacao"])) . "</p>";
                echo "</div>";
            }
        } 
echo '<a href="../index.html" class="back-button">Voltar para a Página Inicial</a>';
        $conn->close();
        ?>
    </div>
</body>
</html>