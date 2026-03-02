<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConMed271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConMedValidator
{
    /**
     * @param InConMed271 $inConMed
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConMed)
    {
        $error = '0000';

        if ('' === $inConMed->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConMed->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConMed->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConMed->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConMed->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConMed->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConMed->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConMed->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConMed->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inConMed->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inConMed->getNuRucReceptor()) {
            $error = '0117';
        }

        if ($error === '0000') {
            if (strlen(trim($inConMed->getNoTransaccion())) < 1 || strlen(trim($inConMed->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConMed->getIdRemitente()) !== '0' || strlen($inConMed->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConMed->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConMed->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConMed->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getHoTransaccion()) !== '0' || strlen(trim($inConMed->getHoTransaccion())) < 4 || strlen(trim($inConMed->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getIdCorrelativo()) !== '0' || strlen(trim($inConMed->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getIdTransaccion()) !== '0' || strlen(trim($inConMed->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getTiFinalidad()) !== '0' || strlen(trim($inConMed->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (strlen(trim($inConMed->getCaRemitente())) !== 1 || (trim($inConMed->getCaRemitente()) !== '1' && trim($inConMed->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getCaReceptor()) !== '0' || strlen(trim($inConMed->getCaReceptor())) !== 1 || (trim($inConMed->getCaReceptor()) !== '1' && trim($inConMed->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inConMed->getNuRucReceptor()) !== '0' || strlen(trim($inConMed->getNuRucReceptor())) < 2 || strlen(trim($inConMed->getNuRucReceptor())) > 20 || trim($inConMed->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            }
        }

        return $error;
    }
}
