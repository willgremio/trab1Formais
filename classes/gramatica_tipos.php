<?php

class GramaticaTipos {

    public function getTipo($gramaticas) {
        if ($this->isTipo3($gramaticas)) {
            return 'Grámatica Regular ou Tipo 3'; //feito regra. fazer testes
        }

        if ($this->isTipo2($gramaticas)) {
            return 'Grámatica Livre de Contexto ou Tipo 2';
        }

        if ($this->isTipo1($gramaticas)) {
            return 'Grámatica Sensível ao Contexto ou Tipo 1';
        }

        if ($this->isTipo0($gramaticas)) {
            return 'Grámatica Irrestrita ou Tipo 0';
        }
    }

    public function isTipo0($gramatica) {
        //regra
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
