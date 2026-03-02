<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InRegAfi271;
use Romeldev\SusaludX12\Beans\Detalle\InRegAfi271Detalle;

class RegAfi271ToBean
{
    /**
     * @param string $cadena
     * @return InRegAfi271
     */
    public static function traducirEstructura271($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagREF = true;
        $flagN2 = true;
        $flagN4 = true;
        $flagDTP = true;
        $flagDMG = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagDMG = 1;
        $tagHL = null;

        $bean = new InRegAfi271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_REGAFI';
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
                        $detalle = new InRegAfi271Detalle();
                        $detalle->caPaciente = isset($s1[2]) ? $s1[2] : '';
                        $detalle->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                        $detalle->noPaciente = isset($s1[4]) ? $s1[4] : '';
                        $detalle->coPaciente = isset($s1[9]) ? $s1[9] : '';
                        $detalle->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                        $bean->detalles[] = $detalle;
                        $tagNM1++;
                    } elseif ($tagNM1 === 2) {
                        $last = end($bean->detalles);
                        $last->caAseguradora = isset($s1[2]) ? $s1[2] : '';
                        $last->coAseguradora = isset($s1[9]) ? $s1[9] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 3) {
                        $last = end($bean->detalles);
                        $last->caTitular = isset($s1[2]) ? $s1[2] : '';
                        $last->apPaternoTitular = isset($s1[3]) ? $s1[3] : '';
                        $last->noTitular = isset($s1[4]) ? $s1[4] : '';
                        $last->coTitular = isset($s1[9]) ? $s1[9] : '';
                        $last->apMaternoTitular = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                    } elseif ($tagNM1 === 4) {
                        $last = end($bean->detalles);
                        $last->caContratante = isset($s1[2]) ? $s1[2] : '';
                        $last->apPaternoContratante = isset($s1[3]) ? $s1[3] : '';
                        $last->noContratante = isset($s1[4]) ? $s1[4] : '';
                        $last->apMaternoContratante = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1 = 1;
                    }
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagREF === 1 && $last) {
                    $last->tiDocumentoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuDocumentoPaciente = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 2 && $last) {
                    $last->coContratoPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 3 && $last) {
                    $last->esPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 4 && $last) {
                    $last->tiRegimenPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 5 && $last) {
                    $last->tiPlanPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 6 && $last) {
                    $last->coProductoPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 7 && $last) {
                    $last->coPlanPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 8 && $last) {
                    $last->nuCarnetPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 9 && $last) {
                    $last->coVinculoFamPaciente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 10 && $last) {
                    $last->tiDocumentoTitular = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->nuDocumentoTitular = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 11 && $last) {
                    $last->coEstablecimientoTitular = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 12 && $last) {
                    $last->tiDocumentoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $last->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $last->nuDocumentoContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF = 1;
                }
            } elseif ($segmentId === 'N2') {
                if (!$flagN2) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->apCasadaPaciente = isset($s1[1]) ? $s1[1] : '';
                }
            } elseif ($segmentId === 'N4') {
                if (!$flagN4) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($last) {
                    $last->deUbigeoPaciente = isset($s1[6]) ? $s1[6] : '';
                }
            } elseif ($segmentId === 'DMG') {
                if (!$flagN2) { break; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagDMG === 1 && $last) {
                    $last->feNacePaciente = isset($s1[2]) ? $s1[2] : '';
                    $last->gePaciente = isset($s1[3]) ? $s1[3] : '';
                    $last->coPaisPaciente = isset($s1[7]) ? $s1[7] : '';
                    $tagDMG++;
                } elseif ($tagDMG === 2 && $last) {
                    $last->feFallecidoTitular = isset($s1[2]) ? $s1[2] : '';
                    $last->coPaisTitular = isset($s1[7]) ? $s1[7] : '';
                    $tagDMG++;
                } elseif ($tagDMG === 3 && $last) {
                    $last->coPaisContratante = isset($s1[7]) ? $s1[7] : '';
                    $tagDMG = 1;
                    $tagHL = '3';
                    $tagNM1 = 1;
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                $last = !empty($bean->detalles) ? end($bean->detalles) : null;
                if ($tagDTP === 1 && $last) {
                    $last->feFallecidoPaciente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 2 && $last) {
                    $last->feIniAfiliaPaciente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 3 && $last) {
                    $last->feFinAfiliaPaciente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 4 && $last) {
                    $last->feFinAtencionPaciente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP = 1;
                }
            }
        }

        return $bean;
    }
}
