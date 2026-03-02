<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InSolAut271;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutProEsp271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutTieEsp271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutExeCar271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutRes271Detalle;

class SolAut271ToBean
{
    /**
     * @param string $cadena
     * @return InSolAut271
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
        $flagMSG = true;
        $flagHSD = true;
        $tagREF = 1;
        $tagNM1 = 1;
        $tagDTP = 1;
        $tagDMG = 1;
        $tagEB = 1;
        $tagMSG = 1;
        $tagHSD = 1;
        $tagHL = null;
        $conEBPE = 0;
        $conEBTE = 0;
        $conEBEC = 0;
        $conEB = 0;
        $conDTP = 0;
        $conREF = 0;
        $conMSG = 0;

        $canDetalle = self::cantidaSegmentosTx($cadena);
        $canPE = (int) $canDetalle[0];
        $canTE = (int) $canDetalle[1];
        $canEC = (int) $canDetalle[2];
        $canRE = (int) trim($canDetalle[3]);

        $bean = new InSolAut271();
        $arrayCadena = explode('~', $cadena);

        foreach ($arrayCadena as $dataCadena) {
            $s1 = explode('*', $dataCadena);
            $segmentId = trim($s1[0]);

            if ($segmentId === 'ISA') {
                if (!$flagISA) { continue; }
                $bean->noTransaccion = '271_SOL_AUT';
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
                        $tagNM1++;
                    } elseif ($tagNM1 === 4) {
                        $bean->caPaciente = isset($s1[2]) ? $s1[2] : '';
                        $bean->apPaternoPaciente = isset($s1[3]) ? $s1[3] : '';
                        $bean->noPaciente = isset($s1[4]) ? $s1[4] : '';
                        $bean->coAfPaciente = isset($s1[9]) ? $s1[9] : '';
                        $bean->apMaternoPaciente = isset($s1[12]) ? $s1[12] : '';
                        $tagNM1++;
                    }
                } elseif ($tagHL === '4') {
                    $bean->caRegafi = isset($s1[2]) ? $s1[2] : '';
                    $bean->noPaRegafi = isset($s1[3]) ? $s1[3] : '';
                    $bean->noRegafi = isset($s1[4]) ? $s1[4] : '';
                    $bean->coAfRegafi = isset($s1[9]) ? $s1[9] : '';
                    $bean->noMaRegafi = isset($s1[12]) ? $s1[12] : '';
                    $tagHL = '3';
                    $tagNM1 = 1;
                }
            } elseif ($segmentId === 'REF') {
                if (!$flagREF) { continue; }
                if ($tagREF === 1) {
                    $bean->coAdmisionista = isset($s1[2]) ? $s1[2] : '';
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
                    $bean->nuIdenEmpleador = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 5) {
                    $bean->nuContratoPaciente = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->nuPoliza = isset($ref04[1]) ? $ref04[1] : '';
                        $bean->nuCertificado = isset($ref04[3]) ? $ref04[3] : '';
                        $bean->coTiPolizaAfiliacion = isset($ref04[5]) ? $ref04[5] : '';
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
                        $bean->coEspecialidad = isset($ref04[3]) ? $ref04[3] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 10) {
                    $bean->deTiAccidente = isset($s1[2]) ? $s1[2] : '';
                    $tagREF++;
                } elseif ($tagREF === 11) {
                    $bean->tiProducto = isset($s1[2]) ? $s1[2] : '';
                    $bean->deProductoDeFarmacia = isset($s1[3]) ? $s1[3] : '';
                    $tagREF++;
                } elseif ($tagREF === 12) {
                    $bean->tiDoContratante = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->idReContratante = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->coReContratante = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 13) {
                    $bean->tiDoTitular = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->idReTitular = isset($ref04[0]) ? $ref04[0] : '';
                        $bean->nuDoTitular = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 14) {
                    $bean->coTiCobertura = isset($s1[2]) ? $s1[2] : '';
                    if (isset($s1[4])) {
                        $ref04 = explode(':', $s1[4]);
                        $bean->coSubTiCobertura = isset($ref04[1]) ? $ref04[1] : '';
                    }
                    $tagREF++;
                } elseif ($tagREF === 15) {
                    $lastTE = !empty($bean->detallesTE) ? end($bean->detallesTE) : null;
                    if ($lastTE) {
                        $lastTE->deTiEspera = isset($s1[2]) ? $s1[2] : '';
                    }
                    if ($conEBTE === $canTE) {
                        $tagREF++;
                    }
                } elseif ($tagREF === 16) {
                    $lastEC = !empty($bean->detallesEC) ? end($bean->detallesEC) : null;
                    if ($lastEC) {
                        $lastEC->deExCarencia = isset($s1[2]) ? $s1[2] : '';
                    }
                    if ($conEBEC === $canEC) {
                        $tagREF++;
                    }
                } elseif ($tagREF === 17) {
                    $lastRE = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($lastRE) {
                        $lastRE->obsRestricciones = isset($s1[2]) ? $s1[2] : '';
                    }
                    $conREF++;
                    $tagREF++;
                } elseif ($tagREF === 18) {
                    $lastRE = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($lastRE) {
                        $lastRE->deRestricciones = isset($s1[2]) ? $s1[2] : '';
                    }
                    $tagREF = ($conREF < $canRE) ? 17 : $tagREF + 1;
                } else {
                    $tagREF = 19;
                    if ($tagREF === 19) {
                        $bean->tiDoRegafi = isset($s1[2]) ? $s1[2] : '';
                        if (isset($s1[4])) {
                            $ref04 = explode(':', $s1[4]);
                            $bean->idReRegafi = isset($ref04[0]) ? $ref04[0] : '';
                            $bean->nuDoRegafi = isset($ref04[1]) ? $ref04[1] : '';
                        }
                        $tagREF = 1;
                    }
                }
            } elseif ($segmentId === 'DMG') {
                if (!$flagDMG) { continue; }
                if ($tagDMG === 1) {
                    $bean->feNacimiento = isset($s1[2]) ? $s1[2] : '';
                    $bean->genero = isset($s1[3]) ? $s1[3] : '';
                    $bean->esMarital = isset($s1[4]) ? $s1[4] : '';
                    $tagDMG++;
                } elseif ($tagDMG === 2) {
                    $bean->feNaRegafi = isset($s1[2]) ? $s1[2] : '';
                    $bean->geRegafi = isset($s1[3]) ? $s1[3] : '';
                    $bean->coPaisRegafi = isset($s1[7]) ? $s1[7] : '';
                    $tagDMG = 1;
                }
            } elseif ($segmentId === 'DTP') {
                if (!$flagDTP) { continue; }
                if ($tagDTP === 1) {
                    $bean->feIniVigencia = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 2) {
                    $bean->feFinVigencia = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 3) {
                    $bean->feAfiliacion = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 4) {
                    $bean->feOcuAccidente = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 5) {
                    $bean->feAtencion = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 6) {
                    $bean->feIncTitular = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 7) {
                    $bean->feFinCarencia = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 8) {
                    $bean->feFinEspera = isset($s1[3]) ? $s1[3] : '';
                    $tagDTP++;
                } elseif ($tagDTP === 9) {
                    $lastTE = !empty($bean->detallesTE) ? end($bean->detallesTE) : null;
                    if ($lastTE) {
                        $lastTE->feFinVigenciaTiEspera = isset($s1[3]) ? $s1[3] : '';
                    }
                    if ($conEBTE === $canTE) {
                        $tagDTP++;
                    }
                } elseif ($tagDTP === 10) {
                    $lastRE = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($lastRE) {
                        $lastRE->feFinEsperaRestricciones = isset($s1[3]) ? $s1[3] : '';
                    }
                }
            } elseif ($segmentId === 'EB') {
                if (!$flagEB) { continue; }
                if ($tagEB === 1) {
                    $bean->esCobertura = isset($s1[1]) ? $s1[1] : '';
                    $bean->nuDecAccidente = isset($s1[5]) ? $s1[5] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $bean->idInfAccidente = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $tagEB++;
                } elseif ($tagEB === 2) {
                    $bean->nuAtencion = isset($s1[5]) ? $s1[5] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $bean->idDerFarmacia = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $tagEB++;
                } elseif ($tagEB === 3) {
                    $bean->nuCobertura = isset($s1[5]) ? $s1[5] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $bean->obsCobertura = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $tagEB++;
                } elseif ($tagEB === 4) {
                    $bean->nuCobPreExistencia = isset($s1[5]) ? $s1[5] : '';
                    $bean->beMaxInicial = isset($s1[7]) ? $s1[7] : '';
                    $bean->canServicio = isset($s1[10]) ? $s1[10] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $bean->idDeProducto = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $tagEB++;
                } elseif ($tagEB === 5) {
                    $bean->coTiMoneda = isset($s1[5]) ? $s1[5] : '';
                    $bean->coPagoFijo = isset($s1[7]) ? $s1[7] : '';
                    $bean->coCalServicio = isset($s1[9]) ? $s1[9] : '';
                    $bean->canCalServicio = isset($s1[10]) ? $s1[10] : '';
                    $tagEB++;
                } elseif ($tagEB === 6) {
                    $bean->coPagoVariable = isset($s1[8]) ? $s1[8] : '';
                    $tagEB++;
                } elseif ($tagEB === 7) {
                    $bean->flagCG = isset($s1[1]) ? $s1[1] : '';
                    $bean->deflagCG = isset($s1[5]) ? $s1[5] : '';
                    $tagEB++;
                } elseif ($tagEB === 8) {
                    $detallePE = new InSolAutProEsp271Detalle();
                    $detallePE->coInProcedimiento = isset($s1[9]) ? $s1[9] : '';
                    $bean->detallesPE[] = $detallePE;
                    $conEBPE++;
                    $tagEB++;
                } elseif ($tagEB === 9) {
                    $lastPE = end($bean->detallesPE);
                    $lastPE->coTiProConAmbulatoria = isset($s1[3]) ? $s1[3] : '';
                    $lastPE->nuPlanConAmbulatoria = isset($s1[5]) ? $s1[5] : '';
                    $lastPE->imDeducible = isset($s1[7]) ? $s1[7] : '';
                    $lastPE->poConAmbulatoria = isset($s1[8]) ? $s1[8] : '';
                    $lastPE->frConAmbulatoria = isset($s1[10]) ? $s1[10] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $lastPE->geConAmbulatoria = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    if ($conEBPE < $canPE) {
                        $tagEB = 8;
                    }
                } elseif ($tagEB === 10) {
                    $detalleTE = new InSolAutTieEsp271Detalle();
                    $detalleTE->coTiEspera = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $detalleTE->idTiEspera = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $bean->detallesTE[] = $detalleTE;
                    $conEBTE++;
                    $tagEB++;
                    if ($conEBTE < $canTE) {
                        $tagEB = 10;
                    }
                } elseif ($tagEB === 11) {
                    $detalleEC = new InSolAutExeCar271Detalle();
                    $detalleEC->coExCarencia = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $detalleEC->idExCarencia = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $bean->detallesEC[] = $detalleEC;
                    $conEBEC++;
                    $tagEB++;
                    if ($conEBEC < $canEC) {
                        $tagEB = 11;
                    }
                } elseif ($tagEB === 12) {
                    $detalle = new InSolAutRes271Detalle();
                    $detalle->CIE10Restricciones = isset($s1[3]) ? $s1[3] : '';
                    if (isset($s1[13])) {
                        $eb13 = explode(':', $s1[13]);
                        $detalle->idRestricciones = isset($eb13[1]) ? $eb13[1] : '';
                    }
                    $bean->detalles[] = $detalle;
                    $tagEB++;
                    $conEB++;
                } elseif ($tagEB === 13) {
                    $lastRE = end($bean->detalles);
                    $lastRE->monTopeRestricciones = isset($s1[8]) ? $s1[8] : '';
                    if ($conEB < $canRE) {
                        $tagEB = 12;
                    }
                }
            } elseif ($segmentId === 'MSG') {
                if (!$flagMSG) { continue; }
                if ($tagMSG === 1) {
                    $bean->msgObs = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 2) {
                    $bean->msgConEspeciales = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 3) {
                    $bean->msgObsPre = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 4) {
                    $bean->msgConEspecialesPre = isset($s1[1]) ? $s1[1] : '';
                    $tagMSG++;
                } elseif ($tagMSG === 5) {
                    $lastPE = !empty($bean->detallesPE) ? end($bean->detallesPE) : null;
                    if ($lastPE) {
                        $lastPE->msgConAmbulatoria = isset($s1[1]) ? $s1[1] : '';
                    }
                    if ($conEBPE === $canPE || $canPE === 0) {
                        $tagEB++;
                        $tagMSG++;
                    }
                } elseif ($tagMSG === 6) {
                    $lastTE = !empty($bean->detallesTE) ? end($bean->detallesTE) : null;
                    if ($lastTE) {
                        $lastTE->msgTiEspera = isset($s1[1]) ? $s1[1] : '';
                    }
                    if ($conEBTE === $canTE || $canTE === 0) {
                        $tagMSG++;
                    }
                } elseif ($tagMSG === 7) {
                    $lastEC = !empty($bean->detallesEC) ? end($bean->detallesEC) : null;
                    if ($lastEC) {
                        $lastEC->msgExCarencia = isset($s1[1]) ? $s1[1] : '';
                    }
                    if ($conEBEC === $canEC || $canEC === 0) {
                        $tagMSG++;
                    }
                } elseif ($tagMSG === 8) {
                    $lastRE = !empty($bean->detalles) ? end($bean->detalles) : null;
                    if ($lastRE) {
                        $lastRE->msgRestricciones = isset($s1[1]) ? $s1[1] : '';
                    }
                }
            } elseif ($segmentId === 'HSD') {
                if (!$flagHSD) { continue; }
                if ($tagHSD === 1) {
                    $lastPE = !empty($bean->detallesPE) ? end($bean->detallesPE) : null;
                    if ($lastPE) {
                        $lastPE->caConAmbulatoria = isset($s1[2]) ? $s1[2] : '';
                    }
                    $tagHSD = 1;
                }
            }
        }

        return $bean;
    }

    /**
     * @param string $cadena
     * @return array
     */
    private static function cantidaSegmentosTx($cadena)
    {
        $arrayCadena1 = explode('~', $cadena);
        $va2 = null;
        if (count($arrayCadena1) > 1) {
            $ST = $arrayCadena1[2];
            $va1 = explode('*', $ST);
            $cant = isset($va1[3]) ? $va1[3] : '';
            $va2 = explode('#', $cant);
            $v1 = (int) (isset($va2[1]) ? $va2[1] : 0);
            $v2 = (int) (isset($va2[2]) ? $va2[2] : 0);
            $v3 = (int) trim(isset($va2[3]) ? $va2[3] : '0');
            if ($v1 === 0) {
                $va2[1] = '1';
            }
            if ($v2 === 0) {
                $va2[2] = '1';
            }
            if ($v3 === 0) {
                $va2[3] = '1';
            }
        }
        return $va2;
    }
}
