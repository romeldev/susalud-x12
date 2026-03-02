<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConCod271;
use Romeldev\SusaludX12\Beans\Detalle\InConCod271Detalle;

class ConCod271ToBean
{
    /**
     * @param string $cadena
     * @return InConCod271
     */
    public static function traducirEstructura271($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagDMG = true;
        $flagDTP = true;
        $flagEB = true;
        $flagMSG = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagEB = 1;
        $tagMSG = 1;
        $tagHL = null;

        $bean = new InConCod271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_CON_COD';
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
                        $bean->tiCaContratante = isset($s1[2]) ? $s1[2] : '';
                        $bean->noPaContratante = isset($s1[3]) ? $s1[3] : '';
                        $bean->noContratante = isset($s1[4]) ? $s1[4] : '';
                        $bean->noMaContratante = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 3) {
                        $bean->caTitular = isset($s1[2]) ? $s1[2] : '';
                        $bean->noPaTitular = isset($s1[3]) ? $s1[3] : '';
                        $bean->noTitular = isset($s1[4]) ? $s1[4] : '';
                        $bean->coAfTitular = isset($s1[9]) ? $s1[9] : '';
                        $bean->noMaTitular = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1 = 2;
                    }
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                if ($tagREF === 1) {
                    $bean->userRemitente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->passRemitente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 2) {
                    $bean->coEsPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 3) {
                    $bean->tiDoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDoPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 4) {
                    $bean->nuIdenPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 5) {
                    $bean->nuContratoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuPoliza = isset($ref04[1]) ? $ref04[1] : '';
                        $bean->nuCertificado = isset($ref04[3]) ? $ref04[3] : '';
                        $bean->coTiPoliza = isset($ref04[5]) ? $ref04[5] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 6) {
                    $bean->coProducto = isset($s1[2]) ? $s1[2] : '';
                    $bean->deProducto = isset($s1[3]) ? $s1[3] : '';
                    $tagREF++;
                } elseif ($tagREF === 7) {
                    $bean->nuPlan = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->tiPlanSalud = isset($ref04[1]) ? $ref04[1] : '';
                        $bean->coMoneda = isset($ref04[3]) ? $ref04[3] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 8) {
                    $bean->coParentesco = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 9) {
                    $bean->soBeneficio = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuSoBeneficio = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 10) {
                    $bean->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->coReContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 11) {
                    $bean->tiDoTitular = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuDoTitular = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 12) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->coTiCobertura = isset($s1[2]) ? $s1[2] : '';
                        if (isset($s1[4])) {
                            $ref04 = explode(':', $s1[4]);
                            $last->coSubTiCobertura = isset($ref04[1]) ? $ref04[1] : '';
                        }
                    }
                    $tagREF = 12;
                }
            } elseif ($segmentId === 'DMG') {
                if (!$flagDMG) { continue; }
                if ($tagHL === '3') {
                    $bean->feNacimiento = isset($s1[2]) ? $s1[2] : '';
                    $bean->genero = isset($s1[3]) ? $s1[3] : '';
                    $bean->esMarital = isset($s1[4]) ? $s1[4] : '';
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { break; }
                if ($tagDTP === 1) {
                    $bean->feUpFoto = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 2) {
                    $bean->feIniVigencia = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 3) {
                    $bean->feFinVigencia = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 4) {
                    $bean->feInsTitular = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 5) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->feFinCarencia = isset($s1[3]) ? $s1[3] : '';
                    }
                    $tagDTP++;
                } elseif ($tagDTP === 6) {
                    $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($last) {
                        $last->feFinEspera = isset($s1[3]) ? $s1[3] : '';
                    }
                    $tagDTP = 5;
                }
            } elseif ($segmentId === 'EB') {
                if (!$flagEB) { continue; }
                if ($tagEB === 1) {
                    $detalle = new InConCod271Detalle();
                    $detalle->infBeneficio = isset($s1[1]) ? $s1[1] : '';
                    $detalle->nuCobertura = isset($s1[5]) ? $s1[5] : '';
                    $detalle->beMaxInicial = isset($s1[7]) ? $s1[7] : '';
                    $detalle->moCobertura = isset($s1[8]) ? $s1[8] : '';
                    $detalle->coInRestriccion = isset($s1[9]) ? $s1[9] : '';
                    $detalle->canServicio = isset($s1[10]) ? $s1[10] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $detalle->idProducto = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $bean->detalles[] = $detalle;
                    $tagEB++;
                } elseif ($tagEB === 2) {
                    $last = end($bean->detalles);
                    $last->coTiMoneda = isset($s1[5]) ? $s1[5] : '';
                    $last->coPagoFijo = isset($s1[7]) ? $s1[7] : '';
                    $last->coCalServicio = isset($s1[9]) ? $s1[9] : '';
                    $last->canCalServicio = isset($s1[10]) ? $s1[10] : '';
                    $tagEB++;
                } elseif ($tagEB === 3) {
                    $last = end($bean->detalles);
                    $last->coPagoVariable = isset($s1[8]) ? $s1[8] : '';
                    $tagEB++;
                } elseif ($tagEB === 4) {
                    $last = end($bean->detalles);
                    $last->flagCaGarantia = isset($s1[1]) ? $s1[1] : '';
                    $last->deflagCaGarantia = isset($s1[5]) ? $s1[5] : '';
                    $tagEB = 1;
                }
            } elseif ($segmentId === 'MSG') {
                if (!$flagMSG) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagMSG === 1 && $last) {
                    $last->msgObs = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 2 && $last) {
                    $last->msgConEspeciales = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG = 1;
                }
            }
        }

        return $bean;
    }
}
