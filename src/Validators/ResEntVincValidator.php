<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InResEntVinc278;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ResEntVincValidator
{
    /**
     * @param InResEntVinc278 $inResEntVinc
     * @return string Error code or "0000" if valid
     */
    public static function validate($inResEntVinc)
    {
        $error = '0000';

        if ('' === $inResEntVinc->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inResEntVinc->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inResEntVinc->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inResEntVinc->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inResEntVinc->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inResEntVinc->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inResEntVinc->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inResEntVinc->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inResEntVinc->getRespuesta()) {
            $error = '0129';
        } elseif ('' === $inResEntVinc->getMsgRespuesta()) {
            $error = '0130';
        }

        if ($error === '0000') {
            if (strlen(trim($inResEntVinc->getNoTransaccion())) < 1 || strlen(trim($inResEntVinc->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inResEntVinc->getIdRemitente()) !== '0' || strlen($inResEntVinc->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inResEntVinc->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inResEntVinc->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inResEntVinc->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inResEntVinc->getHoTransaccion()) !== '0' || strlen(trim($inResEntVinc->getHoTransaccion())) < 4 || strlen(trim($inResEntVinc->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inResEntVinc->getIdCorrelativo()) !== '0' || strlen(trim($inResEntVinc->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inResEntVinc->getIdTransaccion()) !== '0' || strlen(trim($inResEntVinc->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inResEntVinc->getTiFinalidad()) !== '0' || strlen(trim($inResEntVinc->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaAlfanumerico($inResEntVinc->getRespuesta()) !== '0' || strlen(trim($inResEntVinc->getRespuesta())) !== 1) {
                $error = '0779';
            } elseif (ManagerUtil::validaAlfanumerico($inResEntVinc->getMsgRespuesta()) !== '0' || strlen(trim($inResEntVinc->getMsgRespuesta())) < 1 || strlen(trim($inResEntVinc->getMsgRespuesta())) > 80) {
                $error = '0780';
            }
        }

        return $error;
    }
}
