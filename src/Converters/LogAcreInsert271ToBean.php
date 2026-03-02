<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InLogAcreInsert271;

class LogAcreInsert271ToBean
{
    /**
     * @param string $cadena
     * @return InLogAcreInsert271
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
        $flagDMG = true;
        $flagEB = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagDMG = 1;
        $tagEB = 1;
        $tagHL = null;

        $bean = new InLogAcreInsert271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_LOG_ACRE_INSERT';
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
                        $bean->caContratante = isset($s1[2]) ? $s1[2] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 3) {
                        $bean->coAfiliadoTitular = isset($s1[9]) ? $s1[9] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 4) {
                        $bean->caResponsableAut = isset($s1[2]) ? $s1[2] : '';
                        $bean->noPaResponsableAut = isset($s1[3]) ? $s1[3] : '';
                        $bean->noResponsableAut = isset($s1[4]) ? $s1[4] : '';
                        $bean->noMaResponsableAut = isset($s1[12]) ? $s1[12] : '';
                        $flagNM1 = false;
                    }
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                if ($tagREF === 1) {
                    $bean->coEsPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 2) {
                    $bean->tiDoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDoPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 3) {
                    $bean->nuContratoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->coTiPolizaAfiliacion = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 4) {
                    $bean->coProducto = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 5) {
                    $bean->nuPlan = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 6) {
                    $bean->coParentesco = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7) {
                    $bean->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->rucContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 8) {
                    $bean->tiDoResponsableAut = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDoResponsableAut = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 9) {
                    $bean->nuAutorizacion = isset($s1[2]) ? $s1[2] : '';
                    $flagREF = false;
                }
            } elseif ($segmentId === 'DMG') {
                if (!$flagDMG) { continue; }
                if ($tagDMG === 1) {
                    $bean->feNacimiento = isset($s1[2]) ? $s1[2] : '';
                    $bean->genero = isset($s1[3]) ? $s1[3] : '';
                    $tagDMG++;
                } elseif ($tagDMG === 2) {
                    $bean->feHoAutorizacion = isset($s1[2]) ? $s1[2] : '';
                    $flagDMG = false;
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                if ($tagDTP === 1) {
                    $bean->feIniVigencia = isset($s1[3]) ? $s1[3] : '';
                    $flagDTP = false;
                }
            } elseif ($segmentId === 'EB') {
                if (!$flagEB) { continue; }
                if ($tagEB === 1) {
                    $bean->nuCobertura = isset($s1[2]) ? $s1[2] : '';
                    $bean->deCobertura = isset($s1[5]) ? $s1[5] : '';
                    $tagEB++;
                } elseif ($tagEB === 2) {
                    $bean->beMaxInicial = isset($s1[7]) ? $s1[7] : '';
                    $tagEB++;
                } elseif ($tagEB === 3) {
                    $bean->coPagoFijo = isset($s1[7]) ? $s1[7] : '';
                    $tagEB++;
                } elseif ($tagEB === 4) {
                    $bean->coPagoVariable = isset($s1[8]) ? $s1[8] : '';
                    $tagEB++;
                } elseif ($tagEB === 5) {
                    $bean->flagCartaGarantia = isset($s1[1]) ? $s1[1] : '';
                    $bean->deFlagCartaGarantia = isset($s1[5]) ? $s1[5] : '';
                    $flagEB = false;
                }
            }
        }

        return $bean;
    }
}
