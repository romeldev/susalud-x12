<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConProc271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConProcValidator
{
    /**
     * @param InConProc271 $inConProc
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConProc)
    {
        $error = '0000';

        if ('' === $inConProc->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConProc->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConProc->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConProc->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConProc->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConProc->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConProc->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConProc->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConProc->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inConProc->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inConProc->getNuRucReceptor()) {
            $error = '0117';
        } else {
            $list = $inConProc->getInConProc271Detalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getCoInProcedimiento()) {
                    $error = '0500';
                }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inConProc->getNoTransaccion())) < 1 || strlen(trim($inConProc->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConProc->getIdRemitente()) !== '0' || strlen($inConProc->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConProc->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConProc->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConProc->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getHoTransaccion()) !== '0' || strlen(trim($inConProc->getHoTransaccion())) < 4 || strlen(trim($inConProc->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getIdCorrelativo()) !== '0' || strlen(trim($inConProc->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getIdTransaccion()) !== '0' || strlen(trim($inConProc->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getTiFinalidad()) !== '0' || strlen(trim($inConProc->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getCaRemitente()) !== '0' || strlen(trim($inConProc->getCaRemitente())) !== 1 || (trim($inConProc->getCaRemitente()) !== '1' && trim($inConProc->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getCaReceptor()) !== '0' || strlen(trim($inConProc->getCaReceptor())) !== 1 || (trim($inConProc->getCaReceptor()) !== '1' && trim($inConProc->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inConProc->getNuRucReceptor()) !== '0' || strlen(trim($inConProc->getNuRucReceptor())) < 2 || strlen(trim($inConProc->getNuRucReceptor())) > 20 || trim($inConProc->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } else {
                $list = $inConProc->getInConProc271Detalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (ManagerUtil::validaSoloDigito($det->getCoInProcedimiento()) !== '0' || strlen(trim($det->getCoInProcedimiento())) !== 2) {
                        $error = '1200';
                    }
                }
            }
        }

        return $error;
    }
}
