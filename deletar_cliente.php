<?php
if (isset($_POST['confirmar'])) {

    include("conexao.php");
    $id = intval($_GET['id']);
    $sql_code = "DELETE FROM clientes WHERE id = '$id'";
    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

    if ($sql_query) { ?>
        <h1>Cliente deletado com sucesso!</h1>
        <p><a href="clientes.php">Clique aqui</a> para voltar a lista de clientes.</p>
<?php
        //para encerrar o codigo 'die'
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar Cliente</title>
</head>

<body>
    <h1>Tem certeza que deseja deletar este cliente?</h1>
    <!--CRIANDO UM FORMULARIO-->
    <form action="" method="post">
        <!--transformando o botão "NÃO" em um link para voutar para a pagina 'cliente.php'-->
        <a style="margin-right:40px;" href="clientes.php">Não</a>

        <!--COLOCANDO UM name(nome) NO button E UM value(valor) 1=true(sim)-->
        <button name="confirmar" value="1" type="submit">Sim</button>
    </form>
</body>

</html>