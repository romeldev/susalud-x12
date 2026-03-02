<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In271ConObs;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConObsValidator
{
    /**
     * @param In271ConObs $inConObs
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConObs)
    {
        $error = '0000';

        if ('' === $inConObs->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConObs->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConObs->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConObs->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConObs->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConObs->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConObs->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConObs->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConObs->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inConObs->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inConObs->getNuRucReceptor()) {
            $error = '0117';
        } elseif ('' === $inConObs->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inConObs->getApPaternoPaciente()) {
            $error = '0151';
        } elseif ('' === $inConObs->getNoPaciente()) {
            $error = '0152';
        } elseif ('' === $inConObs->getCoAfPaciente()) {
            $error = '0153';
        } elseif ('' === $inConObs->getApMaternoPaciente()) {
            $error = '0154';
        } elseif ('' === $inConObs->getTeMsgLibre1()) {
            $error = '0461';
        }

        if ($error === '0000') {
            if (strlen(trim($inConObs->getNoTransaccion())) < 1 || strlen(trim($inConObs->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConObs->getIdRemitente()) !== '0' || strlen($inConObs->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConObs->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConObs->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConObs->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getHoTransaccion()) !== '0' || strlen(trim($inConObs->getHoTransaccion())) < 4 || strlen(trim($inConObs->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getIdCorrelativo()) !== '0' || strlen(trim($inConObs->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getIdTransaccion()) !== '0' || strlen(trim($inConObs->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getTiFinalidad()) !== '0' || strlen(trim($inConObs->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (strlen(trim($inConObs->getCaRemitente())) !== 1 || (trim($inConObs->getCaRemitente()) !== '1' && trim($inConObs->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getCaReceptor()) !== '0' || strlen(trim($inConObs->getCaReceptor())) !== 1 || (trim($inConObs->getCaReceptor()) !== '1' && trim($inConObs->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getNuRucReceptor()) !== '0' || strlen(trim($inConObs->getNuRucReceptor())) < 2 || strlen(trim($inConObs->getNuRucReceptor())) > 20 || trim($inConObs->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } elseif (strlen(trim($inConObs->getCaPaciente())) !== 1 || (trim($inConObs->getCaPaciente()) !== '1' && trim($inConObs->getCaPaciente()) !== '2')) {
                $error = '0800';
            } elseif (strlen(trim($inConObs->getApPaternoPaciente())) < 1 || strlen(trim($inConObs->getApPaternoPaciente())) > 60) {
                $error = '0801';
            } elseif (strlen(trim($inConObs->getNoPaciente())) < 1 || strlen(trim($inConObs->getNoPaciente())) > 35) {
                $error = '0802';
            } elseif (ManagerUtil::validaSoloDigito($inConObs->getCoAfPaciente()) !== '0' || strlen(trim($inConObs->getCoAfPaciente())) < 2 || strlen(trim($inConObs->getCoAfPaciente())) > 20) {
                $error = '0803';
            } elseif (strlen(trim($inConObs->getApMaternoPaciente())) < 1 || strlen(trim($inConObs->getApMaternoPaciente())) > 60) {
                $error = '0804';
            } elseif (strlen(trim($inConObs->getTeMsgLibre1())) < 1 || strlen(trim($inConObs->getTeMsgLibre1())) > 264) {
                $error = '1161';
            }
        }

        return $error;
    }
}
