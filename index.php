<?php 
    session_start();
    
    include './connection.php';

    $user_query = ("SELECT id_produtos, nome, preco FROM produtos WHERE id_produtos > 0 ORDER BY id_produtos DESC");
    $res_query = $conn->prepare($user_query);
    $res_query->execute();

    
    echo "<h1>Listar Usuários: </h1>";

    echo "<a href='gerar_excel.php'>Gerar Excel</a><br><br>";

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }

    
    if (($res_query) and ($res_query->rowCount() > 0 )) 
    {
        while ($res_user = $res_query->fetch(PDO::FETCH_ASSOC)) {
            //var_dump($res_user);

            //Coluna como variável
            extract($res_user);
            echo "Id: $id_produtos <br> ";
            echo "Nome: $nome <br> ";
            echo "Preço: $preco <br> ";
            echo "<hr>";
            
        }


    } else {
        echo "<p style='color: #f00'>Erro:Sem Registro</p>";
    }