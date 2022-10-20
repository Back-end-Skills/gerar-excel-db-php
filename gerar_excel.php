<?php
    session_start();

    // Limpar o buffer
    ob_start();

    include './connection.php';

    $user_query = ("SELECT id_produtos, nome, preco FROM produtos WHERE id_produtos > 0 ORDER BY id_produtos ASC");
    $res_query = $conn->prepare($user_query);
    $res_query->execute();

    if (($res_query) and ($res_query->rowCount() > 0 )) 
    {
        // Aceitar csv ou txt
        header('Content-Type: text/csv: charset=UTF-8');

        // Seta o Nome arquivo
        header('Content-Disposition: attachment; filename=arquivo.csv');

        // Gravar no buffer
        $arquivo = fopen('php://output', 'w');
        
        // Cabeçalho e Converter para caracteres especiais
        $header = ['id_produtos',mb_convert_encoding('nome', 'ISO-8859-1', 'UTF-8'),'preco'];

        // Escrever cabeçalho no arquivo
        fputcsv($arquivo, $header, ';');

        while ($res_data_user = $res_query->fetch(PDO::FETCH_ASSOC)) { 

            // Escrever conteudo no arquivo
            fputcsv($arquivo, $res_data_user, ';');
        }
      
        fclose($arquivo);

    } else {
        $_SESSION['msg'] = "<p style='color: #f00'>Erro:Sem Registro</p>";
        header("location: index.php");
    }