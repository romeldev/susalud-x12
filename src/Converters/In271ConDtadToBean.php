<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ConDtad;

class In271ConDtadToBean
{
    /**
     * @param string $cadena
     * @return In271ConDtad
     */
    public static function traducirEstructura278ConDtad($cadena)
    {
        $flagISA = true;
        $flagGS = true;
        $flagST = true;
        $flagBHT = true;
        $flagNM1 = true;
        $flagN3 = true;
        $flagN4 = true;
        $flagPER = true;
        $tagHL = null;
        $tagPER = 1;
        $tagNM1 = 1;

        $bean = new In271ConDtad();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_CON_DTAD';
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
                        $bean->tiCaCalificador = isset($s1[2]) ? $s1[2] : '';
                        $bean->apPaNoEmCalificador = isset($s1[3]) ? $s1[3] : '';
                        $bean->noEmCalificador = isset($s1[4]) ? $s1[4] : '';
                        $bean->apMaCalificador = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                        $flagNM1 = false;
                    }
                }
            } elseif ($segmentId === 'N3') {
                if (!$flagN3) { continue; }
                $bean->deDirPaciente1 = isset($s1[1]) ? $s1[1] : '';
                $bean->deDirPaciente2 = isset($s1[2]) ? $s1[2] : '';
                $flagN3 = false;
            } elseif ($segmentId === 'N4') {
                if (!$flagN4) { continue; }
                $bean->coUbigeoPaciente = isset($s1[6]) ? $s1[6] : '';
                $flagN4 = false;
            } elseif ($segmentId === 'PER') {
                if (!$flagPER) { continue; }
                if ($tagPER === 1) {
                    $bean->noContacto = isset($s1[2]) ? $s1[2] : '';
                    $tagPER++;
                } elseif ($tagPER === 2) {
                    $bean->emContacto = isset($s1[4]) ? $s1[4] : '';
                    $bean->nuTeContacto = isset($s1[6]) ? $s1[6] : '';
                    $flagPER = false;
                }
            }
        }

        return $bean;
    }
}
