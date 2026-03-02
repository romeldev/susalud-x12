<?php

namespace Romeldev\SusaludX12\Support;

class ManagerUtil
{
    /**
     * Formats a DateTime object to string "yyyyMMdd".
     *
     * @param \DateTime $fech
     * @return string
     */
    public static function DateToString($fech)
    {
        return $fech->format('Ymd');
    }

    /**
     * Formats a DateTime object to string "yyyyMMddHHmmss".
     *
     * @param \DateTime $fech
     * @return string
     */
    public static function DateToStringFechaHora($fech)
    {
        return $fech->format('YmdHis');
    }

    /**
     * Validates that a string contains only word characters (letters including N with tilde, and space).
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaCaracterPalabra($palabra)
    {
        $palabra = strtoupper($palabra);
        $validos = "ABCDEFGHIJKLMN\xc3\x91OPQRSTUVWXYZ ";
        $len = mb_strlen($palabra, 'UTF-8');
        for ($i = 0; $i < $len; $i++) {
            $c = mb_substr($palabra, $i, 1, 'UTF-8');
            if (mb_strpos($validos, $c, 0, 'UTF-8') === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Validates that a user string is correct (exactly 8 digits).
     *
     * @param string $usuario
     * @return bool
     */
    public static function cadenaUsuarioCorrecto($usuario)
    {
        $len = strlen($usuario);
        if ($len !== 8) {
            return false;
        }
        $cCaracter = self::validaSoloDigito($usuario);
        return $cCaracter === '0';
    }

    /**
     * Validates that a digit string has exactly 8 characters.
     *
     * @param string $digitos
     * @return bool
     */
    public static function validaCantidadDigito($digitos)
    {
        $len = strlen($digitos);
        return $len === 8;
    }

    /**
     * Validates that a string contains only digits and spaces.
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaDigitoEspacio($palabra)
    {
        $palabra = trim($palabra);
        $validos = '0123456789 ';
        $len = strlen($palabra);
        for ($i = 0; $i < $len; $i++) {
            $c = $palabra[$i];
            if (strpos($validos, $c) === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Validates that a string contains only '1' and spaces.
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaUnoEspacio($palabra)
    {
        $palabra = trim($palabra);
        $validos = '1 ';
        $len = strlen($palabra);
        for ($i = 0; $i < $len; $i++) {
            $c = $palabra[$i];
            if (strpos($validos, $c) === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Validates that a string contains only digits (0-9).
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaSoloDigito($palabra)
    {
        $palabra = trim($palabra);
        $validos = '0123456789';
        $len = strlen($palabra);
        for ($i = 0; $i < $len; $i++) {
            $c = $palabra[$i];
            if (strpos($validos, $c) === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Validates that a string contains only decimals (digits and dot).
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaDecimales($palabra)
    {
        $palabra = trim($palabra);
        $validos = '0123456789.';
        $len = strlen($palabra);
        for ($i = 0; $i < $len; $i++) {
            $c = $palabra[$i];
            if (strpos($validos, $c) === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Validates that a string is alphanumeric (letters, digits, space).
     * Returns '0' if valid, otherwise returns the first invalid character.
     *
     * @param string $palabra
     * @return string
     */
    public static function validaAlfanumerico($palabra)
    {
        $palabra = strtoupper($palabra);
        $validos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 ';
        $len = strlen($palabra);
        for ($i = 0; $i < $len; $i++) {
            $c = $palabra[$i];
            if (strpos($validos, $c) === false) {
                return $c;
            }
        }
        return '0';
    }

    /**
     * Sorts a numeric string by its individual digit characters, removing duplicates.
     * Example: "321" becomes "123", "2211" becomes "12".
     *
     * @param string $listaNumerica
     * @return string
     */
    public static function ordenaListaNumerica($listaNumerica)
    {
        $subTipoConsulta = $listaNumerica;
        $len = strlen($subTipoConsulta);
        $aSubTipo = array();
        for ($i = 0; $i < $len; $i++) {
            $aSubTipo[$i] = substr($subTipoConsulta, $i, 1);
        }

        // Selection sort
        $count = count($aSubTipo);
        for ($i = 0; $i < $count - 1; $i++) {
            $menor = $aSubTipo[$i];
            for ($j = $i + 1; $j < $count; $j++) {
                if ((int)$menor > (int)$aSubTipo[$j]) {
                    $mayor = $menor;
                    $menor = $aSubTipo[$j];
                    $aSubTipo[$j] = $mayor;
                }
            }
            $aSubTipo[$i] = $menor;
        }

        // Build result removing consecutive duplicates
        $cadena = '';
        for ($i = 0; $i < $count - 1; $i++) {
            $valor = $aSubTipo[$i];
            for ($j = $i + 1; $j < $count; $j++) {
                if ((int)$valor !== (int)$aSubTipo[$j]) {
                    $cadena .= $valor;
                    $j = $count;
                } else {
                    $j = $count;
                }
            }
        }

        if ($count === 1) {
            $cadena = $aSubTipo[0];
        } else {
            $cadena .= $aSubTipo[$count - 1];
        }

        return $cadena;
    }

    /**
     * Verifies how many characters from listaValidar exist in listaCompleta
     * for the given tipoConsulta.
     *
     * @param array $listaCompleta Two-dimensional array (array of [tipoConsulta, valor])
     * @param string $listaValidar String of characters to validate
     * @param string $tipoConsulta Type of query to match
     * @param string $tipoFicha Type of ficha (unused in logic but kept for signature compatibility)
     * @return int
     */
    public static function verificaLista($listaCompleta, $listaValidar, $tipoConsulta, $tipoFicha)
    {
        $aConsulta = $listaCompleta;
        $subConsultas = $listaValidar;
        $tipConsulta = $tipoConsulta;
        $iExiste = 0;

        $lenSub = strlen($subConsultas);
        $lenConsulta = count($aConsulta);

        for ($j = 0; $j < $lenSub; $j++) {
            $sCaracter = substr($subConsultas, $j, 1);
            for ($i = 0; $i < $lenConsulta; $i++) {
                if ($aConsulta[$i][0] === $tipConsulta && $aConsulta[$i][1] === $sCaracter) {
                    $iExiste++;
                }
            }
        }

        return $iExiste;
    }

    /**
     * Splits a string into an array of individual characters.
     *
     * @param string $listaCadena
     * @return array
     */
    public static function listaConsulta($listaCadena)
    {
        $subTipoConsulta = trim($listaCadena);
        $len = strlen($subTipoConsulta);
        $aSubTipo = array();
        for ($i = 0; $i < $len; $i++) {
            $aSubTipo[$i] = substr($subTipoConsulta, $i, 1);
        }
        return $aSubTipo;
    }

    /**
     * Counts how many rows in a two-dimensional array have their first element
     * matching the given value.
     *
     * @param array $listaCompleta Two-dimensional array (array of [valor, ...])
     * @param string $valor Value to search for
     * @return int
     */
    public static function validaConsulta($listaCompleta, $valor)
    {
        $aConsulta = $listaCompleta;
        $iExiste = 0;
        $len = count($aConsulta);
        for ($i = 0; $i < $len; $i++) {
            if ($aConsulta[$i][0] === $valor) {
                $iExiste++;
            }
        }
        return $iExiste;
    }

    /**
     * Validates a date string against a format.
     * The Java format "YYYYmmdd" maps to PHP "Ymd".
     *
     * @param string $sFecha
     * @param string $sFormato
     * @return bool
     */
    public static function validaFecha($sFecha, $sFormato)
    {
        // Map Java-style format to PHP
        $phpFormato = str_replace(
            ['YYYY', 'yyyy', 'mm', 'dd', 'HH', 'ss'],
            ['Y', 'Y', 'm', 'd', 'H', 's'],
            $sFormato
        );

        $date = \DateTime::createFromFormat($phpFormato, $sFecha);
        if ($date === false) {
            return false;
        }
        return $date->format($phpFormato) === $sFecha;
    }

    /**
     * Removes special characters (accented letters, <, >, &) replacing them
     * with their ASCII equivalents.
     *
     * @param string $input
     * @return string
     */
    public static function removerCaractEspecial($input)
    {
        $original = array(
            "\xC3\xA1", "\xC3\xA0", "\xC3\xA4", // a acute, a grave, a diaeresis
            "\xC3\xA9", "\xC3\xA8", "\xC3\xAB", // e acute, e grave, e diaeresis
            "\xC3\xAD", "\xC3\xAC", "\xC3\xAF", // i acute, i grave, i diaeresis
            "\xC3\xB3", "\xC3\xB2", "\xC3\xB6", // o acute, o grave, o diaeresis
            "\xC3\xBA", "\xC3\xB9", "u",         // u acute, u grave, u (plain)
            "\xC3\xB1",                            // n tilde
            "<", ">", "&",                         // special chars
            "\xC3\x81", "\xC3\x80", "\xC3\x84", // A acute, A grave, A diaeresis
            "\xC3\x89", "\xC3\x88", "\xC3\x8B", // E acute, E grave, E diaeresis
            "\xC3\x8D", "\xC3\x8C", "\xC3\x8F", // I acute, I grave, I diaeresis
            "\xC3\x93", "\xC3\x92", "\xC3\x96", // O acute, O grave, O diaeresis
            "\xC3\x9A", "\xC3\x99", "\xC3\x9C", // U acute, U grave, U diaeresis
            "\xC3\x91",                            // N tilde
            "\xC3\xA7", "\xC3\x87"               // c cedilla, C cedilla
        );

        $ascii = array(
            'a', 'a', 'a',
            'e', 'e', 'e',
            'i', 'i', 'i',
            'o', 'o', 'o',
            'u', 'u', 'u',
            '#',
            ' ', ' ', ' ',
            'A', 'A', 'A',
            'E', 'E', 'E',
            'I', 'I', 'I',
            'O', 'O', 'O',
            'U', 'U', 'U',
            '#',
            'c', 'C'
        );

        $output = str_replace($original, $ascii, $input);
        return $output;
    }
}
