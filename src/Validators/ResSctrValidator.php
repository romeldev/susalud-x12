<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In271ResSctr;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ResSctrValidator
{
    /**
     * @param In271ResSctr $inResSctr
     * @return string Error code or "0000" if valid
     */
    public static function validate($inResSctr)
    {
        $error = '0000';

        if ('' === $inResSctr->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inResSctr->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inResSctr->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inResSctr->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inResSctr->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inResSctr->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inResSctr->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inResSctr->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inResSctr->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inResSctr->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inResSctr->getNuRucReceptor()) {
            $error = '0117';
        } elseif ('' === $inResSctr->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inResSctr->getApPaternoPaciente()) {
            $error = '0151';
        } elseif ('' === $inResSctr->getNoPaciente()) {
            $error = '0152';
        } elseif ('' === $inResSctr->getCoAfPaciente()) {
            $error = '0153';
        } elseif ('' === $inResSctr->getApMaternoPaciente()) {
            $error = '0154';
        } elseif ('' === $inResSctr->getCoTiDoPaciente()) {
            $error = '0156';
        } elseif ('' === $inResSctr->getNuDocPaciente()) {
            $error = '0157';
        } else {
            $list = $inResSctr->getIn271ResSctrDetalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getTiCaContratante()) { $error = '0350'; continue; }
                if ('' === $det->getNoEmApPaContratante()) { $error = '0351'; continue; }
                if ('' === $det->getCoEmContratante()) { $error = '0352'; continue; }
                if ('' === $det->getIdCaReContratante()) { $error = '0356'; continue; }
                if ('' === $det->getReIdContratante()) { $error = '0357'; continue; }
                if ('' === $det->getTiCaLuAtencion()) { $error = '0200'; continue; }
                if ('' === $det->getNoEmLuAtencion()) { $error = '0201'; continue; }
                if ('' === $det->getCoEmReLuAtencion()) { $error = '0202'; continue; }
                if ('' === $det->getIdCaReLuAtencion()) { $error = '0203'; continue; }
                if ('' === $det->getReIdLuAtencion()) { $error = '0204'; continue; }
                if ('' === $det->getCoLuAtencion()) { $error = '0205'; continue; }
                if ('' === $det->getDeTiAccidente()) { $error = '0209'; continue; }
                if ('' === $det->getFeAfiliacion()) { $error = '0210'; continue; }
                if ('' === $det->getFeOcAccidente()) { $error = '0212'; }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inResSctr->getNoTransaccion())) < 1 || strlen(trim($inResSctr->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inResSctr->getIdRemitente()) !== '0' || strlen($inResSctr->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inResSctr->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inResSctr->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inResSctr->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getHoTransaccion()) !== '0' || strlen(trim($inResSctr->getHoTransaccion())) < 4 || strlen(trim($inResSctr->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getIdCorrelativo()) !== '0' || strlen(trim($inResSctr->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getIdTransaccion()) !== '0' || strlen(trim($inResSctr->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getTiFinalidad()) !== '0' || strlen(trim($inResSctr->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getCaRemitente()) !== '0' || strlen(trim($inResSctr->getCaRemitente())) !== 1 || (trim($inResSctr->getCaRemitente()) !== '1' && trim($inResSctr->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getCaReceptor()) !== '0' || strlen(trim($inResSctr->getCaReceptor())) !== 1 || (trim($inResSctr->getCaReceptor()) !== '1' && trim($inResSctr->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getNuRucReceptor()) !== '0' || strlen(trim($inResSctr->getNuRucReceptor())) < 2 || strlen(trim($inResSctr->getNuRucReceptor())) > 20 || trim($inResSctr->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getCaPaciente()) !== '0' || strlen(trim($inResSctr->getCaPaciente())) !== 1 || (trim($inResSctr->getCaPaciente()) !== '1' && trim($inResSctr->getCaPaciente()) !== '2')) {
                $error = '0800';
            } elseif (strlen(trim($inResSctr->getApPaternoPaciente())) < 1 || strlen(trim($inResSctr->getApPaternoPaciente())) > 60) {
                $error = '0801';
            } elseif (strlen(trim($inResSctr->getNoPaciente())) < 1 || strlen(trim($inResSctr->getNoPaciente())) > 35) {
                $error = '0802';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getCoAfPaciente()) !== '0' || strlen(trim($inResSctr->getCoAfPaciente())) < 2 || strlen(trim($inResSctr->getCoAfPaciente())) > 20) {
                $error = '0803';
            } elseif (strlen(trim($inResSctr->getApMaternoPaciente())) < 1 || strlen(trim($inResSctr->getApMaternoPaciente())) > 60) {
                $error = '0804';
            } elseif (ManagerUtil::validaSoloDigito($inResSctr->getCoTiDoPaciente()) !== '0' || strlen(trim($inResSctr->getCoTiDoPaciente())) < 1 || strlen(trim($inResSctr->getCoTiDoPaciente())) > 2) {
                $error = '0806';
            } elseif (trim($inResSctr->getNuDocPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($inResSctr->getNuDocPaciente()) !== '0' || strlen(trim($inResSctr->getNuDocPaciente())) !== 8) {
                $error = '0807';
            } else {
                $list = $inResSctr->getIn271ResSctrDetalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (strlen(trim($det->getTiCaContratante())) !== 1 || (trim($det->getTiCaContratante()) !== '1' && trim($det->getTiCaContratante()) !== '2')) { $error = '1050'; continue; }
                    if (strlen(trim($det->getNoEmApPaContratante())) < 1 || strlen(trim($det->getNoEmApPaContratante())) > 60) { $error = '1051'; continue; }
                    if (strlen(trim($det->getCoEmContratante())) < 1 || strlen(trim($det->getCoEmContratante())) > 20) { $error = '1052'; continue; }
                    if (strlen(trim($det->getIdCaReContratante())) < 2 || strlen(trim($det->getIdCaReContratante())) > 3 || (trim($det->getIdCaReContratante()) !== 'XX5' && trim($det->getIdCaReContratante()) !== '4A')) { $error = '1056'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getReIdContratante()) !== '0' || strlen(trim($det->getReIdContratante())) < 1 || strlen(trim($det->getReIdContratante())) > 20) { $error = '1057'; continue; }
                    if (strlen(trim($det->getTiCaLuAtencion())) !== 1 || (trim($det->getTiCaLuAtencion()) !== '1' && trim($det->getTiCaLuAtencion()) !== '2')) { $error = '0900'; continue; }
                    if (strlen(trim($det->getNoEmLuAtencion())) < 1 || strlen(trim($det->getNoEmLuAtencion())) > 60) { $error = '0901'; continue; }
                    if (strlen(trim($det->getCoEmReLuAtencion())) < 1 || strlen(trim($det->getCoEmReLuAtencion())) > 20) { $error = '0902'; continue; }
                    if (strlen(trim($det->getIdCaReLuAtencion())) < 2 || strlen(trim($det->getIdCaReLuAtencion())) > 3 || (trim($det->getIdCaReLuAtencion()) !== 'XX5' && trim($det->getIdCaReLuAtencion()) !== '4A')) { $error = '0903'; continue; }
                    if (strlen(trim($det->getReIdLuAtencion())) < 1 || strlen(trim($det->getReIdLuAtencion())) > 20) { $error = '0904'; continue; }
                    if (strlen(trim($det->getCoLuAtencion())) < 1 || strlen(trim($det->getCoLuAtencion())) > 20) { $error = '0905'; continue; }
                    if (strlen(trim($det->getDeTiAccidente())) < 1 || strlen(trim($det->getDeTiAccidente())) > 60) { $error = '0909'; continue; }
                    if (!ManagerUtil::validaFecha($det->getFeAfiliacion(), 'YYYYmmdd') || strlen(trim($det->getFeAfiliacion())) !== 8) { $error = '0910'; continue; }
                    if (!ManagerUtil::validaFecha($det->getFeOcAccidente(), 'YYYYmmdd') || strlen(trim($det->getFeOcAccidente())) !== 8) { $error = '0912'; }
                }
            }
        }

        return $error;
    }
}
