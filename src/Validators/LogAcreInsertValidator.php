<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InLogAcreInsert271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class LogAcreInsertValidator
{
    /**
     * @param InLogAcreInsert271 $inLogAcreInsert
     * @return string Error code or "0000" if valid
     */
    public static function validate($inLogAcreInsert)
    {
        $error = '0000';

        if ('' === $inLogAcreInsert->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inLogAcreInsert->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inLogAcreInsert->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inLogAcreInsert->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inLogAcreInsert->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inLogAcreInsert->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inLogAcreInsert->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inLogAcreInsert->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inLogAcreInsert->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inLogAcreInsert->getNuRucRemitente()) {
            $error = '';
        } elseif ('' === $inLogAcreInsert->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inLogAcreInsert->getCaResponsableAut()) {
            $error = '0118';
        } elseif ('' === $inLogAcreInsert->getNoPaResponsableAut()) {
            $error = '0119';
        } elseif ('' === $inLogAcreInsert->getNoResponsableAut()) {
            $error = '0120';
        } elseif ('' === $inLogAcreInsert->getNoMaResponsableAut()) {
            $error = '0121';
        } elseif ('' === $inLogAcreInsert->getNuAutorizacion()) {
            $error = '0124';
        } elseif ('' === $inLogAcreInsert->getFeHoAutorizacion()) {
            $error = '0125';
        } elseif ('' === $inLogAcreInsert->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inLogAcreInsert->getApPaternoPaciente()) {
            $error = '0151';
        } elseif ('' === $inLogAcreInsert->getNoPaciente()) {
            $error = '0152';
        } elseif ('' === $inLogAcreInsert->getCoAfPaciente()) {
            $error = '0153';
        } elseif ('' === $inLogAcreInsert->getApMaternoPaciente()) {
            $error = '0154';
        } elseif ('' === $inLogAcreInsert->getCoEsPaciente()) {
            $error = '0155';
        } elseif ('' === $inLogAcreInsert->getTiDoPaciente()) {
            $error = '0156';
        } elseif ('' === $inLogAcreInsert->getNuDoPaciente()) {
            $error = '0157';
        } elseif ('' === $inLogAcreInsert->getCoProducto()) {
            $error = '0164';
        } elseif ('' === $inLogAcreInsert->getNuPlan()) {
            $error = '0170';
        } elseif ('' === $inLogAcreInsert->getCoParentesco()) {
            $error = '0173';
        } elseif ('' === $inLogAcreInsert->getFeNacimiento()) {
            $error = '0177';
        } elseif ('' === $inLogAcreInsert->getGenero()) {
            $error = '0178';
        } elseif ('' === $inLogAcreInsert->getFeIniVigencia()) {
            $error = '0180';
        } elseif ('' === $inLogAcreInsert->getNuCobertura()) {
            $error = '0300';
        } elseif ('' === $inLogAcreInsert->getCaContratante()) {
            $error = '0350';
        } elseif ('' === $inLogAcreInsert->getTiDoContratante()) {
            $error = '0355';
        } elseif ('' === $inLogAcreInsert->getIdReContratante()) {
            $error = '0356';
        } elseif ('' === $inLogAcreInsert->getRucContratante()) {
            $error = '0357';
        } elseif ('' === $inLogAcreInsert->getCoAfiliadoTitular()) {
            $error = '0403';
        } elseif ('' === $inLogAcreInsert->getBeMaxInicial()) {
            $error = '0452';
        } elseif ('' === $inLogAcreInsert->getCoPagoFijo()) {
            $error = '0463';
        } elseif ('' === $inLogAcreInsert->getCoPagoVariable()) {
            $error = '0466';
        } elseif ('' === $inLogAcreInsert->getFlagCartaGarantia()) {
            $error = '0467';
        }

        if ($error === '0000') {
            if (strlen(trim($inLogAcreInsert->getNoTransaccion())) < 1 || strlen(trim($inLogAcreInsert->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inLogAcreInsert->getIdRemitente()) !== '0' || strlen($inLogAcreInsert->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inLogAcreInsert->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inLogAcreInsert->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inLogAcreInsert->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getHoTransaccion()) !== '0' || strlen(trim($inLogAcreInsert->getHoTransaccion())) < 4 || strlen(trim($inLogAcreInsert->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getIdCorrelativo()) !== '0' || strlen(trim($inLogAcreInsert->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getIdTransaccion()) !== '0' || strlen(trim($inLogAcreInsert->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getTiFinalidad()) !== '0' || strlen(trim($inLogAcreInsert->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCaRemitente()) !== '0' || strlen(trim($inLogAcreInsert->getCaRemitente())) !== 1 || (trim($inLogAcreInsert->getCaRemitente()) !== '1' && trim($inLogAcreInsert->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getNuRucRemitente()) !== '0' || strlen(trim($inLogAcreInsert->getNuRucRemitente())) < 2 || strlen(trim($inLogAcreInsert->getNuRucRemitente())) > 20 || trim($inLogAcreInsert->getNuRucRemitente()) === '00000000000') {
                $error = '0761';
            }
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCaReceptor()) !== '0' || strlen(trim($inLogAcreInsert->getCaReceptor())) !== 1 || (trim($inLogAcreInsert->getCaReceptor()) !== '1' && trim($inLogAcreInsert->getCaReceptor()) !== '2')) {
            $error = '0766';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCaResponsableAut()) !== '0' || strlen(trim($inLogAcreInsert->getCaResponsableAut())) !== 1) {
            $error = '0768';
        } elseif (strlen(trim($inLogAcreInsert->getNoPaResponsableAut())) < 1 || strlen(trim($inLogAcreInsert->getNoPaResponsableAut())) > 60) {
            $error = '0769';
        } elseif (strlen(trim($inLogAcreInsert->getNoResponsableAut())) < 1 || strlen(trim($inLogAcreInsert->getNoResponsableAut())) > 35) {
            $error = '0770';
        } elseif (strlen(trim($inLogAcreInsert->getNoMaResponsableAut())) < 1 || strlen(trim($inLogAcreInsert->getNoMaResponsableAut())) > 60) {
            $error = '0771';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getTiDoResponsableAut()) !== '0' || strlen(trim($inLogAcreInsert->getTiDoResponsableAut())) < 1 || strlen(trim($inLogAcreInsert->getTiDoResponsableAut())) > 2 || (trim($inLogAcreInsert->getTiDoResponsableAut()) !== '1' && trim($inLogAcreInsert->getTiDoResponsableAut()) !== '2')) {
            $error = '0772';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getNuDoResponsableAut()) !== '0' || strlen(trim($inLogAcreInsert->getNuDoResponsableAut())) < 1 || strlen(trim($inLogAcreInsert->getNuDoResponsableAut())) > 20) {
            $error = '0773';
        } elseif (strlen(trim($inLogAcreInsert->getNuAutorizacion())) < 1 || strlen(trim($inLogAcreInsert->getNuAutorizacion())) > 20) {
            $error = '0774';
        } elseif (strlen(trim($inLogAcreInsert->getFeTransaccion())) !== 12) {
            $error = '0775';
        } elseif (strlen(trim($inLogAcreInsert->getCaPaciente())) !== 1 || (trim($inLogAcreInsert->getCaPaciente()) !== '1' && trim($inLogAcreInsert->getCaPaciente()) !== '2')) {
            $error = '0800';
        } elseif (strlen(trim($inLogAcreInsert->getApPaternoPaciente())) < 1 || strlen(trim($inLogAcreInsert->getApPaternoPaciente())) > 60) {
            $error = '0801';
        } elseif (strlen(trim($inLogAcreInsert->getNoPaciente())) < 1 || strlen(trim($inLogAcreInsert->getNoPaciente())) > 35) {
            $error = '0802';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCoAfPaciente()) !== '0' || strlen(trim($inLogAcreInsert->getCoAfPaciente())) < 2 || strlen(trim($inLogAcreInsert->getCoAfPaciente())) > 20) {
            $error = '0803';
        } elseif (strlen(trim($inLogAcreInsert->getApMaternoPaciente())) < 1 || strlen(trim($inLogAcreInsert->getApMaternoPaciente())) > 60) {
            $error = '0804';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCoEsPaciente()) !== '0' || strlen(trim($inLogAcreInsert->getCoEsPaciente())) < 1 || strlen(trim($inLogAcreInsert->getCoEsPaciente())) > 2) {
            $error = '0805';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getTiDoPaciente()) !== '0' || strlen(trim($inLogAcreInsert->getTiDoPaciente())) < 1 || strlen(trim($inLogAcreInsert->getTiDoPaciente())) > 2) {
            $error = '0806';
        } elseif (trim($inLogAcreInsert->getNuDoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($inLogAcreInsert->getNuDoPaciente()) !== '0' || strlen(trim($inLogAcreInsert->getNuDoPaciente())) !== 8) {
            $error = '0807';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCoProducto()) !== '0' || strlen(trim($inLogAcreInsert->getCoProducto())) < 1 || strlen(trim($inLogAcreInsert->getCoProducto())) > 20) {
            $error = '0814';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getNuPlan()) !== '0' || strlen(trim($inLogAcreInsert->getNuPlan())) < 1 || strlen(trim($inLogAcreInsert->getNuPlan())) > 20) {
            $error = '0818';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCoParentesco()) !== '0' || strlen(trim($inLogAcreInsert->getCoParentesco())) < 1 || strlen(trim($inLogAcreInsert->getCoParentesco())) > 20) {
            $error = '0821';
        } elseif (!ManagerUtil::validaFecha($inLogAcreInsert->getFeNacimiento(), 'YYYYmmdd') || strlen(trim($inLogAcreInsert->getFeNacimiento())) !== 8) {
            $error = '0825';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getGenero()) !== '0' || strlen(trim($inLogAcreInsert->getGenero())) !== 1) {
            $error = '0826';
        } elseif (!ManagerUtil::validaFecha($inLogAcreInsert->getFeIniVigencia(), 'YYYYmmdd') || strlen(trim($inLogAcreInsert->getFeIniVigencia())) !== 8) {
            $error = '0828';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getNuCobertura()) !== '0' || strlen(trim($inLogAcreInsert->getNuCobertura())) < 1 || strlen(trim($inLogAcreInsert->getNuCobertura())) > 20) {
            $error = '1000';
        } elseif (strlen(trim($inLogAcreInsert->getCaContratante())) !== 1 || (trim($inLogAcreInsert->getCaContratante()) !== '1' && trim($inLogAcreInsert->getCaContratante()) !== '2')) {
            $error = '1050';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getTiDoContratante()) !== '0' || strlen(trim($inLogAcreInsert->getTiDoContratante())) < 1 || strlen(trim($inLogAcreInsert->getTiDoContratante())) > 2) {
            $error = '1055';
        } elseif (strlen(trim($inLogAcreInsert->getIdReContratante())) < 2 || strlen(trim($inLogAcreInsert->getIdReContratante())) > 3 || (trim($inLogAcreInsert->getIdReContratante()) !== 'XX5' && trim($inLogAcreInsert->getIdReContratante()) !== '4A')) {
            $error = '1056';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getRucContratante()) !== '0' || strlen(trim($inLogAcreInsert->getRucContratante())) < 1 || strlen(trim($inLogAcreInsert->getRucContratante())) > 20) {
            $error = '1057';
        } elseif (ManagerUtil::validaSoloDigito($inLogAcreInsert->getCoAfiliadoTitular()) !== '0' || strlen(trim($inLogAcreInsert->getCoAfiliadoTitular())) < 2 || strlen(trim($inLogAcreInsert->getCoAfiliadoTitular())) > 80) {
            $error = '1103';
        } elseif (ManagerUtil::validaDecimales($inLogAcreInsert->getBeMaxInicial()) !== '0' || strlen(trim($inLogAcreInsert->getBeMaxInicial())) < 1 || strlen(trim($inLogAcreInsert->getBeMaxInicial())) > 18) {
            $error = '1152';
        } elseif (ManagerUtil::validaDecimales($inLogAcreInsert->getCoPagoFijo()) !== '0' || strlen(trim($inLogAcreInsert->getCoPagoFijo())) < 1 || strlen(trim($inLogAcreInsert->getCoPagoFijo())) > 15) {
            $error = '1163';
        } elseif (ManagerUtil::validaDecimales($inLogAcreInsert->getCoPagoVariable()) !== '0' || strlen(trim($inLogAcreInsert->getCoPagoVariable())) < 1 || strlen(trim($inLogAcreInsert->getCoPagoVariable())) > 15) {
            $error = '1166';
        } elseif (strlen(trim($inLogAcreInsert->getFlagCartaGarantia())) < 1 || strlen(trim($inLogAcreInsert->getFlagCartaGarantia())) > 2 || (trim($inLogAcreInsert->getFlagCartaGarantia()) !== '0' && trim($inLogAcreInsert->getFlagCartaGarantia()) !== '1' && trim($inLogAcreInsert->getFlagCartaGarantia()) !== '2')) {
            $error = '1167';
        }

        return $error;
    }
}
