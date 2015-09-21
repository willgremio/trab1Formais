<?php

function gerarSentenca($gramaticaInicio, $gramaticas, $novaSentenca = '', $iteracao = 0) {
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
        gerarSentenca($sentencaSubstituida, $gramaticas, $novaSentenca, $iteracao);
    } else {
        echo $novaSentenca;
    }
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
    /* var_dump($gramaticas);
      exit; */
    foreach ($gramaticas as $variavel => $gramatica) {
        
    }

    return '';    
}
