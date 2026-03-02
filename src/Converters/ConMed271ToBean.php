<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConMed271;
use Romeldev\SusaludX12\Beans\Detalle\InConMed271Detalle;

class ConMed271ToBean
{
    /**
     * @param string $cadena
     * @return InConMed271
     */
    public static function traducirEstructura271($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagDTP = true;
        $flagEB = true;
        $flagMSG = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagEB = 1;
        $tagMSG = 1;
        $tagHL = null;

        $bean = new InConMed271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_CON_MED';
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
                    $bean->caRemitente = isset($s1[2]) ? $s1[2] : '';
                } elseif ($tagHL === '2') {
                    $bean->caReceptor = isset($s1[2]) ? $s1[2] : '';
                    $bean->nuRucReceptor = isset($s1[9]) ? $s1[9] : '';
                } elseif ($tagHL === '3' && $tagNM1 === 1) {
                    $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                    $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                    $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                    $bean->coPaciente = isset($s1[9]) ? $s1[9] : '';
                    $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                if ($tagREF === 1) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->dePreexistencia = isset($s1[3]) ? $s1[3] : '';
                    }
                    $tagREF = 1;
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                if ($tagDTP === 1) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->tiEspera = isset($s1[3]) ? $s1[3] : '';
                    }
                    $tagDTP = 1;
                }
            } elseif ($segmentId === 'EB') {
                if (!$flagEB) { continue; }
                if ($tagHL === '3') {
                    if ($tagEB === 1) {
                        $detalle = new InConMed271Detalle();
                        $detalle->coSeCIE10 = isset($s1[3]) ? $s1[3] : '';
                        if (isset($s1[13])) {
                            $eb13 = explode(':', $s1[13]);
                            $detalle->coRestriccion = isset($eb13[1]) ? $eb13[1] : '';
                        }
                        $bean->detalles[] = $detalle;
                        $tagEB++;
                    } elseif ($tagEB === 2) {
                        $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                        if ($last) {
                            $last->esCobertura = isset($s1[1]) ? $s1[1] : '';
                            $last->moDiagnostico = isset($s1[8]) ? $s1[8] : '';
                        }
                        $tagEB = 1;
                    }
                }
            } elseif ($segmentId === 'MSG') {
                if (!$flagMSG) { continue; }
                if ($tagMSG === 1) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->msgObsPr = isset($s1[1]) ? $s1[1] : '';
                        $last->idFuenteRE = isset($s1[3]) ? $s1[3] : '';
                    }
                    $tagMSG = 1;
                }
            }
        }

        return $bean;
    }
}
