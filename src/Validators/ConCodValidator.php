<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConCod271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConCodValidator
{
    /**
     * @param InConCod271 $inConCod
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConCod)
    {
        $error = '0000';

        if ('' === $inConCod->getNoTransaccion()) { $error = '0100'; }
        elseif ('' === $inConCod->getIdRemitente()) { $error = '0101'; }
        elseif ('' === $inConCod->getIdReceptor()) { $error = '0102'; }
        elseif ('' === $inConCod->getFeTransaccion()) { $error = '0103'; }
        elseif ('' === $inConCod->getHoTransaccion()) { $error = '0104'; }
        elseif ('' === $inConCod->getIdCorrelativo()) { $error = '0105'; }
        elseif ('' === $inConCod->getIdTransaccion()) { $error = '0106'; }
        elseif ('' === $inConCod->getTiFinalidad()) { $error = '0107'; }
        elseif ('' === $inConCod->getCaRemitente()) { $error = '0108'; }
        elseif ('' === $inConCod->getCaReceptor()) { $error = '0116'; }
        elseif ('' === $inConCod->getNuRucReceptor()) { $error = '0117'; }
        elseif ('' === $inConCod->getCaPaciente()) { $error = '0150'; }
        elseif ('' === $inConCod->getApPaternoPaciente()) { $error = '0151'; }
        elseif ('' === $inConCod->getNoPaciente()) { $error = '0152'; }
        elseif ('' === $inConCod->getCoAfPaciente()) { $error = '0153'; }
        elseif ('' === $inConCod->getApMaternoPaciente()) { $error = '0154'; }
        elseif ('' === $inConCod->getCoEsPaciente()) { $error = '0155'; }
        elseif ('' === $inConCod->getTiDoPaciente()) { $error = '0156'; }
        elseif ('' === $inConCod->getNuDoPaciente()) { $error = '0157'; }
        elseif ('' === $inConCod->getNuContratoPaciente()) { $error = '0160'; }
        elseif ('' === $inConCod->getCoTiPoliza()) { $error = '0163'; }
        elseif ('' === $inConCod->getCoProducto()) { $error = '0164'; }
        elseif ('' === $inConCod->getDeProducto()) { $error = '0165'; }
        elseif ('' === $inConCod->getNuPlan()) { $error = '0170'; }
        elseif ('' === $inConCod->getTiPlanSalud()) { $error = '0171'; }
        elseif ('' === $inConCod->getCoMoneda()) { $error = '0172'; }
        elseif ('' === $inConCod->getCoParentesco()) { $error = '0173'; }
        elseif ('' === $inConCod->getFeNacimiento()) { $error = '0177'; }
        elseif ('' === $inConCod->getGenero()) { $error = '0178'; }
        elseif ('' === $inConCod->getEsMarital()) { $error = '0179'; }
        elseif ('' === $inConCod->getFeIniVigencia()) { $error = '0180'; }
        elseif ('' === $inConCod->getTiCaContratante()) { $error = '0350'; }
        elseif ('' === $inConCod->getNoPaContratante()) { $error = '0351'; }
        elseif ('' === $inConCod->getNoContratante()) { $error = '0353'; }
        elseif ('' === $inConCod->getNoMaContratante()) { $error = '0354'; }
        elseif ('' === $inConCod->getTiDoContratante()) { $error = '0355'; }
        elseif ('' === $inConCod->getIdReContratante()) { $error = '0356'; }
        elseif ('' === $inConCod->getCoReContratante()) { $error = '0357'; }
        elseif ('' === $inConCod->getCaTitular()) { $error = '0400'; }
        elseif ('' === $inConCod->getNoPaTitular()) { $error = '0401'; }
        elseif ('' === $inConCod->getNoTitular()) { $error = '0402'; }
        elseif ('' === $inConCod->getCoAfTitular()) { $error = '0403'; }
        elseif ('' === $inConCod->getNoMaTitular()) { $error = '0404'; }
        elseif ('' === $inConCod->getTiDoTitular()) { $error = '0405'; }
        elseif ('' === $inConCod->getNuDoTitular()) { $error = '0407'; }
        elseif ('' === $inConCod->getFeInsTitular()) { $error = '0408'; }
        elseif (count($inConCod->getInConCod271Detalles()) >= 0) {
            $list = $inConCod->getInConCod271Detalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getInfBeneficio()) { $error = '0450'; break; }
                if ('' === $det->getNuCobertura()) { $error = '0451'; break; }
                if ('' === $det->getBeMaxInicial()) { $error = '0452'; break; }
                if ('' === $det->getCoInRestriccion()) { $error = '0454'; break; }
                if ('' === $det->getCoTiCobertura()) { $error = '0457'; break; }
                if ('' === $det->getCoSubTiCobertura()) { $error = '0458'; break; }
                if ('' === $det->getCoTiMoneda()) { $error = '0462'; break; }
                if ('' === $det->getCoPagoFijo()) { $error = '0463'; break; }
                if ('' === $det->getCoCalServicio()) { $error = '0464'; break; }
                if ('' === $det->getCoPagoVariable()) { $error = '0466'; break; }
                if ('' === $det->getFlagCaGarantia()) { $error = '0467'; break; }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inConCod->getNoTransaccion())) < 1 || strlen(trim($inConCod->getNoTransaccion())) > 60) { $error = '0750'; }
            elseif (ManagerUtil::validaAlfanumerico($inConCod->getIdRemitente()) !== '0' || strlen($inConCod->getIdRemitente()) !== 15) { $error = '0751'; }
            elseif (strlen($inConCod->getIdReceptor()) !== 15) { $error = '0752'; }
            elseif (!ManagerUtil::validaFecha($inConCod->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConCod->getFeTransaccion())) !== 8) { $error = '0753'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getHoTransaccion()) !== '0' || strlen(trim($inConCod->getHoTransaccion())) < 4 || strlen(trim($inConCod->getHoTransaccion())) > 8) { $error = '0754'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getIdCorrelativo()) !== '0' || strlen(trim($inConCod->getIdCorrelativo())) !== 9) { $error = '0755'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getIdTransaccion()) !== '0' || strlen(trim($inConCod->getIdTransaccion())) !== 3) { $error = '0756'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getTiFinalidad()) !== '0' || strlen(trim($inConCod->getTiFinalidad())) !== 2) { $error = '0757'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCaRemitente()) !== '0' || strlen(trim($inConCod->getCaRemitente())) !== 1 || (trim($inConCod->getCaRemitente()) !== '1' && trim($inConCod->getCaRemitente()) !== '2')) { $error = '0758'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCaReceptor()) !== '0' || strlen(trim($inConCod->getCaReceptor())) !== 1 || (trim($inConCod->getCaReceptor()) !== '1' && trim($inConCod->getCaReceptor()) !== '2')) { $error = '0766'; }
            elseif (strlen(trim($inConCod->getNuRucReceptor())) < 2 || strlen(trim($inConCod->getNuRucReceptor())) > 20 || trim($inConCod->getNuRucReceptor()) === '00000000000') { $error = '0767'; }
            elseif (strlen(trim($inConCod->getCaPaciente())) !== 1 || (trim($inConCod->getCaPaciente()) !== '1' && trim($inConCod->getCaPaciente()) !== '2')) { $error = '0800'; }
            elseif (strlen(trim($inConCod->getApPaternoPaciente())) < 1 || strlen(trim($inConCod->getApPaternoPaciente())) > 60) { $error = '0801'; }
            elseif (strlen(trim($inConCod->getNoPaciente())) < 1 || strlen(trim($inConCod->getNoPaciente())) > 35) { $error = '0802'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoAfPaciente()) !== '0' || strlen(trim($inConCod->getCoAfPaciente())) < 2 || strlen(trim($inConCod->getCoAfPaciente())) > 20) { $error = '0803'; }
            elseif (strlen(trim($inConCod->getApMaternoPaciente())) < 1 || strlen(trim($inConCod->getApMaternoPaciente())) > 60) { $error = '0804'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoEsPaciente()) !== '0' || strlen(trim($inConCod->getCoEsPaciente())) < 1 || strlen(trim($inConCod->getCoEsPaciente())) > 2) { $error = '0805'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getTiDoPaciente()) !== '0' || strlen(trim($inConCod->getTiDoPaciente())) < 1 || strlen(trim($inConCod->getTiDoPaciente())) > 2) { $error = '0806'; }
            elseif (trim($inConCod->getNuDoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($inConCod->getNuDoPaciente()) !== '0' || strlen(trim($inConCod->getNuDoPaciente())) !== 8) { $error = '0807'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getNuContratoPaciente()) !== '0' || strlen(trim($inConCod->getNuContratoPaciente())) < 1 || strlen(trim($inConCod->getNuContratoPaciente())) > 20) { $error = '0810'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoTiPoliza()) !== '0' || strlen(trim($inConCod->getCoTiPoliza())) < 1 || strlen(trim($inConCod->getCoTiPoliza())) > 2) { $error = '0813'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoProducto()) !== '0' || strlen(trim($inConCod->getCoProducto())) < 1 || strlen(trim($inConCod->getCoProducto())) > 20) { $error = '0814'; }
            elseif (strlen(trim($inConCod->getDeProducto())) < 1 || strlen(trim($inConCod->getDeProducto())) > 80) { $error = '0815'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getNuPlan()) !== '0' || strlen(trim($inConCod->getNuPlan())) < 1 || strlen(trim($inConCod->getNuPlan())) > 20) { $error = '0818'; }
            elseif (strlen(trim($inConCod->getTiPlanSalud())) < 1 || strlen(trim($inConCod->getTiPlanSalud())) > 80) { $error = '0819'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoMoneda()) !== '0' || strlen(trim($inConCod->getCoMoneda())) < 1 || strlen(trim($inConCod->getCoMoneda())) > 3) { $error = '0820'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoParentesco()) !== '0' || strlen(trim($inConCod->getCoParentesco())) < 1 || strlen(trim($inConCod->getCoParentesco())) > 2) { $error = '0821'; }
            elseif (!ManagerUtil::validaFecha($inConCod->getFeNacimiento(), 'YYYYmmdd') || strlen(trim($inConCod->getFeNacimiento())) !== 8) { $error = '0825'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getGenero()) !== '0' || strlen(trim($inConCod->getGenero())) !== 1) { $error = '0826'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getEsMarital()) !== '0' || strlen(trim($inConCod->getEsMarital())) !== 1) { $error = '0827'; }
            elseif (!ManagerUtil::validaFecha($inConCod->getFeIniVigencia(), 'YYYYmmdd') || strlen(trim($inConCod->getFeIniVigencia())) !== 8) { $error = '0828'; }
            elseif (strlen(trim($inConCod->getTiCaContratante())) !== 1 || (trim($inConCod->getTiCaContratante()) !== '1' && trim($inConCod->getTiCaContratante()) !== '2')) { $error = '1050'; }
            elseif (strlen(trim($inConCod->getNoPaContratante())) < 1 || strlen(trim($inConCod->getNoPaContratante())) > 60) { $error = '1051'; }
            elseif (strlen(trim($inConCod->getNoContratante())) < 1 || strlen(trim($inConCod->getNoContratante())) > 35) { $error = '1053'; }
            elseif (strlen(trim($inConCod->getNoMaContratante())) < 1 || strlen(trim($inConCod->getNoMaContratante())) > 60) { $error = '1054'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getTiDoContratante()) !== '0' || strlen(trim($inConCod->getTiDoContratante())) < 1 || strlen(trim($inConCod->getTiDoContratante())) > 2) { $error = '1055'; }
            elseif (strlen(trim($inConCod->getIdReContratante())) < 2 || strlen(trim($inConCod->getIdReContratante())) > 3 || (trim($inConCod->getIdReContratante()) !== 'XX5' && trim($inConCod->getIdReContratante()) !== '4A')) { $error = '1056'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoReContratante()) !== '0' || strlen(trim($inConCod->getCoReContratante())) < 1 || strlen(trim($inConCod->getCoReContratante())) > 20) { $error = '1057'; }
            elseif (strlen(trim($inConCod->getCaTitular())) !== 1 || (trim($inConCod->getCaTitular()) !== '1' && trim($inConCod->getCaTitular()) !== '2')) { $error = '1100'; }
            elseif (strlen(trim($inConCod->getNoPaTitular())) < 1 || strlen(trim($inConCod->getNoPaTitular())) > 60) { $error = '1101'; }
            elseif (strlen(trim($inConCod->getNoTitular())) < 1 || strlen(trim($inConCod->getNoTitular())) > 35) { $error = '1102'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getCoAfTitular()) !== '0' || strlen(trim($inConCod->getCoAfTitular())) < 2 || strlen(trim($inConCod->getCoAfTitular())) > 80) { $error = '1103'; }
            elseif (strlen(trim($inConCod->getNoMaTitular())) < 1 || strlen(trim($inConCod->getNoMaTitular())) > 60) { $error = '1104'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getTiDoTitular()) !== '0' || strlen(trim($inConCod->getTiDoTitular())) < 1 || strlen(trim($inConCod->getTiDoTitular())) > 2) { $error = '1105'; }
            elseif (ManagerUtil::validaSoloDigito($inConCod->getNuDoTitular()) !== '0' || strlen(trim($inConCod->getNuDoTitular())) < 1 || strlen(trim($inConCod->getNuDoTitular())) > 20) { $error = '1107'; }
            elseif (!ManagerUtil::validaFecha($inConCod->getFeInsTitular(), 'YYYYmmdd') || strlen(trim($inConCod->getFeInsTitular())) !== 8) { $error = '1108'; }
            elseif (count($inConCod->getInConCod271Detalles()) >= 0) {
                $list = $inConCod->getInConCod271Detalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (ManagerUtil::validaSoloDigito($det->getInfBeneficio()) !== '0' || strlen(trim($det->getInfBeneficio())) < 1 || strlen(trim($det->getInfBeneficio())) > 2) { $error = '1150'; break; }
                    if (ManagerUtil::validaAlfanumerico($det->getNuCobertura()) !== '0' || strlen(trim($det->getNuCobertura())) < 1 || strlen(trim($det->getNuCobertura())) > 20) { $error = '1151'; break; }
                    if (ManagerUtil::validaDecimales($det->getBeMaxInicial()) !== '0' || strlen(trim($det->getBeMaxInicial())) < 1 || strlen(trim($det->getBeMaxInicial())) > 18) { $error = '1152'; break; }
                    if (ManagerUtil::validaDecimales($det->getMoCobertura()) !== '0' || strlen(trim($det->getMoCobertura())) < 1 || strlen(trim($det->getMoCobertura())) > 10) { $error = '1153'; break; }
                    if (strlen($det->getCoInRestriccion()) !== 2) { $error = '1154'; break; }
                    if (ManagerUtil::validaAlfanumerico($det->getCoTiCobertura()) !== '0' || strlen(trim($det->getCoTiCobertura())) < 1 || strlen(trim($det->getCoTiCobertura())) > 2) { $error = '1157'; break; }
                    if (ManagerUtil::validaSoloDigito($det->getCoSubTiCobertura()) !== '0' || strlen(trim($det->getCoSubTiCobertura())) < 1 || strlen(trim($det->getCoSubTiCobertura())) > 20) { $error = '1158'; break; }
                    if (ManagerUtil::validaSoloDigito($det->getCoTiMoneda()) !== '0' || strlen(trim($det->getCoTiMoneda())) < 1 || strlen(trim($det->getCoTiMoneda())) > 3) { $error = '1162'; break; }
                    if (ManagerUtil::validaDecimales($det->getCoPagoFijo()) !== '0' || strlen(trim($det->getCoPagoFijo())) < 1 || strlen(trim($det->getCoPagoFijo())) > 15) { $error = '1163'; break; }
                    if (strlen(trim($det->getCoCalServicio())) !== 2) { $error = '1164'; break; }
                    if (ManagerUtil::validaDecimales($det->getCoPagoVariable()) !== '0' || strlen(trim($det->getCoPagoVariable())) < 1 || strlen(trim($det->getCoPagoVariable())) > 15) { $error = '1166'; break; }
                    if (strlen(trim($det->getFlagCaGarantia())) < 1 || strlen(trim($det->getFlagCaGarantia())) > 2 || (trim($det->getFlagCaGarantia()) !== '0' && trim($det->getFlagCaGarantia()) !== '1' && trim($det->getFlagCaGarantia()) !== '2')) { $error = '1167'; break; }
                    if (!ManagerUtil::validaFecha($det->getFeFinCarencia(), 'YYYYmmdd') || strlen(trim($det->getFeFinCarencia())) !== 8) { $error = '1169'; break; }
                }
            }
        }

        return $error;
    }
}
