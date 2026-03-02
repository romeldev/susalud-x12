<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In997ResAut;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ResAutValidator
{
    /**
     * @param In997ResAut $inResAut
     * @return string Error code or "0000" if valid
     */
    public static function validate($inResAut)
    {
        $error = '0000';

        if ('' === $inResAut->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inResAut->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inResAut->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inResAut->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inResAut->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inResAut->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inResAut->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inResAut->getNuAutorizacion()) {
            $error = '0124';
        } elseif ('' === $inResAut->getCoError()) {
            $error = '0127';
        } elseif ('' === $inResAut->getInCoErrorEncontrado()) {
            $error = '0128';
        }

        if ($error === '0000') {
            if (strlen(trim($inResAut->getNoTransaccion())) < 1 || strlen(trim($inResAut->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inResAut->getIdRemitente()) !== '0' || strlen($inResAut->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inResAut->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inResAut->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inResAut->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inResAut->getHoTransaccion()) !== '0' || strlen(trim($inResAut->getHoTransaccion())) < 4 || strlen(trim($inResAut->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inResAut->getIdCorrelativo()) !== '0' || strlen(trim($inResAut->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inResAut->getIdTransaccion()) !== '0' || strlen(trim($inResAut->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaAlfanumerico($inResAut->getNuAutorizacion()) !== '0' || strlen(trim($inResAut->getNuAutorizacion())) < 1 || strlen(trim($inResAut->getNuAutorizacion())) > 20) {
                $error = '0774';
            } elseif (ManagerUtil::validaAlfanumerico($inResAut->getCoError()) !== '0' || strlen(trim($inResAut->getCoError())) !== 1) {
                $error = '0777';
            } elseif (ManagerUtil::validaSoloDigito($inResAut->getInCoErrorEncontrado()) !== '0' || strlen(trim($inResAut->getInCoErrorEncontrado())) < 1 || strlen(trim($inResAut->getInCoErrorEncontrado())) > 3) {
                $error = '0778';
            }
        }

        return $error;
    }
}
