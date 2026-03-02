<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InSolAut271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class SolAutValidator
{
    /**
     * @param InSolAut271 $inSolAut
     * @return string Error code or "0000" if valid
     */
    public static function validate($inSolAut)
    {
        $error = '0000';

        if ('' === $inSolAut->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inSolAut->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inSolAut->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inSolAut->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inSolAut->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inSolAut->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inSolAut->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inSolAut->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inSolAut->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inSolAut->getNuRucRemitente()) {
            $error = '0111';
        } elseif ('' === $inSolAut->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inSolAut->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inSolAut->getApPaternoPaciente()) {
            $error = '0151';
        } elseif ('' === $inSolAut->getNoPaciente()) {
            $error = '0152';
        } elseif ('' === $inSolAut->getCoAfPaciente()) {
            $error = '0153';
        } elseif ('' === $inSolAut->getApMaternoPaciente()) {
            $error = '0154';
        } elseif ('' === $inSolAut->getCoEsPaciente()) {
            $error = '0155';
        } elseif ('' === $inSolAut->getTiDoPaciente()) {
            $error = '0156';
        } elseif ('' === $inSolAut->getNuDoPaciente()) {
            $error = '0157';
        } elseif ('' === $inSolAut->getNuIdenEmpleador()) {
            $error = '0159';
        } elseif ('' === $inSolAut->getNuContratoPaciente()) {
            $error = '0160';
        } elseif ('' === $inSolAut->getNuPoliza()) {
            $error = '0161';
        } elseif ('' === $inSolAut->getCoTiPolizaAfiliacion()) {
            $error = '0163';
        } elseif ('' === $inSolAut->getCoProducto()) {
            $error = '0164';
        } elseif ('' === $inSolAut->getDeProducto()) {
            $error = '0165';
        } elseif ('' === $inSolAut->getNuPlan()) {
            $error = '0168';
        } elseif ('' === $inSolAut->getTiPlanSalud()) {
            $error = '0169';
        } elseif ('' === $inSolAut->getCoMoneda()) {
            $error = '0170';
        } elseif ('' === $inSolAut->getCoParentesco()) {
            $error = '0171';
        } elseif ('' === $inSolAut->getFeNacimiento()) {
            $error = '0175';
        } elseif ('' === $inSolAut->getGenero()) {
            $error = '0176';
        } elseif ('' === $inSolAut->getEsMarital()) {
            $error = '0177';
        } elseif ('' === $inSolAut->getFeIniVigencia()) {
            $error = '0178';
        } elseif ('' === $inSolAut->getEsCobertura()) {
            $error = '0206';
        } elseif ('' === $inSolAut->getNuAtencion()) {
            $error = '0250';
        } elseif ('' === $inSolAut->getIdDerFarmacia()) {
            $error = '0251';
        } elseif ('' === $inSolAut->getTiProducto()) {
            $error = '0252';
        } elseif ('' === $inSolAut->getDeProductoDeFarmacia()) {
            $error = '0253';
        } elseif ('' === $inSolAut->getFeAtencion()) {
            $error = '0254';
        } elseif ('' === $inSolAut->getNuCobertura()) {
            $error = '0300';
        } elseif ('' === $inSolAut->getCaContratante()) {
            $error = '0350';
        } elseif ('' === $inSolAut->getNoPaContratante()) {
            $error = '0351';
        } elseif ('' === $inSolAut->getNoContratante()) {
            $error = '0353';
        } elseif ('' === $inSolAut->getNoMaContratante()) {
            $error = '0354';
        } elseif ('' === $inSolAut->getTiDoContratante()) {
            $error = '0355';
        } elseif ('' === $inSolAut->getIdReContratante()) {
            $error = '0356';
        } elseif ('' === $inSolAut->getCoReContratante()) {
            $error = '0357';
        } elseif ('' === $inSolAut->getCaTitular()) {
            $error = '0400';
        } elseif ('' === $inSolAut->getNoPaTitular()) {
            $error = '0401';
        } elseif ('' === $inSolAut->getNoTitular()) {
            $error = '0402';
        } elseif ('' === $inSolAut->getCoAfTitular()) {
            $error = '0403';
        } elseif ('' === $inSolAut->getNoMaTitular()) {
            $error = '0404';
        } elseif ('' === $inSolAut->getTiDoTitular()) {
            $error = '0405';
        } elseif ('' === $inSolAut->getIdReTitular()) {
            $error = '0406';
        } elseif ('' === $inSolAut->getNuDoTitular()) {
            $error = '0407';
        } elseif ('' === $inSolAut->getFeIncTitular()) {
            $error = '0408';
        } elseif ('' === $inSolAut->getNuCobPreExistencia()) {
            $error = '0451';
        } elseif ('' === $inSolAut->getBeMaxInicial()) {
            $error = '0452';
        } elseif ('' === $inSolAut->getCoTiCobertura()) {
            $error = '0457';
        } elseif ('' === $inSolAut->getCoSubTiCobertura()) {
            $error = '0458';
        } elseif ('' === $inSolAut->getCoTiMoneda()) {
            $error = '0462';
        } elseif ('' === $inSolAut->getCoPagoFijo()) {
            $error = '0463';
        } elseif ('' === $inSolAut->getCoCalServicio()) {
            $error = '0464';
        } elseif ('' === $inSolAut->getCoPagoVariable()) {
            $error = '0466';
        } elseif ('' === $inSolAut->getFlagCG()) {
            $error = '0467';
        } else {
            $list = $inSolAut->getInSolAut271Detalles();
            if (count($list) >= 0) {
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if ('' === $det->getCIE10Restricciones()) {
                        $error = '0650';
                    } elseif ('' === $det->getIdRestricciones()) {
                        $error = '0651';
                    } elseif ('' === $det->getObsRestricciones()) {
                        $error = '0652';
                    } elseif ('' === $det->getDeRestricciones()) {
                        $error = '0653';
                    } elseif ('' === $det->getMsgRestricciones()) {
                        $error = '0654';
                    } elseif ('' === $det->getFeFinEsperaRestricciones()) {
                        $error = '0656';
                    } else {
                        continue;
                    }
                    break;
                }
            }
        }

        if ($error !== '0000') {
            // Check regafi section when detail list condition was not met
            if ($error === '0000') {
                // This branch won't execute, preserved from Java structure
            }
        }

        // The Java code has a peculiar else-if structure after the detail list.
        // The regafi checks only execute when the list size < 0 (never in practice).
        // We preserve the structure faithfully:
        // In Java: } else if ("".equals(inSolAut.getCaRegafi())) { ... }
        // This is the else branch of the detail list size >= 0 check.

        if ($error === '0000') {
            if (strlen(trim($inSolAut->getNoTransaccion())) < 1 || strlen(trim($inSolAut->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inSolAut->getIdRemitente()) !== '0' || strlen($inSolAut->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inSolAut->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getHoTransaccion()) !== '0' || strlen(trim($inSolAut->getHoTransaccion())) < 4 || strlen(trim($inSolAut->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getIdCorrelativo()) !== '0' || strlen(trim($inSolAut->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getIdTransaccion()) !== '0' || strlen(trim($inSolAut->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getTiFinalidad()) !== '0' || strlen(trim($inSolAut->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCaRemitente()) !== '0' || strlen(trim($inSolAut->getCaRemitente())) !== 1 || (trim($inSolAut->getCaRemitente()) !== '1' && trim($inSolAut->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuRucRemitente()) !== '0' || strlen(trim($inSolAut->getNuRucRemitente())) < 2 || strlen(trim($inSolAut->getNuRucRemitente())) > 20 || trim($inSolAut->getNuRucRemitente()) === '00000000000') {
                $error = '0761';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCaReceptor()) !== '0' || strlen(trim($inSolAut->getCaReceptor())) !== 1 || (trim($inSolAut->getCaReceptor()) !== '1' && trim($inSolAut->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCaPaciente()) !== '0' || strlen(trim($inSolAut->getCaPaciente())) !== 1 || (trim($inSolAut->getCaPaciente()) !== '1' && trim($inSolAut->getCaPaciente()) !== '2')) {
                $error = '0800';
            } elseif (strlen(trim($inSolAut->getApPaternoPaciente())) < 1 || strlen(trim($inSolAut->getApPaternoPaciente())) > 60) {
                $error = '0801';
            } elseif (strlen(trim($inSolAut->getNoPaciente())) < 1 || strlen(trim($inSolAut->getNoPaciente())) > 35) {
                $error = '0802';
            } elseif (strlen(trim($inSolAut->getCoAfPaciente())) < 2 || strlen(trim($inSolAut->getCoAfPaciente())) > 20) {
                $error = '0803';
            } elseif (strlen(trim($inSolAut->getApMaternoPaciente())) < 1 || strlen(trim($inSolAut->getApMaternoPaciente())) > 60) {
                $error = '0804';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoEsPaciente()) !== '0' || strlen(trim($inSolAut->getCoEsPaciente())) < 1 || strlen(trim($inSolAut->getCoEsPaciente())) > 2) {
                $error = '0805';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getTiDoPaciente()) !== '0' || strlen(trim($inSolAut->getTiDoPaciente())) < 1 || strlen(trim($inSolAut->getTiDoPaciente())) > 2) {
                $error = '0806';
            } elseif (trim($inSolAut->getNuDoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($inSolAut->getNuDoPaciente()) !== '0' || strlen(trim($inSolAut->getNuDoPaciente())) !== 8) {
                $error = '0807';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuIdenEmpleador()) !== '0' || strlen(trim($inSolAut->getNuIdenEmpleador())) < 1 || strlen(trim($inSolAut->getNuIdenEmpleador())) > 20) {
                $error = '0809';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuContratoPaciente()) !== '0' || strlen(trim($inSolAut->getNuContratoPaciente())) < 1 || strlen(trim($inSolAut->getNuContratoPaciente())) > 20) {
                $error = '0810';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuPoliza()) !== '0' || strlen(trim($inSolAut->getNuPoliza())) < 1 || strlen(trim($inSolAut->getNuPoliza())) > 20) {
                $error = '0811';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoTiPolizaAfiliacion()) !== '0' || strlen(trim($inSolAut->getCoTiPolizaAfiliacion())) < 1 || strlen(trim($inSolAut->getCoTiPolizaAfiliacion())) > 2) {
                $error = '0813';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoProducto()) !== '0' || strlen(trim($inSolAut->getCoProducto())) < 1 || strlen(trim($inSolAut->getCoProducto())) > 20) {
                $error = '0814';
            } elseif (strlen(trim($inSolAut->getDeProducto())) < 1 || strlen(trim($inSolAut->getDeProducto())) > 80) {
                $error = '0815';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuPlan()) !== '0' || strlen(trim($inSolAut->getNuPlan())) < 1 || strlen(trim($inSolAut->getNuPlan())) > 20) {
                $error = '0818';
            } elseif (strlen(trim($inSolAut->getTiPlanSalud())) < 1 || strlen(trim($inSolAut->getTiPlanSalud())) > 80) {
                $error = '0819';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoMoneda()) !== '0' || strlen(trim($inSolAut->getCoMoneda())) < 1 || strlen(trim($inSolAut->getCoMoneda())) > 3) {
                $error = '0820';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoParentesco()) !== '0' || strlen(trim($inSolAut->getCoParentesco())) < 1 || strlen(trim($inSolAut->getCoParentesco())) > 2) {
                $error = '0821';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeNacimiento(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeNacimiento())) !== 8) {
                $error = '0825';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getGenero()) !== '0' || strlen(trim($inSolAut->getGenero())) !== 1) {
                $error = '0826';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getEsMarital()) !== '0' || strlen(trim($inSolAut->getEsMarital())) !== 1) {
                $error = '0827';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeIniVigencia(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeIniVigencia())) !== 8) {
                $error = '0828';
            } elseif (strlen(trim($inSolAut->getEsCobertura())) < 1 || strlen(trim($inSolAut->getEsCobertura())) > 2 || (trim($inSolAut->getEsCobertura()) !== '1' && trim($inSolAut->getEsCobertura()) !== '6')) {
                $error = '0906';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuAtencion()) !== '0' || strlen(trim($inSolAut->getNuAtencion())) < 1 || strlen(trim($inSolAut->getNuAtencion())) > 20) {
                $error = '0950';
            } elseif (ManagerUtil::validaAlfanumerico($inSolAut->getIdDerFarmacia()) !== '0' || strlen(trim($inSolAut->getIdDerFarmacia())) < 1 || strlen(trim($inSolAut->getIdDerFarmacia())) > 3) {
                $error = '0951';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getTiProducto()) !== '0' || strlen(trim($inSolAut->getTiProducto())) < 1 || strlen(trim($inSolAut->getTiProducto())) > 20) {
                $error = '0952';
            } elseif (strlen(trim($inSolAut->getDeProductoDeFarmacia())) < 1 || strlen(trim($inSolAut->getDeProductoDeFarmacia())) > 60) {
                $error = '0953';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeAtencion(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeAtencion())) !== 8) {
                $error = '0954';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuCobertura()) !== '0' || strlen(trim($inSolAut->getNuCobertura())) < 1 || strlen(trim($inSolAut->getNuCobertura())) > 20) {
                $error = '1000';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCaContratante()) !== '0' || strlen(trim($inSolAut->getCaContratante())) !== 1 || (trim($inSolAut->getCaContratante()) !== '1' && trim($inSolAut->getCaContratante()) !== '2')) {
                $error = '1050';
            } elseif (strlen(trim($inSolAut->getNoPaContratante())) < 1 || strlen(trim($inSolAut->getNoPaContratante())) > 60) {
                $error = '1051';
            } elseif (strlen(trim($inSolAut->getNoContratante())) < 1 || strlen(trim($inSolAut->getNoContratante())) > 35) {
                $error = '1053';
            } elseif (strlen(trim($inSolAut->getNoMaContratante())) < 1 || strlen(trim($inSolAut->getNoMaContratante())) > 60) {
                $error = '1054';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getTiDoContratante()) !== '0' || strlen(trim($inSolAut->getTiDoContratante())) < 1 || strlen(trim($inSolAut->getTiDoContratante())) > 2) {
                $error = '1055';
            } elseif (strlen(trim($inSolAut->getIdReContratante())) < 2 || strlen(trim($inSolAut->getIdReContratante())) > 3 || (trim($inSolAut->getIdReContratante()) !== 'XX5' && trim($inSolAut->getIdReContratante()) !== '4A')) {
                $error = '1056';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoReContratante()) !== '0' || strlen(trim($inSolAut->getCoReContratante())) < 1 || strlen(trim($inSolAut->getCoReContratante())) > 20) {
                $error = '1057';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCaTitular()) !== '0' || strlen(trim($inSolAut->getCaTitular())) !== 1 || (trim($inSolAut->getCaTitular()) !== '1' && trim($inSolAut->getCaTitular()) !== '2')) {
                $error = '1100';
            } elseif (strlen(trim($inSolAut->getNoPaTitular())) < 1 || strlen(trim($inSolAut->getNoPaTitular())) > 60) {
                $error = '1101';
            } elseif (strlen(trim($inSolAut->getNoTitular())) < 1 || strlen(trim($inSolAut->getNoTitular())) > 35) {
                $error = '1102';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoAfTitular()) !== '0' || strlen(trim($inSolAut->getCoAfTitular())) < 2 || strlen(trim($inSolAut->getCoAfTitular())) > 80) {
                $error = '1103';
            } elseif (strlen(trim($inSolAut->getNoMaTitular())) < 1 || strlen(trim($inSolAut->getNoMaTitular())) > 60) {
                $error = '1104';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getTiDoTitular()) !== '0' || strlen(trim($inSolAut->getTiDoTitular())) < 1 || strlen(trim($inSolAut->getTiDoTitular())) > 2) {
                $error = '1105';
            } elseif (strlen(trim($inSolAut->getIdReTitular())) < 2 || strlen(trim($inSolAut->getIdReTitular())) > 3 || (trim($inSolAut->getIdReTitular()) !== 'XX5' && trim($inSolAut->getIdReTitular()) !== '4A')) {
                $error = '1106';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuDoTitular()) !== '0' || strlen(trim($inSolAut->getNuDoTitular())) < 1 || strlen(trim($inSolAut->getNuDoTitular())) > 20) {
                $error = '1107';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeIncTitular(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeIncTitular())) !== 8) {
                $error = '1108';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getNuCobPreExistencia()) !== '0' || strlen(trim($inSolAut->getNuCobPreExistencia())) < 1 || strlen(trim($inSolAut->getNuCobPreExistencia())) > 20) {
                $error = '1151';
            } elseif (ManagerUtil::validaDecimales($inSolAut->getBeMaxInicial()) !== '0' || strlen(trim($inSolAut->getBeMaxInicial())) < 1 || strlen(trim($inSolAut->getBeMaxInicial())) > 18) {
                $error = '1152';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoTiCobertura()) !== '0' || strlen(trim($inSolAut->getCoTiCobertura())) < 1 || strlen(trim($inSolAut->getCoTiCobertura())) > 2) {
                $error = '1157';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoSubTiCobertura()) !== '0' || strlen(trim($inSolAut->getCoSubTiCobertura())) < 1 || strlen(trim($inSolAut->getCoSubTiCobertura())) > 20) {
                $error = '1158';
            } elseif (ManagerUtil::validaSoloDigito($inSolAut->getCoTiMoneda()) !== '0' || strlen(trim($inSolAut->getCoTiMoneda())) < 1 || strlen(trim($inSolAut->getCoTiMoneda())) > 3) {
                $error = '1162';
            } elseif (ManagerUtil::validaDecimales($inSolAut->getCoPagoFijo()) !== '0' || strlen(trim($inSolAut->getCoPagoFijo())) < 1 || strlen(trim($inSolAut->getCoPagoFijo())) > 15) {
                $error = '1163';
            } elseif (strlen(trim($inSolAut->getCoCalServicio())) !== 2) {
                $error = '1164';
            } elseif (ManagerUtil::validaDecimales($inSolAut->getCoPagoVariable()) !== '0' || strlen(trim($inSolAut->getCoPagoVariable())) < 1 || strlen(trim($inSolAut->getCoPagoVariable())) > 15) {
                $error = '1166';
            } elseif (strlen(trim($inSolAut->getFlagCG())) < 1 || strlen(trim($inSolAut->getFlagCG())) > 2 || (trim($inSolAut->getFlagCG()) !== '0' && trim($inSolAut->getFlagCG()) !== '1' && trim($inSolAut->getFlagCG()) !== '2')) {
                $error = '1167';
            } elseif (!ManagerUtil::validaFecha($inSolAut->getFeFinCarencia(), 'YYYYmmdd') || strlen(trim($inSolAut->getFeFinCarencia())) !== 8) {
                $error = '1169';
            } else {
                $list = $inSolAut->getInSolAut271Detalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (strlen(trim($det->getCIE10Restricciones())) < 1 || strlen(trim($det->getCIE10Restricciones())) > 20) {
                        $error = '1350';
                    } elseif (ManagerUtil::validaAlfanumerico($det->getIdRestricciones()) !== '0' || strlen(trim($det->getIdRestricciones())) < 1 || strlen(trim($det->getIdRestricciones())) > 3) {
                        $error = '1351';
                    } elseif (strlen(trim($det->getObsRestricciones())) < 1 || strlen(trim($det->getObsRestricciones())) > 80) {
                        $error = '1352';
                    } elseif (strlen(trim($det->getDeRestricciones())) < 1 || strlen(trim($det->getDeRestricciones())) > 80) {
                        $error = '1353';
                    } elseif (strlen(trim($det->getMsgRestricciones())) < 1 || strlen(trim($det->getMsgRestricciones())) > 264) {
                        $error = '1354';
                    } elseif (!ManagerUtil::validaFecha($det->getFeFinEsperaRestricciones(), 'YYYYmmdd') || strlen(trim($det->getFeFinEsperaRestricciones())) !== 8) {
                        $error = '1356';
                    } else {
                        continue;
                    }
                    break;
                }
            }
        }

        return $error;
    }
}
