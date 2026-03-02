<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In271ConDtad;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConDtadValidator
{
    /**
     * @param In271ConDtad $inConDtad
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConDtad)
    {
        $error = '0000';

        if ('' === $inConDtad->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConDtad->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConDtad->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConDtad->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConDtad->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConDtad->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConDtad->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConDtad->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConDtad->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inConDtad->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inConDtad->getNuRucReceptor()) {
            $error = '0117';
        } elseif ('' === $inConDtad->getCaPaciente()) {
            $error = '0150';
        } elseif ('' === $inConDtad->getApPaternoPaciente()) {
            $error = '0151';
        } elseif ('' === $inConDtad->getNoPaciente()) {
            $error = '0152';
        } elseif ('' === $inConDtad->getCoAfPaciente()) {
            $error = '0153';
        } elseif ('' === $inConDtad->getApMaternoPaciente()) {
            $error = '0154';
        } elseif ('' === $inConDtad->getDeDirPaciente1()) {
            $error = '0182';
        } elseif ('' === $inConDtad->getCoUbigeoPaciente()) {
            $error = '0184';
        } elseif ('' === $inConDtad->getTiCaCalificador()) {
            $error = '0188';
        } elseif ('' === $inConDtad->getApPaNoEmCalificador()) {
            $error = '0189';
        } elseif ('' === $inConDtad->getNoEmCalificador()) {
            $error = '0190';
        } elseif ('' === $inConDtad->getApMaCalificador()) {
            $error = '0191';
        }

        if ($error === '0000') {
            if (strlen(trim($inConDtad->getNoTransaccion())) < 1 || strlen(trim($inConDtad->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConDtad->getIdRemitente()) !== '0' || strlen($inConDtad->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConDtad->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConDtad->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConDtad->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getHoTransaccion()) !== '0' || strlen(trim($inConDtad->getHoTransaccion())) < 4 || strlen(trim($inConDtad->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getIdCorrelativo()) !== '0' || strlen(trim($inConDtad->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getIdTransaccion()) !== '0' || strlen(trim($inConDtad->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getTiFinalidad()) !== '0' || strlen(trim($inConDtad->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (strlen(trim($inConDtad->getCaRemitente())) !== 1 || (trim($inConDtad->getCaRemitente()) !== '1' && trim($inConDtad->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getCaReceptor()) !== '0' || strlen(trim($inConDtad->getCaReceptor())) !== 1 || (trim($inConDtad->getCaReceptor()) !== '1' && trim($inConDtad->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getNuRucReceptor()) !== '0' || strlen(trim($inConDtad->getNuRucReceptor())) < 2 || strlen(trim($inConDtad->getNuRucReceptor())) > 20 || trim($inConDtad->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getCaPaciente()) !== '0' || strlen(trim($inConDtad->getCaPaciente())) !== 1 || (trim($inConDtad->getCaPaciente()) !== '1' && trim($inConDtad->getCaPaciente()) !== '2')) {
                $error = '0800';
            } elseif (strlen(trim($inConDtad->getApPaternoPaciente())) < 1 || strlen(trim($inConDtad->getApPaternoPaciente())) > 60) {
                $error = '0801';
            } elseif (strlen(trim($inConDtad->getNoPaciente())) < 1 || strlen(trim($inConDtad->getNoPaciente())) > 35) {
                $error = '0802';
            } elseif (strlen(trim($inConDtad->getCoAfPaciente())) < 2 || strlen(trim($inConDtad->getCoAfPaciente())) > 20) {
                $error = '0803';
            } elseif (strlen(trim($inConDtad->getApMaternoPaciente())) < 1 || strlen(trim($inConDtad->getApMaternoPaciente())) > 60) {
                $error = '0804';
            } elseif (strlen($inConDtad->getDeDirPaciente1()) < 1 || strlen(trim($inConDtad->getDeDirPaciente1())) > 55) {
                $error = '0830';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getCoUbigeoPaciente()) !== '0' || strlen(trim($inConDtad->getCoUbigeoPaciente())) < 1 || strlen(trim($inConDtad->getCoUbigeoPaciente())) > 30) {
                $error = '0832';
            } elseif (ManagerUtil::validaSoloDigito($inConDtad->getTiCaCalificador()) !== '0' || strlen(trim($inConDtad->getTiCaCalificador())) !== 1) {
                $error = '0836';
            } elseif (strlen(trim($inConDtad->getApPaNoEmCalificador())) < 1 || strlen(trim($inConDtad->getApPaNoEmCalificador())) > 60) {
                $error = '0837';
            } elseif (strlen(trim($inConDtad->getNoEmCalificador())) < 1 || strlen(trim($inConDtad->getNoEmCalificador())) > 35) {
                $error = '0838';
            } elseif (strlen(trim($inConDtad->getApMaCalificador())) < 1 || strlen(trim($inConDtad->getApMaCalificador())) > 60) {
                $error = '0839';
            }
        }

        return $error;
    }
}
