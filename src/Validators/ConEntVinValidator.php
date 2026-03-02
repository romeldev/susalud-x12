<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConEntVinc278;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConEntVinValidator
{
    /**
     * @param InConEntVinc278 $inConEntVinc
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConEntVinc)
    {
        $error = '0000';

        if ('' === $inConEntVinc->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConEntVinc->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConEntVinc->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConEntVinc->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConEntVinc->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConEntVinc->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConEntVinc->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConEntVinc->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConEntVinc->getCaIPRESS()) {
            $error = '0108';
        } elseif ('' === $inConEntVinc->getNoIPRESS()) {
            $error = '0109';
        } elseif ('' === $inConEntVinc->getTiDoIPRESS()) {
            $error = '0110';
        } elseif ('' === $inConEntVinc->getNuRucIPRESS()) {
            $error = '0111';
        }

        if ($error === '0000') {
            if (strlen(trim($inConEntVinc->getNoTransaccion())) < 1 || strlen(trim($inConEntVinc->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConEntVinc->getIdRemitente()) !== '0' || strlen($inConEntVinc->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConEntVinc->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConEntVinc->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConEntVinc->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getHoTransaccion()) !== '0' || strlen(trim($inConEntVinc->getHoTransaccion())) < 4 || strlen(trim($inConEntVinc->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getIdCorrelativo()) !== '0' || strlen(trim($inConEntVinc->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getIdTransaccion()) !== '0' || strlen(trim($inConEntVinc->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getTiFinalidad()) !== '0' || strlen(trim($inConEntVinc->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (strlen(trim($inConEntVinc->getCaIPRESS())) !== 1 || (trim($inConEntVinc->getCaIPRESS()) !== '1' && trim($inConEntVinc->getCaIPRESS()) !== '2')) {
                $error = '0758';
            } elseif (strlen(trim($inConEntVinc->getNoIPRESS())) < 1 || strlen(trim($inConEntVinc->getNoIPRESS())) > 35) {
                $error = '0759';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getTiDoIPRESS()) !== '0' || strlen(trim($inConEntVinc->getTiDoIPRESS())) < 1 || strlen(trim($inConEntVinc->getTiDoIPRESS())) > 2) {
                $error = '0760';
            } elseif (ManagerUtil::validaSoloDigito($inConEntVinc->getNuRucIPRESS()) !== '0' || strlen(trim($inConEntVinc->getNuRucIPRESS())) < 2 || strlen(trim($inConEntVinc->getNuRucIPRESS())) > 20 || trim($inConEntVinc->getNuRucIPRESS()) === '00000000000') {
                $error = '0761';
            }
        }

        return $error;
    }
}
