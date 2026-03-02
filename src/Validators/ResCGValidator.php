<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In278ResCG;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ResCGValidator
{
    /**
     * @param In278ResCG $inResCG
     * @return string Error code or "0000" if valid
     */
    public static function validate($inResCG)
    {
        $error = '0000';

        if ('' === $inResCG->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inResCG->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inResCG->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inResCG->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inResCG->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inResCG->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inResCG->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inResCG->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inResCG->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inResCG->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inResCG->getNuRucReceptor()) {
            $error = '0117';
        } else {
            $list = $inResCG->getIn278ResCGDetalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getCaPaciente()) { $error = '0150'; break; }
                if ('' === $det->getApPaternoPaciente()) { $error = '0151'; break; }
                if ('' === $det->getNoPaciente()) { $error = '0152'; break; }
                if ('' === $det->getCoAfPaciente()) { $error = '0153'; break; }
                if ('' === $det->getApMaternoPaciente()) { $error = '0154'; break; }
                if ('' === $det->getCoTiDoPaciente()) { $error = '0156'; break; }
                if ('' === $det->getNuDoPaciente()) { $error = '0157'; break; }
                if ('' === $det->getMonPago()) { $error = '0452'; continue; }
                if ('' === $det->getTiCaContratante()) { $error = '0350'; break; }
                if ('' === $det->getNoPaContratante()) { $error = '0351'; break; }
                if ('' === $det->getNoContratante()) { $error = '0353'; break; }
                if ('' === $det->getNoMaContratante()) { $error = '0354'; break; }
                if ('' === $det->getDeCarGarantia()) { $error = '0471'; break; }
                if ('' === $det->getNuCarGarantia()) { $error = '0473'; break; }
                if ('' === $det->getVeCarGarantia()) { $error = '0474'; break; }
                if ('' === $det->getEsCarGarantia()) { $error = '0475'; break; }
                if ('' === $det->getFeCarGarantia()) { $error = '0476'; break; }
                if ('' === $det->getCoMoneda()) { $error = '0462'; break; }
                if ('' === $det->getCoProducto()) { $error = '0164'; break; }
                if ('' === $det->getDeProcedimiento()) { $error = '0503'; break; }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inResCG->getNoTransaccion())) < 1 || strlen(trim($inResCG->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inResCG->getIdRemitente()) !== '0' || strlen($inResCG->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inResCG->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inResCG->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inResCG->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getHoTransaccion()) !== '0' || strlen(trim($inResCG->getHoTransaccion())) < 4 || strlen(trim($inResCG->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getIdCorrelativo()) !== '0' || strlen(trim($inResCG->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getIdTransaccion()) !== '0' || strlen(trim($inResCG->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getTiFinalidad()) !== '0' || strlen(trim($inResCG->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getCaRemitente()) !== '0' || strlen(trim($inResCG->getCaRemitente())) !== 1 || (trim($inResCG->getCaRemitente()) !== '1' && trim($inResCG->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getCaReceptor()) !== '0' || strlen(trim($inResCG->getCaReceptor())) !== 1 || (trim($inResCG->getCaReceptor()) !== '1' && trim($inResCG->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inResCG->getNuRucReceptor()) !== '0' || strlen(trim($inResCG->getNuRucReceptor())) < 2 || strlen(trim($inResCG->getNuRucReceptor())) > 20 || trim($inResCG->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } else {
                $list = $inResCG->getIn278ResCGDetalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (ManagerUtil::validaSoloDigito($det->getCaPaciente()) !== '0' || strlen(trim($det->getCaPaciente())) !== 1 || (trim($det->getCaPaciente()) !== '1' && trim($det->getCaPaciente()) !== '2')) { $error = '0800'; continue; }
                    if (strlen(trim($det->getApPaternoPaciente())) < 1 || strlen(trim($det->getApPaternoPaciente())) > 60) { $error = '0801'; continue; }
                    if (strlen(trim($det->getNoPaciente())) < 1 || strlen(trim($det->getNoPaciente())) > 35) { $error = '0802'; continue; }
                    if (strlen(trim($det->getCoAfPaciente())) < 2 || strlen(trim($det->getCoAfPaciente())) > 20) { $error = '0803'; continue; }
                    if (strlen(trim($det->getApMaternoPaciente())) < 1 || strlen(trim($det->getApMaternoPaciente())) > 60) { $error = '0804'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getCoTiDoPaciente()) !== '0' || strlen(trim($det->getCoTiDoPaciente())) < 1 || strlen(trim($det->getCoTiDoPaciente())) > 2) { $error = '0806'; continue; }
                    if (trim($det->getNuDoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($det->getNuDoPaciente()) !== '0' || strlen(trim($det->getNuDoPaciente())) !== 8) { $error = '0807'; continue; }
                    if (ManagerUtil::validaDecimales($det->getMonPago()) !== '0' || strlen(trim($det->getMonPago())) < 1 || strlen(trim($det->getMonPago())) > 18) { $error = '1152'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getTiCaContratante()) !== '0' || strlen(trim($det->getTiCaContratante())) !== 1 || (trim($det->getTiCaContratante()) !== '1' && trim($det->getTiCaContratante()) !== '2')) { $error = '1050'; continue; }
                    if (strlen(trim($det->getNoPaContratante())) < 1 || strlen(trim($det->getNoPaContratante())) > 60) { $error = '1051'; continue; }
                    if (strlen(trim($det->getNoContratante())) < 1 || strlen(trim($det->getNoContratante())) > 35) { $error = '1053'; continue; }
                    if (strlen(trim($det->getNoMaContratante())) < 1 || strlen(trim($det->getNoMaContratante())) > 60) { $error = '1054'; continue; }
                    if (strlen(trim($det->getDeCarGarantia())) < 1 || strlen(trim($det->getDeCarGarantia())) > 80) { $error = '1171'; continue; }
                    if (strlen(trim($det->getNuCarGarantia())) < 1 || strlen(trim($det->getNuCarGarantia())) > 20) { $error = '1173'; continue; }
                    if (strlen(trim($det->getVeCarGarantia())) < 1 || strlen(trim($det->getVeCarGarantia())) > 20) { $error = '1174'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getEsCarGarantia()) !== '0' || strlen(trim($det->getEsCarGarantia())) < 1 || strlen(trim($det->getEsCarGarantia())) > 2) { $error = '1175'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getFeCarGarantia()) !== '0' || strlen(trim($det->getFeCarGarantia())) !== 12) { $error = '1176'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getCoMoneda()) !== '0' || strlen(trim($det->getCoMoneda())) < 1 || strlen(trim($det->getCoMoneda())) > 3) { $error = '1162'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getCoProducto()) !== '0' || strlen(trim($det->getCoProducto())) < 1 || strlen(trim($det->getCoProducto())) > 20) { $error = '0814'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getCoProcedimiento()) !== '0' || strlen(trim($det->getCoProcedimiento())) !== 2) { $error = '1202'; continue; }
                    if (strlen(trim($det->getDeProcedimiento())) < 1 || strlen(trim($det->getDeProcedimiento())) > 80) { $error = '1203'; }
                }
            }
        }

        return $error;
    }
}
