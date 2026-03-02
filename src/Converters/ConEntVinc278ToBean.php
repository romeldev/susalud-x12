<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConEntVinc278;

class ConEntVinc278ToBean
{
    /**
     * @param string $cadena
     * @return InConEntVinc278
     */
    public static function traducirEstructura271($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $tagREF = 1;
        $tagHL = null;

        $bean = new InConEntVinc278();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '278_CON_ENT_VINC';
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
            } elseif ($segmentId === 'BHT') {
                if (!$flagBHT) { continue; }
                $bean->tiFinalidad = isset($s1[2]) ? $s1[2] : '';
                $flagBHT = false;
            } elseif ($segmentId === 'HL') {
                $tagHL = isset($s1[1]) ? trim($s1[1]) : null;
            } elseif ($segmentId === 'NM1') {
                if (!$flagNM1) { continue; }
                if ($tagHL === '1') {
                    $bean->caIPRESS = isset($s1[2]) ? $s1[2] : '';
                    $bean->noIPRESS = isset($s1[4]) ? $s1[4] : '';
                    $flagNM1 = false;
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                if ($tagREF === 1) {
                    $bean->tiDoIPRESS = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuRucIPRESS = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $flagREF = false;
                }
            }
        }

        return $bean;
    }
}
