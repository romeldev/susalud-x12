<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConNom271;
use Romeldev\SusaludX12\Beans\Detalle\InConNom271Detalle;

class ConNom271ToBean
{
    /**
     * @param string $cadena
     * @return InConNom271
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
        $tagREF = 1;
        $tagNM1 = 1;
        $tagHL = null;

        $bean = new InConNom271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_CON_NOM';
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
                        $detalle = new InConNom271Detalle();
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
                    }
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagREF === 1 && $last) {
                    $last->coEsPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 2 && $last) {
                    $last->tiDoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuDoPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 3 && $last) {
                    $last->nuContratoPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 4 && $last) {
                    $last->coProducto = isset($s1[2]) ? $s1[2] : '';
                    $last->coDescripcion = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuSCTR = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 5 && $last) {
                    $last->coParentesco = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 6 && $last) {
                    $last->nuPlan = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7 && $last) {
                    $last->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $last->coReContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF = 1;
                }
            } elseif ($segmentId === 'DMG') {
                if (!$flagDMG) { break; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->feNacimiento = isset($s1[2]) ? $s1[2] : '';
                    $last->genero = isset($s1[3]) ? $s1[3] : '';
                    $last->esMarital = isset($s1[4]) ? $s1[4] : '';
                }
            }
        }

        return $bean;
    }
}
