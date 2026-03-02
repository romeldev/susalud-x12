<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In278SolCG;
use Romeldev\SusaludX12\Support\ManagerUtil;

class SolCGValidator
{
    /**
     * @param In278SolCG $inSolCG
     * @return string Error code or "0000" if valid
     */
    public static function validate($inSolCG)
    {
        $error = '0000';

        if ('' === $inSolCG->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inSolCG->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inSolCG->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inSolCG->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inSolCG->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inSolCG->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inSolCG->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inSolCG->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inSolCG->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inSolCG->getNuSoCarGarantia()) {
            $error = '0469';
        } elseif ('' === $inSolCG->getEsCarGarantia()) {
            $error = '0472';
        }

        if ($error === '0000') {
            if (strlen(trim($inSolCG->getNoTransaccion())) < 1 || strlen(trim($inSolCG->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inSolCG->getIdRemitente()) !== '0' || strlen($inSolCG->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inSolCG->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inSolCG->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inSolCG->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getHoTransaccion()) !== '0' || strlen(trim($inSolCG->getHoTransaccion())) < 4 || strlen(trim($inSolCG->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getIdCorrelativo()) !== '0' || strlen(trim($inSolCG->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getIdTransaccion()) !== '0' || strlen(trim($inSolCG->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getTiFinalidad()) !== '0' || strlen(trim($inSolCG->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getCaPaciente()) !== '0' || strlen(trim($inSolCG->getCaPaciente())) !== 1 || (trim($inSolCG->getCaPaciente()) !== '1' && trim($inSolCG->getCaPaciente()) !== '2')) {
                $error = '0800';
            } elseif (strlen(trim($inSolCG->getNuSoCarGarantia())) < 1 || strlen(trim($inSolCG->getNuSoCarGarantia())) > 20) {
                $error = '1169';
            } elseif (ManagerUtil::validaSoloDigito($inSolCG->getEsCarGarantia()) !== '0' || strlen(trim($inSolCG->getEsCarGarantia())) < 1 || strlen(trim($inSolCG->getEsCarGarantia())) > 2) {
                $error = '1172';
            }
        }

        return $error;
    }
}
