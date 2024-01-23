<?php
//CONECTANDO COM conexao.php
include('conexao.php');
$id = intval($_GET['id']);
function limpar_texto($str)
{
    return preg_replace("/[^0-9]/", "", $str);
}

//count MOSTRA QUAL É O TAMANHO DO ARRAY
if (count($_POST) > 0) {

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
        //não precisou faser o tratamento por que já foi feito no 'cadastrar_cliente.php'
        $sql_code = "UPDATE clientes 
        SET nome = '$nome', 
        email = '$email',
        telefone = '$telefone',
        nascimento = '$nascimento'
        WHERE id = '$id'";

        //MENSAGEM QUE DEU CERTO
        $deu_certo = $mysqli->query($sql_code) or die($mysqli->error);
        if ($deu_certo) {
            echo "<p><b>Cliente atualizado com sucesso!!!</b></p>";
            //vai limpar o $_POST
            unset($_POST);
        }
    }
}
//$_GET é uma superglobal em PHP que é usada para coletar dados enviados para o script PHP 
//por meio da URL. Quando você envia dados por meio de um formulário HTML com o método GET ou 
//anexa parâmetros à URL, esses dados podem ser acessados no script PHP usando $_GET.

$sql_cliente = "SELECT * FROM clientes WHERE id = '$id'";
$query_cliente = $mysqli->query($sql_cliente) or die($mysqli->error);
$cliente = $query_cliente->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Cliente</title>
</head>

<body>
    <a href="clientes.php">Voltar para a lista</a>
    <!--AREA DE CADASTRO-->
    <!--O METODO A SER ENVIADO  PHP VAI SER'POST'-->
    <form method="POST" action="">
        <p>
            <!--value VERIFICAR SE FOI PREENCHIDA-->
            <label>Nome:</label>
            <input value="<?php echo $cliente['nome']; ?>" name="nome" type="text">
        </p>
        <p>
            <label>E-mail:</label>
            <input value="<?php echo $cliente['email']; ?>" name="email" type="text">
        </p>
        <p>
            <!--COMO TELEFONE E DATA DE NASCIMENTO SÃO OPCIONAIS PRECISAO SER VERIFICADOS SE ELES EXISTEM OU NAO PARA ISSO USAMOS O !empy -->
            <label>Telefone</label>
            <!--placeholder GUARDA O NUMERO-->
            <input value="<?php if (!empty($cliente['telefone'])) echo formatar_telefone($cliente['telefone']); ?>" placeholder="(21) 98888-8888" name="telefone" type="text">
        </p>
        <p>
            <label>Data de Nascimento:</label>
            <input value="<?php if (!empty($cliente['nascimento'])) echo formatar_data($cliente['nascimento']); ?>" name="nascimento" type="text">
        </p>
        <p>
            <!--CRIANDO BOTÃO tipo 'submit' por que vai ficar dentro do 'form'-->
            <!--para ativar o 'from' presisa do 'submit'-->
            <button type="submit">Salvar Cliente</button>
        </p>
    </form>
</body>

</html>