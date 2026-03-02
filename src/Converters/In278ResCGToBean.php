<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In278ResCG;
use Romeldev\SusaludX12\Beans\Detalle\In278ResCGDetalle;

class In278ResCGToBean
{
    /**
     * @param string $cadena
     * @return In278ResCG
     */
    public static function traducirEstructura278Res($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagINS = true;
        $flagDTP = true;
        $tagHL = null;
        $tagREF = 1;
        $tagNM1 = 1;

        $bean = new In278ResCG();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '278_RES_CG';
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
                        $detalle = new In278ResCGDetalle();
                        $detalle->caPaciente = isset($s1[2]) ? $s1[2] : '';
                        $detalle->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                        $detalle->noPaciente = isset($s1[4]) ? $s1[4] : '';
                        $detalle->coAfPaciente = isset($s1[9]) ? $s1[9] : '';
                        $detalle->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                        $bean->detalles[] = $detalle;
                        $tagNM1++;
                    } elseif ($tagNM1 === 2) {
                        $last = end($bean->detalles);
                        $last->tiCaContratante = isset($s1[2]) ? $s1[2] : '';
                        $last->noPaContratante = isset($s1[3]) ? $s1[3] : '';
                        $last->noContratante = isset($s1[4]) ? $s1[4] : '';
                        $last->noMaContratante = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1 = 1;
                        $tagHL = '3';
                    }
                }
            } elseif ($segmentId === 'INS') {
                if (!$flagINS) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->monPago = isset($s1[17]) ? $s1[17] : '';
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->feCarGarantia = isset($s1[3]) ? $s1[3] : '';
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { break; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagREF === 1 && $last) {
                    $last->coTiDoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuDoPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 2 && $last) {
                    $last->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->idCaReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $last->nuCaReContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 3 && $last) {
                    $last->deCarGarantia = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuSoCarGarantia = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 4 && $last) {
                    $last->nuCarGarantia = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->veCarGarantia = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 5 && $last) {
                    $last->esCarGarantia = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 6 && $last) {
                    $last->coProducto = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7 && $last) {
                    $last->coProcedimiento = isset($s1[2]) ? $s1[2] : '';
                    $last->deProcedimiento = isset($s1[3]) ? $s1[3] : '';
                    $tagREF++;
                } elseif ($tagREF === 8 && $last) {
                    $last->nuPlan = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->tiPlanSalud = isset($ref04[1]) ? $ref04[1] : '';
                        $last->coMoneda = isset($ref04[3]) ? $ref04[3] : '';
                    }
                    $tagREF = 1;
                }
            }
        }

        return $bean;
    }
}
