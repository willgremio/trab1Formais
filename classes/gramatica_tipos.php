<?php

class GramaticaTipos {

    const GRAMATICA_TIPO_0 = 'Grámatica Irrestrita ou Tipo 0';
    const GRAMATICA_TIPO_1 = 'Grámatica Sensível ao Contexto ou Tipo 1';
    const GRAMATICA_TIPO_2 = 'Grámatica Livre de Contexto ou Tipo 2';
    const GRAMATICA_TIPO_3 = 'Grámatica Regular ou Tipo 3';

    public function getTipo($gramaticas) {
        if ($this->isTipo3($gramaticas)) {
            return self::GRAMATICA_TIPO_3;
        }

        if ($this->isTipo2($gramaticas)) {
            return self::GRAMATICA_TIPO_2;
        }

        if ($this->isTipo1($gramaticas)) {
            return self::GRAMATICA_TIPO_1;
        }

        return self::GRAMATICA_TIPO_0;
    }

    public function isTipo1($gramaticas) {
        foreach ($gramaticas as $ladoEsquerdo => $gramatica) {
            if (self::temBarra($gramatica)) {
                $gramatica = explode('|', $gramatica); // precisa verificar cada gramatica
                foreach ($gramatica as $gram) {
                    if (!self::verificaRegraTipo1($ladoEsquerdo, $gram)) {
                        return false;
                    }
                }

                continue; // faz ir p/ proximo valor do foreach
            }

            if (!self::verificaRegraTipo1($ladoEsquerdo, $gramatica)) {
                return false;
            }
        }

        return true;
    }

    public function isTipo2($gramaticas) {
        foreach ($gramaticas as $ladoEsquerdo => $gramatica) {
            if (self::temBarra($gramatica)) {
                $gramatica = explode('|', $gramatica); // precisa verificar cada gramatica
                foreach ($gramatica as $gram) {
                    if (!self::verificaRegraTipo2($ladoEsquerdo, $gram)) {
                        return false;
                    }
                }

                continue; // faz ir p/ proximo valor do foreach
            }

            if (!self::verificaRegraTipo2($ladoEsquerdo, $gramatica)) {
                return false;
            }
        }

        return true;
    }

    public function isTipo3($gramaticas) {
        foreach ($gramaticas as $ladoEsquerdo => $gramatica) {
            if (self::temBarra($gramatica)) {
                $gramatica = explode('|', $gramatica); // precisa verificar cada gramatica
                foreach ($gramatica as $gram) {
                    if (!self::verificaRegraTipo3($ladoEsquerdo, $gram)) {
                        return false;
                    }
                }

                continue; // faz ir p/ proximo valor do foreach
            }

            if (!self::verificaRegraTipo3($ladoEsquerdo, $gramatica)) {
                return false;
            }
        }

        return true;
    }

    public static function verificaRegraTipo1($ladoEsquerdo, $gramatica) {
        $ladoEsquerdoCheck = $ladoDireitoCheck = false;
        if (strlen($ladoEsquerdo) <= strlen($gramatica)) { // lado esquerdo: comprimento menor ou igual a sentença do lado direito
            $ladoEsquerdoCheck = true;
        }

        if ((strlen($gramatica) >= strlen($ladoEsquerdo)) && !self::temOcorrenciaSentenciaVazia($gramatica)) { //comprimento maior ou igual a sentença do lado esquerdo e não é aceita a setença vazia
            $ladoDireitoCheck = true;
        }

        return $ladoEsquerdoCheck && $ladoDireitoCheck;
    }

    public static function verificaRegraTipo2($ladoEsquerdo, $gramatica) {
        $ladoEsquerdoCheck = $ladoDireitoCheck = false;
        if (strlen($ladoEsquerdo) == 1 && self::temSimboloNaoTerminal($ladoEsquerdo)) { // lado esquerdo sempre um e apenas um não-terminal 
            $ladoEsquerdoCheck = true;
        }

        if (!self::temOcorrenciaSentenciaVazia($gramatica)) { //lado direito não é aceita X(sentença vazia)
            $ladoDireitoCheck = true;
        }

        return $ladoEsquerdoCheck && $ladoDireitoCheck;
    }

    public static function verificaRegraTipo3($ladoEsquerdo, $gramatica) {
        $ladoEsquerdoCheck = $ladoDireitoCheck = false;
        if (strlen($ladoEsquerdo) == 1 && self::temSimboloNaoTerminal($ladoEsquerdo)) { // sempre um e apenas um não-terminal 
            $ladoEsquerdoCheck = true;
        }

        if (self::isOkLadoDireitoTipo3($gramatica)) {
            $ladoDireitoCheck = true;
        }

        return $ladoEsquerdoCheck && $ladoDireitoCheck;
    }

    public static function isOkLadoDireitoTipo3($gramatica) {
        //pode ocorrer ou somente um terminal 
        if (strlen($gramatica) == 1 && self::temSimboloTerminal($gramatica)) {
            return true;
        }
        
        if (strlen($gramatica) == 1 && self::temOcorrenciaSentenciaVazia($gramatica)) {
            return true;
        }

        //ou um terminal seguido de um não-terminal
        return preg_match('/^[a-z0-9]{1}[A-Z]{1}$/', $gramatica);
    }

    public static function temSimboloNaoTerminal($string) {
        return preg_match('/[A-Z]/', $string); // NT só podem ser letras maiusculas
    }

    public static function temSimboloTerminal($string) {
        return preg_match('/[a-z0-9]/', $string); // Terminais podem ser letras minusculas ou numeros
    }

    public static function temBarra($string) {
        return preg_match('/\|/', $string);
    }

    public static function temOcorrenciaSentenciaVazia($string) {
        return preg_match('/X/', $string);
    }

}
