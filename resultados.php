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
$varNaoTerminais = $terminaveis = '';
foreach ($gramaticas as $variavelNaoTermianal => $gramatica) {
    $varNaoTerminais .= $variavelNaoTermianal . ',';
}

foreach ($variaveisTerminaveis as $variavelTerminavel) {
    $terminaveis .= $variavelTerminavel . ',';
}

$terminaveis = rtrim($terminaveis, ","); // remove ultima virgula
$varNaoTerminais = rtrim($varNaoTerminais, ",");
reset($gramaticas); // faz o ponteiro do array ir para a 1ª posicao
$SimboloInicial = key($gramaticas); // pega 1º indice do array como variavel inicial


$formalismo = 'G = ({' . $varNaoTerminais . '}, {' . $terminaveis . '}, P, ' . $SimboloInicial . ')';

$tipoGramatica = getTipoGramatica($gramaticas);
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


        <h3>Sentenças Geradas:</h3>
        <?php
        for ($i = 0; $i < 5; $i++) {
            echo '<p>' . gerarSentenca($gramaticas[$SimboloInicial], $gramaticas) . '</p>';
        }
        ?>

        <h3>Tipo de Grámatica</h3>
        <?= $tipoGramatica ?>
    </body>
</html>




