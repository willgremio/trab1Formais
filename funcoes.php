<?php

require_once('classes/gramatica_tipos.php');

function gerarSentenca($gramaticaInicio, $gramaticas, $novaSentenca = '', $iteracao = 0, $retornarSentencaFull = true) {
    if (temBarra($gramaticaInicio)) {
        $gramaticasDaVariavel = explode('|', $gramaticaInicio);
        $gramaticaInicio = escolheUmSimboloRandom($gramaticasDaVariavel);
    }

    $qntSimbolos = strlen($gramaticaInicio);
    $sentencaSubstituida = '';

    for ($i = 0; $i < $qntSimbolos; $i++) {
        $simbolo = $gramaticaInicio[$i];
        if (temSimboloNaoTerminal($simbolo) && isset($gramaticas[$simbolo])) {
            $simbolosParaSubstituir = explode('|', $gramaticas[$simbolo]); // depois verificar se tem |
            $sentencaSubstituida .= escolheUmSimboloRandom($simbolosParaSubstituir);
        } else {
            if ($simbolo == 'X') {
                $sentencaSubstituida .= ''; // se simbolo for X significa sentenca vazia, entao apaga
            } else {
                $sentencaSubstituida .= $simbolo; // se nao é NT continua a propria variavel
            }
        }
    }

    if (!empty($novaSentenca)) {
        $novaSentenca .= '->' . $sentencaSubstituida;
    } else {
        $novaSentenca = $gramaticaInicio . '->' . $sentencaSubstituida;
    }

    if ($iteracao == 10) { // somente para testes
        /* echo $novaSentenca;
          return; */
    }

    if (temSimboloNaoTerminal($sentencaSubstituida)) {
        $iteracao++;
        return gerarSentenca($sentencaSubstituida, $gramaticas, $novaSentenca, $iteracao, $retornarSentencaFull);
    }

    if ($retornarSentencaFull) {
        return $novaSentenca;
    }

    return $sentencaSubstituida;
}

function getLinguagemGramatica($gramaticaInicio, $gramaticas) {
    $sentencasGeradas = [];
    for ($i = 0; $i < 8; $i++) {
        $sentencasGeradas[] = gerarSentenca($gramaticaInicio, $gramaticas, '', 0, false);
    }

    $letrasEncontradas = [];
    $sentencaMinima = $sentencasGeradas[0];
    foreach ($sentencasGeradas as $sentenca) {
        if (strlen($sentenca) < strlen($sentencaMinima)) {
            $sentencaMinima = $sentenca;
        }

        for ($i = 0; $i < strlen($sentenca); $i++) {
            $letra = $sentenca[$i];
            if (!isset($letrasEncontradas[$letra])) {
                $letrasEncontradas[$letra] = $letra;
            }
        }
    }

    $padraoLinguagem = '';
    $letrasDaSentencaMinina = [];
    for ($i = 0; $i < strlen($sentencaMinima); $i++) {
        $letra = $sentencaMinima[$i];
        $letrasDaSentencaMinina[$letra] = $letra;
        $padraoLinguagem .= $letra . '<sup>n</sup>';
    }

    
    foreach ($letrasEncontradas as $letra) {
        if(!isset($letrasDaSentencaMinina[$letra])) { //verifica se nao é nehuma letra da sentenca minima
            $padraoLinguagem .= $letra . '<sup>m</sup>';
        }
    }
    
    $padraoLinguagem .= '; n>=1, m>=0';
    return 'L(G) = {' . $padraoLinguagem . '}';
}

function temSimboloNaoTerminal($string) {
    return preg_match('/[A-Z]/', $string);
}

function temBarra($string) {
    return preg_match('/\|/', $string);
}

function escolheUmSimboloRandom($simbolosParaSubstituir) {
    $indice = array_rand($simbolosParaSubstituir, 1); // funcao q escolhe randomicamente um indice do array
    return $simbolosParaSubstituir[$indice];
}

function getTipoGramatica($gramaticas) {
    $objGramaticaTipos = new GramaticaTipos();
    return $objGramaticaTipos->getTipo($gramaticas);
}
