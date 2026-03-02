<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ResSctr;
use Romeldev\SusaludX12\Beans\Detalle\In271ResSctrDetalle;

class In271ResSctrToBean
{
    /**
     * @param string $cadena
     * @return In271ResSctr
     */
    public static function traducirEstructura271ResSctr($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagDTP = true;
        $tagHL = null;
        $tagDTP = 1;
        $tagREF = 1;
        $tagNM1 = 1;

        $bean = new In271ResSctr();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_RES_SCTR';
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
                    if ($tagNM1 === 1) {
                        $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                        $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                        $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                        $bean->coAfPaciente = isset($s1[9]) ? $s1[9] : '';
                        $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 2) {
                        $detalle = new In271ResSctrDetalle();
                        $detalle->tiCaContratante = isset($s1[2]) ? $s1[2] : '';
                        $detalle->noEmApPaContratante = isset($s1[3]) ? $s1[3] : '';
                        $bean->detalles[] = $detalle;
                        $tagNM1++;
                    } elseif ($tagNM1 === 3) {
                        $last = end($bean->detalles);
                        $last->tiCaLuAtencion = isset($s1[2]) ? $s1[2] : '';
                        $last->noEmLuAtencion = isset($s1[3]) ? $s1[3] : '';
                        $tagNM1 = 2;
                    }
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagDTP === 1 && $last) {
                    $last->feAfiliacion = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 2 && $last) {
                    $last->feOcAccidente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP = 1;
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { break; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagREF === 1) {
                    $bean->coTiDoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDocPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 2 && $last) {
                    $last->coEmContratante = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 3 && $last) {
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->idCaReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $last->reIdContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 4 && $last) {
                    $last->coEmReLuAtencion = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 5 && $last) {
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->idCaReLuAtencion = isset($ref04[0]) ? $ref04[0] : '';
                        $last->reIdLuAtencion = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 6 && $last) {
                    $last->coLuAtencion = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7 && $last) {
                    $last->deTiAccidente = isset($s1[3]) ? $s1[3] : '';
                    $tagREF = 2;
                }
            }
        }

        return $bean;
    }
}
