<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InRegAfi270;
use Romeldev\SusaludX12\Support\ManagerUtil;

class RegAfi270Validator
{
    /**
     * @param InRegAfi270 $inRegAfi270
     * @return string Error code or "0000" if valid
     */
    public static function validate($inRegAfi270)
    {
        $buscarPorDNI = 'OK';
        $error = '0000';
        $flagApPaciente1 = false;
        $flagApPaciente2 = false;

        if ('' === $inRegAfi270->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inRegAfi270->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inRegAfi270->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inRegAfi270->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inRegAfi270->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inRegAfi270->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inRegAfi270->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inRegAfi270->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inRegAfi270->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inRegAfi270->getNuRucRemitente()) {
            $error = '';
        } elseif ('' === $inRegAfi270->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inRegAfi270->getApPaternoPaciente() || '' === $inRegAfi270->getApMaternoPaciente() || '' === $inRegAfi270->getCaPaciente()) {
            $flagApPaciente1 = true;
            if ('' === $inRegAfi270->getTiDocumento() && '' === $inRegAfi270->getNuDocumento()) {
                if ('' === $inRegAfi270->getCaPaciente()) {
                    $error = '0150';
                    $buscarPorDNI = 'NO-OK';
                }
                if ('' === $inRegAfi270->getApPaternoPaciente()) {
                    $error = '0151';
                    $buscarPorDNI = 'NO-OK';
                }
                if ('' === $inRegAfi270->getApMaternoPaciente()) {
                    $error = '0154';
                    $buscarPorDNI = 'NO-OK';
                }
            } else {
                $flagApPaciente2 = true;
                if ('' === $inRegAfi270->getTiDocumento()) {
                    $error = '0156';
                } elseif ('' === $inRegAfi270->getNuDocumento()) {
                    $error = '0157';
                }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inRegAfi270->getNoTransaccion())) < 1 || strlen(trim($inRegAfi270->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inRegAfi270->getIdRemitente()) !== '0' || strlen($inRegAfi270->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inRegAfi270->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inRegAfi270->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inRegAfi270->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getHoTransaccion()) !== '0' || strlen(trim($inRegAfi270->getHoTransaccion())) < 4 || strlen(trim($inRegAfi270->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getIdCorrelativo()) !== '0' || strlen(trim($inRegAfi270->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getIdTransaccion()) !== '0' || strlen(trim($inRegAfi270->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getTiFinalidad()) !== '0' || strlen(trim($inRegAfi270->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getCaRemitente()) !== '0' || strlen(trim($inRegAfi270->getCaRemitente())) !== 1 || (trim($inRegAfi270->getCaRemitente()) !== '1' && trim($inRegAfi270->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getNuRucRemitente()) !== '0' || strlen(trim($inRegAfi270->getNuRucRemitente())) < 2 || strlen(trim($inRegAfi270->getNuRucRemitente())) > 20 || trim($inRegAfi270->getNuRucRemitente()) === '00000000000') {
                $error = '0761';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getCaReceptor()) !== '0' || strlen(trim($inRegAfi270->getCaReceptor())) !== 1 || (trim($inRegAfi270->getCaReceptor()) !== '1' && trim($inRegAfi270->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (!$flagApPaciente1) {
                if (ManagerUtil::validaSoloDigito($inRegAfi270->getCaPaciente()) !== '0' || strlen(trim($inRegAfi270->getCaPaciente())) !== 1 || (trim($inRegAfi270->getCaPaciente()) !== '1' && trim($inRegAfi270->getCaPaciente()) !== '2')) {
                    $error = '0800';
                }
            } elseif ($buscarPorDNI === 'NO-OK') {
                if (ManagerUtil::validaSoloDigito($inRegAfi270->getCaPaciente()) !== '0' || strlen(trim($inRegAfi270->getCaPaciente())) !== 1 || (trim($inRegAfi270->getCaPaciente()) !== '1' && trim($inRegAfi270->getCaPaciente()) !== '2')) {
                    $error = '0800';
                }
                if (strlen(trim($inRegAfi270->getApPaternoPaciente())) < 1 || strlen(trim($inRegAfi270->getApPaternoPaciente())) > 60) {
                    $error = '0801';
                }
                if (strlen(trim($inRegAfi270->getApMaternoPaciente())) < 1 || strlen(trim($inRegAfi270->getApMaternoPaciente())) > 60) {
                    $error = '0804';
                }
            } elseif ($flagApPaciente2) {
                if (strlen($inRegAfi270->getTiDocumento()) < 1 || strlen($inRegAfi270->getTiDocumento()) > 2) {
                    $error = '0806';
                } elseif (ManagerUtil::validaSoloDigito($inRegAfi270->getNuDocumento()) !== '0' || strlen(trim($inRegAfi270->getNuDocumento())) !== 8) {
                    $error = '0807';
                }
            }
        }

        return $error;
    }
}
