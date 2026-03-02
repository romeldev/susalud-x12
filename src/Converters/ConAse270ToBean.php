<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConAse270;

class ConAse270ToBean
{
    /**
     * @param string $cadena
     * @return InConAse270
     */
    public static function traducirEstructura270($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagPRV = true;
        $flagREF = true;
        $flagDTP = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagHL = null;

        $bean = new InConAse270();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '270_CON_ASE';
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
                    $bean->nuRucRemitente = isset($s1[9]) ? $s1[9] : '';
                } elseif ($tagHL === '2') {
                    $bean->caReceptor = isset($s1[2]) ? $s1[2] : '';
                } elseif ($tagHL === '3') {
                    if ($tagNM1 === 1) {
                        $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                        $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                        $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                        $bean->coAfPaciente = isset($s1[9]) ? $s1[9] : '';
                        $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 2) {
                        $bean->tiCaContratante = isset($s1[2]) ? $s1[2] : '';
                        $bean->noPaContratante = isset($s1[3]) ? $s1[3] : '';
                        $bean->noContratante = isset($s1[4]) ? $s1[4] : '';
                        $bean->noMaContratante = isset($s1[12]) ? $s1[12] : '';
                        $flagNM1 = false;
                    }
                }
            } elseif ($segmentId === 'PRV') {
                if (!$flagPRV) { continue; }
                $bean->txRequest = isset($s1[3]) ? $s1[3] : '';
                $flagPRV = false;
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { break; }
                if ($tagREF === 1) {
                    $bean->tiDocumento = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 2) {
                    $bean->nuDocumento = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 3) {
                    $bean->coProducto = isset($s1[2]) ? $s1[2] : '';
                    $bean->deProducto = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->coInProducto = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 4) {
                    $bean->nuCobertura = isset($s1[2]) ? $s1[2] : '';
                    $bean->deCobertura = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->caServicio = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->coCalservicio = isset($ref04[1]) ? $ref04[1] : '';
                        $bean->beMaxInicial = isset($ref04[3]) ? $ref04[3] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 5) {
                    $bean->coTiCobertura = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->coSuTiCobertura = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 6) {
                    $bean->coAplicativoTx = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7) {
                    $bean->coEspecialidad = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 8) {
                    $bean->coParentesco = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 9) {
                    $bean->nuPlan = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuAutOrigen = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 10) {
                    $bean->tiAccidente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 11) {
                    $bean->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->coReContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $flagREF = false;
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { break; }
                if ($tagDTP === 1) {
                    $bean->feAccidente = isset($s1[3]) ? $s1[3] : '';
                }
            }
        }

        return $bean;
    }
}
