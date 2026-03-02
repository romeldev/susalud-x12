<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InResEntVinc278;

class ResEntVinc278ToBean
{
    /**
     * @param string $cadena
     * @return InResEntVinc278
     */
    public static function traducirEstructura271($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagCRC = true;
        $flagMSG = true;

        $bean = new InResEntVinc278();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '278_RES_ENT_VINC';
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
            } elseif ($segmentId === 'CRC') {
                if (!$flagCRC) { continue; }
                $bean->respuesta = isset($s1[2]) ? $s1[2] : '';
                $flagCRC = false;
            } elseif ($segmentId === 'MSG') {
                if (!$flagMSG) { continue; }
                $bean->msgRespuesta = isset($s1[1]) ? $s1[1] : '';
                $flagMSG = false;
            }
        }

        return $bean;
    }
}
