<?php

namespace Romeldev\SusaludX12\Support;

class TransaccionUtil
{
    /**
     * Genera un número aleatorio de la longitud especificada.
     *
     * @param int $iLimite
     * @param int $iLongitud
     * @return string
     */
    public static function generarAleatorio($iLimite, $iLongitud)
    {
        do {
            $sRetorno = (string) mt_rand(0, $iLimite);
        } while (strlen($sRetorno) !== $iLongitud);

        return $sRetorno;
    }

    /**
     * Genera un número aleatorio para ST control.
     *
     * @param int $iLimite
     * @param int $iLongitud
     * @return string
     */
    public static function generarAleatorioST($iLimite, $iLongitud)
    {
        do {
            $sRetorno = (string) mt_rand(0, $iLimite);
        } while (strlen($sRetorno) !== $iLongitud);

        return $sRetorno;
    }
}
