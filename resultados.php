<?php
if (!isset($_POST['data'])) {
    header('Location: index.html');
}

require_once('funcoes.php');
$gramaticas = [];
$variaveisLadoEsquerdo = $_POST['data']['GramaticaVariavel']['Esquerdo'];
$variaveisLadoDireito = $_POST['data']['GramaticaVariavel']['Direito'];

foreach ($variaveisLadoEsquerdo as $indice => $esquerdo) {
    $gramaticas[$esquerdo] = $variaveisLadoDireito[$indice];
}

$variaveisTerminaveis = $_POST['data']['Terminais'];
$variaveisNaoTerminaveis = $_POST['data']['NaoTerminais'];
$varNaoTerminais = $terminaveis = '';
foreach ($variaveisNaoTerminaveis as $variavelNaoTermianal) {
    $varNaoTerminais .= $variavelNaoTermianal . ',';
}

foreach ($variaveisTerminaveis as $variavelTerminavel) {
    $terminaveis .= $variavelTerminavel . ',';
}

$terminaveis = rtrim($terminaveis, ","); // remove ultima virgula
$varNaoTerminais = rtrim($varNaoTerminais, ",");
$simboloInicial = $_POST['data']['simbolo_inicio'];


$formalismo = 'G = ({' . $varNaoTerminais . '}, {' . $terminaveis . '}, P, ' . $simboloInicial . ')';

$tipoGramatica = Funcoes::getTipoGramatica($gramaticas);
?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="css/index.css">
    </head>
    <body>
        <h1>Resultados</h1>

        <h2>Grámatica</h2>
        <h3>Formalismo:</h3>
        <div class="conteudoDosTitulos">
            <p><?= $formalismo ?></p>

            P: { <br />
            <div id="gramaticas">
                <?php
                foreach ($gramaticas as $variavel => $gramatica) :
                    echo $variavel . ' => ' . $gramatica . '<br />';
                endforeach;
                ?>
            </div>

            }
        </div>

        <h3>Tipo de Grámatica</h3>
        <div class="conteudoDosTitulos">
            <?= $tipoGramatica ?>
        </div>        

        <h3>Sentenças Geradas:</h3>
        <div class="conteudoDosTitulos">
            <?php
            for ($i = 0; $i < 6; $i++) {
                echo '<p>' . Funcoes::gerarSentenca($gramaticas[$simboloInicial], $gramaticas) . '</p>';
            }
            ?>        
        </div>

        <h3>Linguagem</h3>
        <div class="conteudoDosTitulos">
            <?= Funcoes::getLinguagemGramatica($gramaticas[$simboloInicial], $gramaticas); ?>
        </div>
    </body>
</html>




