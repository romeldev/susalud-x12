<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConAse270;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConAseValidator
{
    /**
     * @param InConAse270 $inConAse
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConAse)
    {
        $buscarPorDNI = 'OK';
        $flagApPaciente = false;
        $error = '0000';
        $nombreTx = $inConAse->getTxRequest();

        if (strtolower(trim($nombreTx)) === 'cn') {
            if ('' === $inConAse->getNoTransaccion()) {
                $error = '0100';
            } elseif ('' === $inConAse->getIdRemitente()) {
                $error = '0101';
            } elseif ('' === $inConAse->getIdReceptor()) {
                $error = '0102';
            } elseif ('' === $inConAse->getFeTransaccion()) {
                $error = '0103';
            } elseif ('' === $inConAse->getHoTransaccion()) {
                $error = '0104';
            } elseif ('' === $inConAse->getIdCorrelativo()) {
                $error = '0105';
            } elseif ('' === $inConAse->getIdTransaccion()) {
                $error = '0106';
            } elseif ('' === $inConAse->getTiFinalidad()) {
                $error = '0107';
            } elseif ('' === $inConAse->getCaRemitente()) {
                $error = '0108';
            } elseif ('' === $inConAse->getNuRucRemitente()) {
                $error = '0111';
            } elseif ('' === $inConAse->getTxRequest()) {
                $error = '0115';
            } elseif ('' === $inConAse->getCaReceptor()) {
                $error = '0116';
            } elseif ('' === $inConAse->getCaPaciente()) {
                $error = '0150';
            } elseif ('' === $inConAse->getApPaternoPaciente()) {
                $flagApPaciente = true;
                if ('' === $inConAse->getTiDocumento() && '' === $inConAse->getNuDocumento()) {
                    $error = '0151';
                    $buscarPorDNI = 'NO-OK';
                } elseif ('' === $inConAse->getTiDocumento()) {
                    $error = '0156';
                } elseif ('' === $inConAse->getNuDocumento()) {
                    $error = '0157';
                }
            }

            if ($error === '0000') {
                if (strlen(trim($inConAse->getNoTransaccion())) < 1 || strlen(trim($inConAse->getNoTransaccion())) > 60) {
                    $error = '0750';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getIdRemitente()) !== '0' || strlen($inConAse->getIdRemitente()) !== 15) {
                    $error = '0751';
                } elseif (strlen($inConAse->getIdReceptor()) !== 15) {
                    $error = '0752';
                } elseif (!ManagerUtil::validaFecha($inConAse->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConAse->getFeTransaccion())) !== 8) {
                    $error = '0753';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getHoTransaccion()) !== '0' || strlen(trim($inConAse->getHoTransaccion())) < 4 || strlen(trim($inConAse->getHoTransaccion())) > 8) {
                    $error = '0754';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdCorrelativo()) !== '0' || strlen(trim($inConAse->getIdCorrelativo())) !== 9) {
                    $error = '0755';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdTransaccion()) !== '0' || strlen(trim($inConAse->getIdTransaccion())) !== 3) {
                    $error = '0756';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiFinalidad()) !== '0' || strlen(trim($inConAse->getTiFinalidad())) !== 2) {
                    $error = '0757';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaRemitente()) !== '0' || strlen(trim($inConAse->getCaRemitente())) !== 1 || (trim($inConAse->getCaRemitente()) !== '1' && trim($inConAse->getCaRemitente()) !== '2')) {
                    $error = '0758';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuRucRemitente()) !== '0' || strlen(trim($inConAse->getNuRucRemitente())) < 2 || strlen(trim($inConAse->getNuRucRemitente())) > 20 || trim($inConAse->getNuRucRemitente()) === '00000000000') {
                    $error = '0761';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getTxRequest()) !== '0' || strlen(trim($inConAse->getTxRequest())) < 1 || strlen(trim($inConAse->getTxRequest())) > 3) {
                    $error = '0765';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaReceptor()) !== '0' || strlen(trim($inConAse->getCaReceptor())) !== 1 || (trim($inConAse->getCaReceptor()) !== '1' && trim($inConAse->getCaReceptor()) !== '2')) {
                    $error = '0766';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaPaciente()) !== '0' || strlen(trim($inConAse->getCaPaciente())) !== 1 || (trim($inConAse->getCaPaciente()) !== '1' && trim($inConAse->getCaPaciente()) !== '2')) {
                    $error = '0800';
                } elseif ($buscarPorDNI === 'NO-OK') {
                    if (strlen(trim($inConAse->getApPaternoPaciente())) < 1 || strlen(trim($inConAse->getApPaternoPaciente())) > 60) {
                        $error = '0801';
                    } elseif (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                        $error = '0806';
                    } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                        $error = '0807';
                    }
                } elseif ($flagApPaciente) {
                    if (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                        $error = '0806';
                    } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                        $error = '0807';
                    }
                }
            }
        } elseif (strtolower(trim($nombreTx)) === 'cc') {
            if ('' === $inConAse->getNoTransaccion()) {
                $error = '0100';
            } elseif ('' === $inConAse->getIdRemitente()) {
                $error = '0101';
            } elseif ('' === $inConAse->getIdReceptor()) {
                $error = '0102';
            } elseif ('' === $inConAse->getFeTransaccion()) {
                $error = '0103';
            } elseif ('' === $inConAse->getHoTransaccion()) {
                $error = '0104';
            } elseif ('' === $inConAse->getIdCorrelativo()) {
                $error = '0105';
            } elseif ('' === $inConAse->getIdTransaccion()) {
                $error = '0106';
            } elseif ('' === $inConAse->getTiFinalidad()) {
                $error = '0107';
            } elseif ('' === $inConAse->getCaRemitente()) {
                $error = '0108';
            } elseif ('' === $inConAse->getNuRucRemitente()) {
                $error = '0111';
            } elseif ('' === $inConAse->getTxRequest()) {
                $error = '0115';
            } elseif ('' === $inConAse->getCaReceptor()) {
                $error = '0116';
            } elseif ('' === $inConAse->getCaPaciente()) {
                $error = '0150';
            } elseif ('' === $inConAse->getApPaternoPaciente()) {
                $error = '0151';
            } elseif ('' === $inConAse->getNoPaciente()) {
                $error = '0152';
            } elseif ('' === $inConAse->getCoAfPaciente()) {
                $error = '0153';
            } elseif ('' === $inConAse->getApMaternoPaciente()) {
                $error = '0154';
            } elseif ('' === $inConAse->getTiDocumento()) {
                $error = '0156';
            } elseif ('' === $inConAse->getNuDocumento()) {
                $error = '0157';
            } elseif ('' === $inConAse->getCoEspecialidad()) {
                $error = '0176';
            } elseif ('' === $inConAse->getCoParentesco()) {
                $error = '0173';
            } elseif ('' === $inConAse->getNuPlan()) {
                $error = '0170';
            } elseif ('' === $inConAse->getTiCaContratante()) {
                $error = '0350';
            } elseif ('' === $inConAse->getNoPaContratante()) {
                $error = '0351';
            } elseif ('' === $inConAse->getNoContratante()) {
                $error = '0353';
            } elseif ('' === $inConAse->getNoMaContratante()) {
                $error = '0354';
            } elseif ('' === $inConAse->getTiDoContratante()) {
                $error = '0355';
            } elseif ('' === $inConAse->getIdReContratante()) {
                $error = '0356';
            } elseif ('' === $inConAse->getCoReContratante()) {
                $error = '0357';
            }

            if ($error === '0000') {
                if (strlen(trim($inConAse->getNoTransaccion())) < 1 || strlen(trim($inConAse->getNoTransaccion())) > 60) {
                    $error = '0750';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getIdRemitente()) !== '0' || strlen($inConAse->getIdRemitente()) !== 15) {
                    $error = '0751';
                } elseif (strlen($inConAse->getIdReceptor()) !== 15) {
                    $error = '0752';
                } elseif (!ManagerUtil::validaFecha($inConAse->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConAse->getFeTransaccion())) !== 8) {
                    $error = '0753';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getHoTransaccion()) !== '0' || strlen(trim($inConAse->getHoTransaccion())) < 4 || strlen(trim($inConAse->getHoTransaccion())) > 8) {
                    $error = '0754';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdCorrelativo()) !== '0' || strlen(trim($inConAse->getIdCorrelativo())) !== 9) {
                    $error = '0755';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdTransaccion()) !== '0' || strlen(trim($inConAse->getIdTransaccion())) !== 3) {
                    $error = '0756';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiFinalidad()) !== '0' || strlen(trim($inConAse->getTiFinalidad())) !== 2) {
                    $error = '0757';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaRemitente()) !== '0' || strlen(trim($inConAse->getCaRemitente())) !== 1 || (trim($inConAse->getCaRemitente()) !== '1' && trim($inConAse->getCaRemitente()) !== '2')) {
                    $error = '0758';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuRucRemitente()) !== '0' || strlen(trim($inConAse->getNuRucRemitente())) < 2 || strlen(trim($inConAse->getNuRucRemitente())) > 20 || trim($inConAse->getNuRucRemitente()) === '00000000000') {
                    $error = '0761';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getTxRequest()) !== '0' || strlen(trim($inConAse->getTxRequest())) < 1 || strlen(trim($inConAse->getTxRequest())) > 3) {
                    $error = '0765';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaReceptor()) !== '0' || strlen(trim($inConAse->getCaReceptor())) !== 1 || (trim($inConAse->getCaReceptor()) !== '1' && trim($inConAse->getCaReceptor()) !== '2')) {
                    $error = '0766';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaPaciente()) !== '0' || strlen(trim($inConAse->getCaPaciente())) !== 1 || (trim($inConAse->getCaPaciente()) !== '1' && trim($inConAse->getCaPaciente()) !== '2')) {
                    $error = '0800';
                } elseif (strlen(trim($inConAse->getApPaternoPaciente())) < 1 || strlen(trim($inConAse->getApPaternoPaciente())) > 60) {
                    $error = '0801';
                } elseif (strlen(trim($inConAse->getNoPaciente())) < 1 || strlen(trim($inConAse->getNoPaciente())) > 35) {
                    $error = '0802';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoAfPaciente()) !== '0' || strlen(trim($inConAse->getCoAfPaciente())) < 2 || strlen(trim($inConAse->getCoAfPaciente())) > 20) {
                    $error = '0803';
                } elseif (strlen(trim($inConAse->getApMaternoPaciente())) < 1 || strlen(trim($inConAse->getApMaternoPaciente())) > 60) {
                    $error = '0804';
                } elseif (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                    $error = '0806';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                    $error = '0807';
                } elseif (strlen(trim($inConAse->getCoEspecialidad())) < 1 || strlen(trim($inConAse->getCoEspecialidad())) > 20) {
                    $error = '0825';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoParentesco()) !== '0' || strlen(trim($inConAse->getCoParentesco())) < 1 || strlen(trim($inConAse->getCoParentesco())) > 2) {
                    $error = '0821';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuPlan()) !== '0' || strlen(trim($inConAse->getNuPlan())) < 1 || strlen(trim($inConAse->getNuPlan())) > 20) {
                    $error = '0818';
                } elseif (strlen(trim($inConAse->getTiCaContratante())) !== 1 || (trim($inConAse->getTiCaContratante()) !== '1' && trim($inConAse->getTiCaContratante()) !== '2')) {
                    $error = '1050';
                } elseif (strlen(trim($inConAse->getNoPaContratante())) < 1 || strlen(trim($inConAse->getNoPaContratante())) > 60) {
                    $error = '1051';
                } elseif (strlen(trim($inConAse->getNoContratante())) < 1 || strlen(trim($inConAse->getNoContratante())) > 35) {
                    $error = '1053';
                } elseif (strlen(trim($inConAse->getNoMaContratante())) < 1 || strlen(trim($inConAse->getNoMaContratante())) > 60) {
                    $error = '1054';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiDoContratante()) !== '0' || strlen(trim($inConAse->getTiDoContratante())) < 1 || strlen(trim($inConAse->getTiDoContratante())) > 2) {
                    $error = '1055';
                } elseif (strlen(trim($inConAse->getIdReContratante())) < 2 || strlen(trim($inConAse->getIdReContratante())) > 3 || (trim($inConAse->getIdReContratante()) !== 'XX5' && trim($inConAse->getIdReContratante()) !== '4A')) {
                    $error = '1056';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoReContratante()) !== '0' || strlen(trim($inConAse->getCoReContratante())) < 1 || strlen(trim($inConAse->getCoReContratante())) > 20) {
                    $error = '1057';
                }
            }
        } elseif (strtolower(trim($nombreTx)) === 'rs') {
            if ('' === $inConAse->getNoTransaccion()) {
                $error = '0100';
            } elseif ('' === $inConAse->getIdRemitente()) {
                $error = '0101';
            } elseif ('' === $inConAse->getIdReceptor()) {
                $error = '0102';
            } elseif ('' === $inConAse->getFeTransaccion()) {
                $error = '0103';
            } elseif ('' === $inConAse->getHoTransaccion()) {
                $error = '0104';
            } elseif ('' === $inConAse->getIdCorrelativo()) {
                $error = '0105';
            } elseif ('' === $inConAse->getIdTransaccion()) {
                $error = '0106';
            } elseif ('' === $inConAse->getTiFinalidad()) {
                $error = '0107';
            } elseif ('' === $inConAse->getCaRemitente()) {
                $error = '0108';
            } elseif ('' === $inConAse->getNuRucRemitente()) {
                $error = '0109';
            } elseif ('' === $inConAse->getTxRequest()) {
                $error = '0113';
            } elseif ('' === $inConAse->getCaReceptor()) {
                $error = '0114';
            } elseif ('' === $inConAse->getCaPaciente()) {
                $error = '0150';
            } elseif ('' === $inConAse->getApPaternoPaciente()) {
                $error = '0151';
            } elseif ('' === $inConAse->getNoPaciente()) {
                $error = '0152';
            } elseif ('' === $inConAse->getCoAfPaciente()) {
                $error = '0153';
            } elseif ('' === $inConAse->getApMaternoPaciente()) {
                $error = '0154';
            } elseif ('' === $inConAse->getTiDocumento()) {
                $error = '0156';
            } elseif ('' === $inConAse->getNuDocumento()) {
                $error = '0157';
            } elseif ('' === $inConAse->getCoProducto()) {
                $error = '0164';
            } elseif ('' === $inConAse->getDeProducto()) {
                $error = '0165';
            } elseif ('' === $inConAse->getCoParentesco()) {
                $error = '0173';
            } elseif ('' === $inConAse->getNuPlan()) {
                $error = '0170';
            } elseif ('' === $inConAse->getTiCaContratante()) {
                $error = '0350';
            } elseif ('' === $inConAse->getNoPaContratante()) {
                $error = '0351';
            } elseif ('' === $inConAse->getNoContratante()) {
                $error = '0353';
            } elseif ('' === $inConAse->getNoMaContratante()) {
                $error = '0354';
            } elseif ('' === $inConAse->getTiDoContratante()) {
                $error = '0355';
            } elseif ('' === $inConAse->getIdReContratante()) {
                $error = '0356';
            } elseif ('' === $inConAse->getCoReContratante()) {
                $error = '0357';
            }

            if ($error === '0000') {
                if (strlen(trim($inConAse->getNoTransaccion())) < 1 || strlen(trim($inConAse->getNoTransaccion())) > 60) {
                    $error = '0750';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getIdRemitente()) !== '0' || strlen($inConAse->getIdRemitente()) !== 15) {
                    $error = '0751';
                } elseif (strlen($inConAse->getIdReceptor()) !== 15) {
                    $error = '0752';
                } elseif (!ManagerUtil::validaFecha($inConAse->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConAse->getFeTransaccion())) !== 8) {
                    $error = '0753';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getHoTransaccion()) !== '0' || strlen(trim($inConAse->getHoTransaccion())) < 4 || strlen(trim($inConAse->getHoTransaccion())) > 8) {
                    $error = '0754';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdCorrelativo()) !== '0' || strlen(trim($inConAse->getIdCorrelativo())) !== 9) {
                    $error = '0755';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdTransaccion()) !== '0' || strlen(trim($inConAse->getIdTransaccion())) !== 3) {
                    $error = '0756';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiFinalidad()) !== '0' || strlen(trim($inConAse->getTiFinalidad())) !== 2) {
                    $error = '0757';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaRemitente()) !== '0' || strlen(trim($inConAse->getCaRemitente())) !== 1 || (trim($inConAse->getCaRemitente()) !== '1' && trim($inConAse->getCaRemitente()) !== '2')) {
                    $error = '0758';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuRucRemitente()) !== '0' || strlen(trim($inConAse->getNuRucRemitente())) < 2 || strlen(trim($inConAse->getNuRucRemitente())) > 20 || trim($inConAse->getNuRucRemitente()) === '00000000000') {
                    $error = '0761';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getTxRequest()) !== '0' || strlen(trim($inConAse->getTxRequest())) < 1 || strlen(trim($inConAse->getTxRequest())) > 3) {
                    $error = '0765';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaReceptor()) !== '0' || strlen(trim($inConAse->getCaReceptor())) !== 1 || (trim($inConAse->getCaReceptor()) !== '1' && trim($inConAse->getCaReceptor()) !== '2')) {
                    $error = '0766';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaPaciente()) !== '0' || strlen(trim($inConAse->getCaPaciente())) !== 1 || (trim($inConAse->getCaPaciente()) !== '1' && trim($inConAse->getCaPaciente()) !== '2')) {
                    $error = '0800';
                } elseif (strlen(trim($inConAse->getApPaternoPaciente())) < 1 || strlen(trim($inConAse->getApPaternoPaciente())) > 60) {
                    $error = '0801';
                } elseif (strlen(trim($inConAse->getNoPaciente())) < 1 || strlen(trim($inConAse->getNoPaciente())) > 35) {
                    $error = '0802';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoAfPaciente()) !== '0' || strlen(trim($inConAse->getCoAfPaciente())) < 2 || strlen(trim($inConAse->getCoAfPaciente())) > 20) {
                    $error = '0803';
                } elseif (strlen(trim($inConAse->getApMaternoPaciente())) < 1 || strlen(trim($inConAse->getApMaternoPaciente())) > 60) {
                    $error = '0804';
                } elseif (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                    $error = '0806';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                    $error = '0807';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoProducto()) !== '0' || strlen(trim($inConAse->getCoProducto())) < 1 || strlen(trim($inConAse->getCoProducto())) > 20) {
                    $error = '0814';
                } elseif (strlen(trim($inConAse->getDeProducto())) < 1 || strlen(trim($inConAse->getDeProducto())) > 80) {
                    $error = '0815';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoParentesco()) !== '0' || strlen(trim($inConAse->getCoParentesco())) < 1 || strlen(trim($inConAse->getCoParentesco())) > 2) {
                    $error = '0821';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuPlan()) !== '0' || strlen(trim($inConAse->getNuPlan())) < 1 || strlen(trim($inConAse->getNuPlan())) > 20) {
                    $error = '0818';
                } elseif (strlen(trim($inConAse->getTiCaContratante())) !== 1 || (trim($inConAse->getTiCaContratante()) !== '1' && trim($inConAse->getTiCaContratante()) !== '2')) {
                    $error = '1050';
                } elseif (strlen(trim($inConAse->getNoPaContratante())) < 1 || strlen(trim($inConAse->getNoPaContratante())) > 60) {
                    $error = '1051';
                } elseif (strlen(trim($inConAse->getNoContratante())) < 1 || strlen(trim($inConAse->getNoContratante())) > 35) {
                    $error = '1053';
                } elseif (strlen(trim($inConAse->getNoMaContratante())) < 1 || strlen(trim($inConAse->getNoMaContratante())) > 60) {
                    $error = '1054';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiDoContratante()) !== '0' || strlen(trim($inConAse->getTiDoContratante())) < 1 || strlen(trim($inConAse->getTiDoContratante())) > 2) {
                    $error = '1055';
                } elseif (strlen(trim($inConAse->getIdReContratante())) < 2 || strlen(trim($inConAse->getIdReContratante())) > 3 || (trim($inConAse->getIdReContratante()) !== 'XX5' && trim($inConAse->getIdReContratante()) !== '4A')) {
                    $error = '1056';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoReContratante()) !== '0' || strlen(trim($inConAse->getCoReContratante())) < 1 || strlen(trim($inConAse->getCoReContratante())) > 20) {
                    $error = '1057';
                }
            }
        } elseif (strtolower(trim($nombreTx)) === 'rd') {
            if ('' === $inConAse->getNoTransaccion()) {
                $error = '0100';
            } elseif ('' === $inConAse->getIdRemitente()) {
                $error = '0101';
            } elseif ('' === $inConAse->getIdReceptor()) {
                $error = '0102';
            } elseif ('' === $inConAse->getFeTransaccion()) {
                $error = '0103';
            } elseif ('' === $inConAse->getHoTransaccion()) {
                $error = '0104';
            } elseif ('' === $inConAse->getIdCorrelativo()) {
                $error = '0105';
            } elseif ('' === $inConAse->getIdTransaccion()) {
                $error = '0106';
            } elseif ('' === $inConAse->getTiFinalidad()) {
                $error = '0107';
            } elseif ('' === $inConAse->getCaRemitente()) {
                $error = '0108';
            } elseif ('' === $inConAse->getNuRucRemitente()) {
                $error = '0109';
            } elseif ('' === $inConAse->getTxRequest()) {
                $error = '0113';
            } elseif ('' === $inConAse->getCaReceptor()) {
                $error = '0114';
            } elseif ('' === $inConAse->getCaPaciente()) {
                $error = '0150';
            } elseif ('' === $inConAse->getApPaternoPaciente()) {
                $error = '0151';
            } elseif ('' === $inConAse->getNoPaciente()) {
                $error = '0152';
            } elseif ('' === $inConAse->getCoAfPaciente()) {
                $error = '0153';
            } elseif ('' === $inConAse->getApMaternoPaciente()) {
                $error = '0154';
            } elseif ('' === $inConAse->getTiDocumento()) {
                $error = '0156';
            } elseif ('' === $inConAse->getNuDocumento()) {
                $error = '0157';
            } elseif ('' === $inConAse->getCoProducto()) {
                $error = '0164';
            } elseif ('' === $inConAse->getDeProducto()) {
                $error = '0165';
            } elseif ('' === $inConAse->getCoParentesco()) {
                $error = '0173';
            } elseif ('' === $inConAse->getNuPlan()) {
                $error = '0170';
            } elseif ('' === $inConAse->getTiCaContratante()) {
                $error = '0350';
            } elseif ('' === $inConAse->getNoPaContratante()) {
                $error = '0351';
            } elseif ('' === $inConAse->getNoContratante()) {
                $error = '0353';
            } elseif ('' === $inConAse->getNoMaContratante()) {
                $error = '0354';
            } elseif ('' === $inConAse->getTiDoContratante()) {
                $error = '0355';
            } elseif ('' === $inConAse->getIdReContratante()) {
                $error = '0356';
            } elseif ('' === $inConAse->getCoReContratante()) {
                $error = '0357';
            }

            if ($error === '0000') {
                if (strlen(trim($inConAse->getNoTransaccion())) < 1 || strlen(trim($inConAse->getNoTransaccion())) > 60) {
                    $error = '0750';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getIdRemitente()) !== '0' || strlen($inConAse->getIdRemitente()) !== 15) {
                    $error = '0751';
                } elseif (strlen($inConAse->getIdReceptor()) !== 15) {
                    $error = '0752';
                } elseif (!ManagerUtil::validaFecha($inConAse->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConAse->getFeTransaccion())) !== 8) {
                    $error = '0753';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getHoTransaccion()) !== '0' || strlen(trim($inConAse->getHoTransaccion())) < 4 || strlen(trim($inConAse->getHoTransaccion())) > 8) {
                    $error = '0754';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdCorrelativo()) !== '0' || strlen(trim($inConAse->getIdCorrelativo())) !== 9) {
                    $error = '0755';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdTransaccion()) !== '0' || strlen(trim($inConAse->getIdTransaccion())) !== 3) {
                    $error = '0756';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiFinalidad()) !== '0' || strlen(trim($inConAse->getTiFinalidad())) !== 2) {
                    $error = '0757';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaRemitente()) !== '0' || strlen(trim($inConAse->getCaRemitente())) !== 1 || (trim($inConAse->getCaRemitente()) !== '1' && trim($inConAse->getCaRemitente()) !== '2')) {
                    $error = '0758';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuRucRemitente()) !== '0' || strlen(trim($inConAse->getNuRucRemitente())) < 2 || strlen(trim($inConAse->getNuRucRemitente())) > 20 || trim($inConAse->getNuRucRemitente()) === '00000000000') {
                    $error = '0761';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getTxRequest()) !== '0' || strlen(trim($inConAse->getTxRequest())) < 1 || strlen(trim($inConAse->getTxRequest())) > 3) {
                    $error = '0765';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaReceptor()) !== '0' || strlen(trim($inConAse->getCaReceptor())) !== 1 || (trim($inConAse->getCaReceptor()) !== '1' && trim($inConAse->getCaReceptor()) !== '2')) {
                    $error = '0766';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaPaciente()) !== '0' || strlen(trim($inConAse->getCaPaciente())) !== 1 || (trim($inConAse->getCaPaciente()) !== '1' && trim($inConAse->getCaPaciente()) !== '2')) {
                    $error = '0800';
                } elseif (strlen(trim($inConAse->getApPaternoPaciente())) < 1 || strlen(trim($inConAse->getApPaternoPaciente())) > 60) {
                    $error = '0801';
                } elseif (strlen(trim($inConAse->getNoPaciente())) < 1 || strlen(trim($inConAse->getNoPaciente())) > 35) {
                    $error = '0802';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoAfPaciente()) !== '0' || strlen(trim($inConAse->getCoAfPaciente())) < 2 || strlen(trim($inConAse->getCoAfPaciente())) > 20) {
                    $error = '0803';
                } elseif (strlen(trim($inConAse->getApMaternoPaciente())) < 1 || strlen(trim($inConAse->getApMaternoPaciente())) > 60) {
                    $error = '0804';
                } elseif (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                    $error = '0806';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                    $error = '0723';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoProducto()) !== '0' || strlen(trim($inConAse->getCoProducto())) < 1 || strlen(trim($inConAse->getCoProducto())) > 20) {
                    $error = '0730';
                } elseif (strlen(trim($inConAse->getDeProducto())) < 1 || strlen(trim($inConAse->getDeProducto())) > 80) {
                    $error = '0731';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoParentesco()) !== '0' || strlen(trim($inConAse->getCoParentesco())) < 1 || strlen(trim($inConAse->getCoParentesco())) > 2) {
                    $error = '0821';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuPlan()) !== '0' || strlen(trim($inConAse->getNuPlan())) < 1 || strlen(trim($inConAse->getNuPlan())) > 20) {
                    $error = '0818';
                } elseif (strlen(trim($inConAse->getTiCaContratante())) !== 1 || (trim($inConAse->getTiCaContratante()) !== '1' && trim($inConAse->getTiCaContratante()) !== '2')) {
                    $error = '1050';
                } elseif (strlen(trim($inConAse->getNoPaContratante())) < 1 || strlen(trim($inConAse->getNoPaContratante())) > 60) {
                    $error = '1051';
                } elseif (strlen(trim($inConAse->getNoContratante())) < 1 || strlen(trim($inConAse->getNoContratante())) > 35) {
                    $error = '1053';
                } elseif (strlen(trim($inConAse->getNoMaContratante())) < 1 || strlen(trim($inConAse->getNoMaContratante())) > 60) {
                    $error = '1054';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiDoContratante()) !== '0' || strlen(trim($inConAse->getTiDoContratante())) < 1 || strlen(trim($inConAse->getTiDoContratante())) > 2) {
                    $error = '1055';
                } elseif (strlen(trim($inConAse->getIdReContratante())) < 2 || strlen(trim($inConAse->getIdReContratante())) > 3 || (trim($inConAse->getIdReContratante()) !== 'XX5' && trim($inConAse->getIdReContratante()) !== '4A')) {
                    $error = '1056';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoReContratante()) !== '0' || strlen(trim($inConAse->getCoReContratante())) < 1 || strlen(trim($inConAse->getCoReContratante())) > 20) {
                    $error = '1057';
                }
            }
        } elseif (strtolower(trim($nombreTx)) === 'cp') {
            // CP section - same structure as RS/RD
            if ('' === $inConAse->getNoTransaccion()) {
                $error = '0100';
            } elseif ('' === $inConAse->getIdRemitente()) {
                $error = '0101';
            } elseif ('' === $inConAse->getIdReceptor()) {
                $error = '0102';
            } elseif ('' === $inConAse->getFeTransaccion()) {
                $error = '0103';
            } elseif ('' === $inConAse->getHoTransaccion()) {
                $error = '0104';
            } elseif ('' === $inConAse->getIdCorrelativo()) {
                $error = '0105';
            } elseif ('' === $inConAse->getIdTransaccion()) {
                $error = '0106';
            } elseif ('' === $inConAse->getTiFinalidad()) {
                $error = '0107';
            } elseif ('' === $inConAse->getCaRemitente()) {
                $error = '0108';
            } elseif ('' === $inConAse->getNuRucRemitente()) {
                $error = '0109';
            } elseif ('' === $inConAse->getTxRequest()) {
                $error = '0113';
            } elseif ('' === $inConAse->getCaReceptor()) {
                $error = '0114';
            } elseif ('' === $inConAse->getCaPaciente()) {
                $error = '0150';
            } elseif ('' === $inConAse->getApPaternoPaciente()) {
                $error = '0151';
            } elseif ('' === $inConAse->getNoPaciente()) {
                $error = '0152';
            } elseif ('' === $inConAse->getCoAfPaciente()) {
                $error = '0153';
            } elseif ('' === $inConAse->getApMaternoPaciente()) {
                $error = '0154';
            } elseif ('' === $inConAse->getTiDocumento()) {
                $error = '0156';
            } elseif ('' === $inConAse->getNuDocumento()) {
                $error = '0157';
            } elseif ('' === $inConAse->getCoProducto()) {
                $error = '0164';
            } elseif ('' === $inConAse->getDeProducto()) {
                $error = '0165';
            } elseif ('' === $inConAse->getCoParentesco()) {
                $error = '0173';
            } elseif ('' === $inConAse->getNuPlan()) {
                $error = '0170';
            } elseif ('' === $inConAse->getTiCaContratante()) {
                $error = '0350';
            } elseif ('' === $inConAse->getNoPaContratante()) {
                $error = '0351';
            } elseif ('' === $inConAse->getNoContratante()) {
                $error = '0353';
            } elseif ('' === $inConAse->getNoMaContratante()) {
                $error = '0354';
            } elseif ('' === $inConAse->getTiDoContratante()) {
                $error = '0355';
            } elseif ('' === $inConAse->getIdReContratante()) {
                $error = '0356';
            } elseif ('' === $inConAse->getCoReContratante()) {
                $error = '0357';
            }

            if ($error === '0000') {
                if (strlen(trim($inConAse->getNoTransaccion())) < 1 || strlen(trim($inConAse->getNoTransaccion())) > 60) {
                    $error = '0750';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getIdRemitente()) !== '0' || strlen($inConAse->getIdRemitente()) !== 15) {
                    $error = '0751';
                } elseif (strlen($inConAse->getIdReceptor()) !== 15) {
                    $error = '0752';
                } elseif (!ManagerUtil::validaFecha($inConAse->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConAse->getFeTransaccion())) !== 8) {
                    $error = '0753';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getHoTransaccion()) !== '0' || strlen(trim($inConAse->getHoTransaccion())) < 4 || strlen(trim($inConAse->getHoTransaccion())) > 8) {
                    $error = '0754';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdCorrelativo()) !== '0' || strlen(trim($inConAse->getIdCorrelativo())) !== 9) {
                    $error = '0755';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getIdTransaccion()) !== '0' || strlen(trim($inConAse->getIdTransaccion())) !== 3) {
                    $error = '0756';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiFinalidad()) !== '0' || strlen(trim($inConAse->getTiFinalidad())) !== 2) {
                    $error = '0757';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaRemitente()) !== '0' || strlen(trim($inConAse->getCaRemitente())) !== 1 || (trim($inConAse->getCaRemitente()) !== '1' && trim($inConAse->getCaRemitente()) !== '2')) {
                    $error = '0758';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuRucRemitente()) !== '0' || strlen(trim($inConAse->getNuRucRemitente())) < 2 || strlen(trim($inConAse->getNuRucRemitente())) > 20 || trim($inConAse->getNuRucRemitente()) === '00000000000') {
                    $error = '0761';
                } elseif (ManagerUtil::validaAlfanumerico($inConAse->getTxRequest()) !== '0' || strlen(trim($inConAse->getTxRequest())) < 1 || strlen(trim($inConAse->getTxRequest())) > 3) {
                    $error = '0765';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaReceptor()) !== '0' || strlen(trim($inConAse->getCaReceptor())) !== 1 || (trim($inConAse->getCaReceptor()) !== '1' && trim($inConAse->getCaReceptor()) !== '2')) {
                    $error = '0766';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCaPaciente()) !== '0' || strlen(trim($inConAse->getCaPaciente())) !== 1 || (trim($inConAse->getCaPaciente()) !== '1' && trim($inConAse->getCaPaciente()) !== '2')) {
                    $error = '0800';
                } elseif (strlen(trim($inConAse->getApPaternoPaciente())) < 1 || strlen(trim($inConAse->getApPaternoPaciente())) > 60) {
                    $error = '0801';
                } elseif (strlen(trim($inConAse->getNoPaciente())) < 1 || strlen(trim($inConAse->getNoPaciente())) > 35) {
                    $error = '0802';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoAfPaciente()) !== '0' || strlen(trim($inConAse->getCoAfPaciente())) < 2 || strlen(trim($inConAse->getCoAfPaciente())) > 20) {
                    $error = '0803';
                } elseif (strlen(trim($inConAse->getApMaternoPaciente())) < 1 || strlen(trim($inConAse->getApMaternoPaciente())) > 60) {
                    $error = '0804';
                } elseif (strlen(trim($inConAse->getTiDocumento())) < 1 || strlen(trim($inConAse->getTiDocumento())) > 2) {
                    $error = '0806';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuDocumento()) !== '0' || strlen(trim($inConAse->getNuDocumento())) !== 8) {
                    $error = '0723';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoProducto()) !== '0' || strlen(trim($inConAse->getCoProducto())) < 1 || strlen(trim($inConAse->getCoProducto())) > 20) {
                    $error = '0730';
                } elseif (strlen(trim($inConAse->getDeProducto())) < 1 || strlen(trim($inConAse->getDeProducto())) > 80) {
                    $error = '0731';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoParentesco()) !== '0' || strlen(trim($inConAse->getCoParentesco())) < 1 || strlen(trim($inConAse->getCoParentesco())) > 2) {
                    $error = '0821';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getNuPlan()) !== '0' || strlen(trim($inConAse->getNuPlan())) < 1 || strlen(trim($inConAse->getNuPlan())) > 20) {
                    $error = '0818';
                } elseif (strlen(trim($inConAse->getTiCaContratante())) !== 1 || (trim($inConAse->getTiCaContratante()) !== '1' && trim($inConAse->getTiCaContratante()) !== '2')) {
                    $error = '1050';
                } elseif (strlen(trim($inConAse->getNoPaContratante())) < 1 || strlen(trim($inConAse->getNoPaContratante())) > 60) {
                    $error = '1051';
                } elseif (strlen(trim($inConAse->getNoContratante())) < 1 || strlen(trim($inConAse->getNoContratante())) > 35) {
                    $error = '1053';
                } elseif (strlen(trim($inConAse->getNoMaContratante())) < 1 || strlen(trim($inConAse->getNoMaContratante())) > 60) {
                    $error = '1054';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getTiDoContratante()) !== '0' || strlen(trim($inConAse->getTiDoContratante())) < 1 || strlen(trim($inConAse->getTiDoContratante())) > 2) {
                    $error = '1055';
                } elseif (strlen(trim($inConAse->getIdReContratante())) < 2 || strlen(trim($inConAse->getIdReContratante())) > 3 || (trim($inConAse->getIdReContratante()) !== 'XX5' && trim($inConAse->getIdReContratante()) !== '4A')) {
                    $error = '1056';
                } elseif (ManagerUtil::validaSoloDigito($inConAse->getCoReContratante()) !== '0' || strlen(trim($inConAse->getCoReContratante())) < 1 || strlen(trim($inConAse->getCoReContratante())) > 20) {
                    $error = '1057';
                }
            }
        }

        return $error;
    }
}
