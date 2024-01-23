<?php
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

//count MOSTRA QUAL É O TAMANHO DO ARRAY
if (count($_POST) > 0) {
    //CONECTANDO COM conexao.php
    include('conexao.php');

    $erro = false;
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $nascimento = $_POST['nascimento'];

    //empty VERIFICA SE A VARIAVEL $erro ESTÁ VAZIA
    if (empty($nome)) {
        $erro = "Preencha o nome";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        # se o emmail for vazio ele prenche o erro
        $erro = "Preencha o e-mail";
    }

    //MUDANDO A DATA PARA O PADRAO AMERICANO
    //28/02/1994
    //arrat(27, 02, 1994)
    //1994-02-28
    if (!empty($nascimento)) {
        //verificar se a erro na data 
        $pedacos = explode('/', $nascimento);
        if (count($pedacos) == 3) {
            $pedacos = implode('-', array_reverse($pedacos));
        } else {
            $erro = "A data de nascimento deve segir o padrão dia/mes/ano. ";
        }
    }

    //se o telefone não for vasio vai faser uma limpesa no telefone
    if (!empty($telefone)) {
        $telefone = limpar_texto($telefone);
        if (strlen($telefone) != 11)
            # se o telefone for diferente de 11 vai aver erro
            $erro = "O telefone deve ser prenchido no padrão (21) 98888-8888";
    }

    if ($erro) {
        echo "<p><b>ERRO: $erro</b></p>";
    } else {
        //INSERSAO DO BANCO DE DADOS
        //inserindo as colunas do banco de dados
        //NOW() preenche a data e a hora altomaticamente
        $sql_code = "INSERT INTO clientes (nome, email, telefone, nascimento, data) 
        VALUES ('$nome', '$email', '$telefone', '$nascimento', NOW())";

        //MENSAGEM QUE DEU CERTO
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if ($deu_certo) {
            echo "<p><b>Cliente cadastrado com sucesso!!!</b></p>";
            //vai limpar o $_POST
            unset($_POST);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="clientes.php">Voltar a lista</a>
    <!--AREA DE CADASTRO-->
    <!--O METODO A SER ENVIADO  PHP VAI SER'POST'-->
    <form method="POST" action="">
        <p>
            <!--value VERIFICAR SE FOI PREENCHIDA-->
            <label>Nome:</label>
            <input value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>" name="nome" type="text">
        </p>
        <p>
            <label>E-mail:</label>
            <input value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" name="email" type="text">
        </p>
        <p>
            <label>Telefone</label>
            <!--placeholder GUARDA O NUMERO-->
            <input value="<?php if (isset($_POST['telefone'])) echo $_POST['telefone']; ?>" placeholder="(21) 98888-8888" name="telefone" type="text">
        </p>
        <p>
            <label>Data de Nascimento:</label>
            <input value="<?php if (isset($_POST['nascimento'])) echo $_POST['nascimento']; ?>" name="nascimento" type="text">
        </p>
        <p>
            <!--CRIANDO BOTÃO tipo 'submit' por que vai ficar dentro do 'form'-->
            <!--para ativar o 'from' presisa do 'submit'-->
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>
</body>

</html>