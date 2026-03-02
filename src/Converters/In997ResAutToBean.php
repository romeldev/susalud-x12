<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In997ResAut;

class In997ResAutToBean
{
    /**
     * @param string $cadena
     * @return In997ResAut
     */
    public static function traducirEstructura997ResAut($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagAK1 = true;
        $flagAK2 = true;
        $flagAK5 = true;
        $flagAK9 = true;

        $bean = new In997ResAut();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '997_RES_AUT';
                $bean->idRemitente = isset($s1[6]) ? $s1[6] : '';
                $bean->idReceptor = isset($s1[8]) ? $s1[8] : '';
                $bean->idCorrelativo = isset($s1[13]) ? $s1[13] : '';
                $flagISA = false;
            } elseif ($segmentId === 'GS') {
                if (!$flagGS) { continue; }
                $bean->feTransaccion = isset($s1[4]) ? $s1[4] : '';
                $bean->hoTransaccion = isset($s1[5]) ? $s1[5] : '';
                $flagGS = false;
            } elseif ($segmentId === 'ST') {
                if (!$flagST) { continue; }
                $bean->idTransaccion = isset($s1[1]) ? $s1[1] : '';
                $flagST = false;
            } elseif ($segmentId === 'AK1') {
                if (!$flagAK1) { continue; }
                $bean->nuAutorizacion = isset($s1[3]) ? $s1[3] : '';
                $flagAK1 = false;
            } elseif ($segmentId === 'AK2') {
                if (!$flagAK2) { continue; }
                $bean->coSeguridad = isset($s1[3]) ? $s1[3] : '';
                $flagAK2 = false;
            } elseif ($segmentId === 'AK5') {
                if (!$flagAK5) { continue; }
                $bean->coError = isset($s1[1]) ? $s1[1] : '';
                $bean->inCoErrorEncontrado = isset($s1[2]) ? $s1[2] : '';
                $flagAK5 = false;
            } elseif ($segmentId === 'AK9') {
                if (!$flagAK9) { continue; }
                $bean->coError = isset($s1[1]) ? $s1[1] : '';
                $flagAK9 = false;
            }
        }

        return $bean;
    }
}
