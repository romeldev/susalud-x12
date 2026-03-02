<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InRegAfi270;

class RegAfi270ToBean
{
    /**
     * Convierte una trama X12 a un bean InRegAfi270.
     *
     * @param string $cadena
     * @return InRegAfi270
     */
    public static function traducirEstructura270($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $tagREF = 1;
        $tagHL = null;

        $bean = new InRegAfi270();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);

            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) {
                    continue;
                }
                $bean->noTransaccion = '270_REGAFI';
                $bean->idRemitente = isset($s1[6]) ? $s1[6] : '';
                $bean->idReceptor = isset($s1[8]) ? $s1[8] : '';
                $bean->idCorrelativo = isset($s1[13]) ? $s1[13] : '';
                $flagISA = false;
            } elseif ($segmentId === 'GS') {
                if (!$flagGS) {
                    continue;
                }
                $bean->feTransaccion = isset($s1[4]) ? $s1[4] : '';
                $bean->hoTransaccion = isset($s1[5]) ? $s1[5] : '';
                $flagGS = false;
            } elseif ($segmentId === 'ST') {
                if (!$flagST) {
                    continue;
                }
                $bean->idTransaccion = isset($s1[1]) ? $s1[1] : '';
                $flagST = false;
            } elseif ($segmentId === 'BHT') {
                if (!$flagBHT) {
                    continue;
                }
                $bean->tiFinalidad = isset($s1[2]) ? $s1[2] : '';
                $flagBHT = false;
            } elseif ($segmentId === 'HL') {
                $tagHL = isset($s1[1]) ? trim($s1[1]) : null;
            } elseif ($segmentId === 'NM1') {
                if (!$flagNM1) {
                    continue;
                }
                if ($tagHL === '1') {
                    $bean->caRemitente = isset($s1[2]) ? $s1[2] : '';
                    $bean->nuRucRemitente = isset($s1[9]) ? $s1[9] : '';
                } elseif ($tagHL === '2') {
                    $bean->caReceptor = isset($s1[2]) ? $s1[2] : '';
                } elseif ($tagHL === '3') {
                    $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                    $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                    $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                    $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                    $flagNM1 = false;
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) {
                    break;
                }
                if ($tagREF === 1) {
                    $bean->tiDocumento = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDocumento = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $flagREF = false;
                }
            }
        }

        return $bean;
    }
}
