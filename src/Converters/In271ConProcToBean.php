<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConProc271;
use Romeldev\SusaludX12\Beans\Detalle\InConProc271Detalle;

class In271ConProcToBean
{
    /**
     * @param string $cadena
     * @return InConProc271
     */
    public static function traducirEstructura271ConProc($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagEB = true;
        $flagHSD = true;
        $flagDTP = true;
        $flagMSG = true;
        $tagHL = null;
        $tagMSG = 1;
        $tagREF = 1;
        $tagEB = 1;
        $tagHSD = 1;
        $tagDTP = 1;

        $bean = new InConProc271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_CON_PROC';
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
                } elseif ($tagHL === '3') {
                    $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                    $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                    $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                    $bean->coAfPaciente = isset($s1[9]) ? $s1[9] : '';
                    $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                    $flagNM1 = false;
                }
            } elseif ($segmentId === 'EB') {
                if (!$flagEB) { continue; }
                if ($tagEB === 1) {
                    $detalle = new InConProc271Detalle();
                    $detalle->coInProcedimiento = isset($s1[9]) ? $s1[9] : '';
                    $bean->detalles[] = $detalle;
                    $tagEB++;
                } elseif ($tagEB === 2) {
                    $last = end($bean->detalles);
                    $last->coInRestriccion = isset($s1[9]) ? $s1[9] : '';
                    $tagEB++;
                } elseif ($tagEB === 3) {
                    $last = end($bean->detalles);
                    $last->coProcedimiento = isset($s1[3]) ? $s1[3] : '';
                    $last->imDeducible = isset($s1[7]) ? $s1[7] : '';
                    $last->poCuExDecimal = isset($s1[8]) ? $s1[8] : '';
                    $last->nuFrecuencia = isset($s1[10]) ? $s1[10] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $last->coSexo = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $tagEB++;
                } elseif ($tagEB === 4) {
                    $last = end($bean->detalles);
                    $last->coTiEspera = isset($s1[3]) ? $s1[3] : '';
                    $tagEB++;
                } elseif ($tagEB === 5) {
                    $last = end($bean->detalles);
                    $last->coExCarencia = isset($s1[3]) ? $s1[3] : '';
                    $tagEB = 1;
                }
            } elseif ($segmentId === 'HSD') {
                if (!$flagHSD) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->tiNuDias = isset($s1[2]) ? $s1[2] : '';
                }
                $tagHSD = 1;
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->feFinVigencia = isset($s1[3]) ? $s1[3] : '';
                }
                $tagDTP = 1;
            } elseif ($segmentId === 'MSG') {
                if (!$flagMSG) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagMSG === 1 && $last) {
                    $last->teMsgObservacion = isset($s1[1]) ? $s1[1] : '';
                    $last->idFuentePE = isset($s1[3]) ? $s1[3] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 2 && $last) {
                    $last->teMsgTiEspera = isset($s1[1]) ? $s1[1] : '';
                    $last->idFuenteTE = isset($s1[3]) ? $s1[3] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 3 && $last) {
                    $last->teMsgExCarencia = isset($s1[1]) ? $s1[1] : '';
                    $last->idFuenteEC = isset($s1[3]) ? $s1[3] : '';
                    $tagMSG = 1;
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { break; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagREF === 1 && $last) {
                    $last->deTiEspera = isset($s1[3]) ? $s1[3] : '';
                    $tagREF++;
                } elseif ($tagREF === 2 && $last) {
                    $last->deExCarencia = isset($s1[3]) ? $s1[3] : '';
                    $tagREF = 1;
                }
            }
        }

        return $bean;
    }
}
