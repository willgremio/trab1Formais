<?php

require_once('classes/gramatica_tipos.php');

class Funcoes {

    public static function gerarSentenca($gramaticaInicio, $gramaticas, $novaSentenca = '', $iteracao = 0, $retornarSentencaFull = true) {
        if (self::temBarra($gramaticaInicio)) {
            $gramaticasDaVariavel = explode('|', $gramaticaInicio);
            $gramaticaInicio = self::escolheUmSimboloRandom($gramaticasDaVariavel);
        }

        $qntSimbolos = strlen($gramaticaInicio);
        $sentencaSubstituida = '';
        $tipoGramatica = self::getTipoGramatica($gramaticas);
        if ($tipoGramatica == GramaticaTipos::GRAMATICA_TIPO_0 || $tipoGramatica == GramaticaTipos::GRAMATICA_TIPO_1) {
            $sentencaSubstituida = $gramaticaInicio;
            if (preg_match('/X/', $gramaticaInicio)) {
                $sentencaSubstituida = preg_replace('/X/', '', $sentencaSubstituida); // se simbolo for X significa sentenca vazia, entao apaga
            } else {
                foreach ($gramaticas as $ladoEsquerdo => $ladoDireito) {
                    $pattern = '/' . $ladoEsquerdo . '/';
                    if (preg_match($pattern, $gramaticaInicio)) {
                        $simbolosParaSubstituir = explode('|', $ladoDireito); // depois verificar se tem |
                        $ladoDireitoSubstituir = self::escolheUmSimboloRandom($simbolosParaSubstituir);
                        $sentencaSubstituida = preg_replace($pattern, $ladoDireitoSubstituir, $sentencaSubstituida);
                    }
                }
            }
        } else {
            for ($i = 0; $i < $qntSimbolos; $i++) {
                $simbolo = $gramaticaInicio[$i];
                if (self::temSimboloNaoTerminal($simbolo) && isset($gramaticas[$simbolo])) {
                    $simbolosParaSubstituir = explode('|', $gramaticas[$simbolo]); // depois verificar se tem |
                    $sentencaSubstituida .= self::escolheUmSimboloRandom($simbolosParaSubstituir);
                } else {
                    if ($simbolo == 'X') {
                        $sentencaSubstituida .= ''; // se simbolo for X significa sentenca vazia, entao apaga
                    } else {
                        $sentencaSubstituida .= $simbolo; // se nao é NT continua a propria variavel
                    }
                }
            }
        }

        if (!empty($novaSentenca)) {
            $novaSentenca .= '->' . $sentencaSubstituida;
        } else {
            $novaSentenca = $gramaticaInicio . '->' . $sentencaSubstituida;
        }

        if ($iteracao == 50) { // somente para testes
            return $novaSentenca;
        }

        if (self::temSimboloNaoTerminal($sentencaSubstituida)) {
            $iteracao++;
            return self::gerarSentenca($sentencaSubstituida, $gramaticas, $novaSentenca, $iteracao, $retornarSentencaFull);
        }

        if ($retornarSentencaFull) {
            return $novaSentenca;
        }

        return $sentencaSubstituida;
    }

    public static function getLinguagemGramatica($gramaticaInicio, $gramaticas) {
        $sentencasGeradas = [];
        for ($i = 0; $i < 10; $i++) {
            $sentencasGeradas[] = self::gerarSentenca($gramaticaInicio, $gramaticas, '', 0, false);
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
            if (!isset($letrasDaSentencaMinina[$letra])) { //verifica se nao é nehuma letra da sentenca minima
                $padraoLinguagem .= $letra . '<sup>m</sup>';
            }
        }

        $padraoLinguagem .= '; n>=1, m>=0';
        return 'L(G) = {' . $padraoLinguagem . '}';
    }

    public static function temSimboloNaoTerminal($string) {
        return preg_match('/[A-Z]/', $string);
    }

    public static function temBarra($string) {
        return preg_match('/\|/', $string);
    }

    public static function escolheUmSimboloRandom($simbolosParaSubstituir) {
        $indice = array_rand($simbolosParaSubstituir, 1); // funcao q escolhe randomicamente um indice do array
        return $simbolosParaSubstituir[$indice];
    }

    public static function getTipoGramatica($gramaticas) {
        $objGramaticaTipos = new GramaticaTipos();
        return $objGramaticaTipos->getTipo($gramaticas);
    }

}
