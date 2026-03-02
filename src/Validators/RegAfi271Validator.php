<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InRegAfi271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class RegAfi271Validator
{
    /**
     * @param InRegAfi271 $inRegAfi271
     * @return string Error code or "0000" if valid
     */
    public static function validate($inRegAfi271)
    {
        $error = '0000';

        if ('' === $inRegAfi271->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inRegAfi271->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inRegAfi271->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inRegAfi271->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inRegAfi271->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inRegAfi271->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inRegAfi271->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inRegAfi271->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inRegAfi271->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inRegAfi271->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inRegAfi271->getNuRucReceptor()) {
            $error = '0117';
        } else {
            $list = $inRegAfi271->getInRegAfi271Detalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getCaPaciente()) { $error = '0150'; break; }
                if ('' === $det->getApPaternoPaciente()) { $error = '0151'; break; }
                if ('' === $det->getNoPaciente()) { $error = '0152'; break; }
                if ('' === $det->getCoPaciente()) { $error = '0153'; break; }
                if ('' === $det->getApMaternoPaciente()) { $error = '0154'; break; }
                if ('' === $det->getEsPaciente()) { $error = '0155'; break; }
                if ('' === $det->getTiDocumentoPaciente()) { $error = '0156'; break; }
                if ('' === $det->getNuDocumentoPaciente()) { $error = '0157'; break; }
                if ('' === $det->getCoVinculoFamPaciente()) { $error = '0171'; break; }
                if ('' === $det->getFeNacePaciente()) { $error = '0175'; break; }
                if ('' === $det->getGePaciente()) { $error = '0176'; break; }
                if ('' === $det->getTiRegimenPaciente()) { $error = '0190'; break; }
                if ('' === $det->getNuCarnetPaciente()) { $error = '0191'; break; }
                if ('' === $det->getFeFinAtencionPaciente()) { $error = '0192'; break; }
                if ('' === $det->getCaAseguradora()) { $error = '0193'; break; }
                if ('' === $det->getCoAseguradora()) { $error = '0194'; break; }
                if ('' === $det->getFeIniAfiliaPaciente()) { $error = '0210'; break; }
                if ('' === $det->getFeFinAfiliaPaciente()) { $error = '0211'; break; }
                if ('' === $det->getCaTitular()) { $error = '0400'; break; }
                if ('' === $det->getApPaternoTitular()) { $error = '0401'; break; }
                if ('' === $det->getNoTitular()) { $error = '0402'; break; }
                if ('' === $det->getCoTitular()) { $error = '0403'; break; }
                if ('' === $det->getApMaternoTitular()) { $error = '0404'; break; }
                if ('' === $det->getTiDocumentoTitular()) { $error = '0405'; break; }
                if ('' === $det->getNuDocumentoTitular()) { $error = '0407'; break; }
                if ('' === $det->getFeFallecidoTitular()) { $error = '0410'; break; }
                if ('' === $det->getCoPaisTitular()) { $error = '0411'; break; }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inRegAfi271->getNoTransaccion())) < 1 || strlen(trim($inRegAfi271->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inRegAfi271->getIdRemitente()) !== '0' || strlen($inRegAfi271->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inRegAfi271->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inRegAfi271->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inRegAfi271->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getHoTransaccion()) !== '0' || strlen(trim($inRegAfi271->getHoTransaccion())) < 4 || strlen(trim($inRegAfi271->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getIdCorrelativo()) !== '0' || strlen(trim($inRegAfi271->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getIdTransaccion()) !== '0' || strlen(trim($inRegAfi271->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getTiFinalidad()) !== '0' || strlen(trim($inRegAfi271->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getCaRemitente()) !== '0' || strlen(trim($inRegAfi271->getCaRemitente())) !== 1 || (trim($inRegAfi271->getCaRemitente()) !== '1' && trim($inRegAfi271->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inRegAfi271->getCaReceptor()) !== '0' || strlen(trim($inRegAfi271->getCaReceptor())) !== 1 || (trim($inRegAfi271->getCaReceptor()) !== '1' && trim($inRegAfi271->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (strlen(trim($inRegAfi271->getNuRucReceptor())) < 2 || strlen(trim($inRegAfi271->getNuRucReceptor())) > 20 || trim($inRegAfi271->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } else {
                $list = $inRegAfi271->getInRegAfi271Detalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (strlen($det->getCaPaciente()) !== 1 || (trim($det->getCaPaciente()) !== '1' && trim($det->getCaPaciente()) !== '2')) {
                        $error = '0800'; break;
                    }
                    if (strlen(trim($det->getApPaternoPaciente())) < 1 || strlen(trim($det->getApPaternoPaciente())) > 60) {
                        $error = '0801'; break;
                    }
                    if (strlen(trim($det->getNoPaciente())) < 1 || strlen(trim($det->getNoPaciente())) > 35) {
                        $error = '0802'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoPaciente()) !== '0' || strlen(trim($det->getCoPaciente())) < 2 || strlen(trim($det->getCoPaciente())) > 20) {
                        $error = '0803'; break;
                    }
                    if (strlen(trim($det->getApMaternoPaciente())) < 1 || strlen(trim($det->getApMaternoPaciente())) > 60) {
                        $error = '0804'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getEsPaciente()) !== '0' || strlen(trim($det->getEsPaciente())) < 1 || strlen(trim($det->getEsPaciente())) > 2) {
                        $error = '0805'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getTiDocumentoPaciente()) !== '0' || strlen(trim($det->getTiDocumentoPaciente())) < 1 || strlen(trim($det->getTiDocumentoPaciente())) > 2) {
                        $error = '0806'; break;
                    }
                    if (trim($det->getNuDocumentoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($det->getNuDocumentoPaciente()) !== '0' || strlen(trim($det->getNuDocumentoPaciente())) !== 8) {
                        $error = '0807'; break;
                    }
                    if (strlen(trim($det->getCoVinculoFamPaciente())) < 1 || strlen(trim($det->getCoVinculoFamPaciente())) > 2) {
                        $error = '0821'; continue;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeNacePaciente(), 'YYYYmmdd') || strlen(trim($det->getFeNacePaciente())) !== 8) {
                        $error = '0825'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getGePaciente()) !== '0' || strlen(trim($det->getGePaciente())) !== 1) {
                        $error = '0826'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getTiRegimenPaciente()) !== '0' || strlen(trim($det->getTiRegimenPaciente())) < 1 || strlen(trim($det->getTiRegimenPaciente())) > 15) {
                        $error = '0840'; break;
                    }
                    if (strlen(trim($det->getNuCarnetPaciente())) < 1 || strlen(trim($det->getNuCarnetPaciente())) > 20) {
                        $error = '0841'; break;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeFinAtencionPaciente(), 'YYYYmmdd') || strlen(trim($det->getFeFinAtencionPaciente())) !== 8) {
                        $error = '0842'; break;
                    }
                    if (strlen(trim($det->getCaAseguradora())) !== 1 || (trim($det->getCaAseguradora()) !== '1' && trim($det->getCaAseguradora()) !== '2')) {
                        $error = '0843'; break;
                    }
                    if (strlen(trim($det->getCoAseguradora())) < 1 || strlen(trim($det->getCoAseguradora())) > 20) {
                        $error = '0844'; break;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeIniAfiliaPaciente(), 'YYYYmmdd') || strlen(trim($det->getFeIniAfiliaPaciente())) !== 8) {
                        $error = '0910'; break;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeFinAfiliaPaciente(), 'YYYYmmdd') || strlen(trim($det->getFeFinAfiliaPaciente())) !== 8) {
                        $error = '0912'; break;
                    }
                    if (strlen(trim($det->getCaTitular())) !== 1 || (trim($det->getCaTitular()) !== '1' && trim($det->getCaTitular()) !== '2')) {
                        $error = '1100'; break;
                    }
                    if (strlen(trim($det->getApPaternoTitular())) < 1 || strlen(trim($det->getApPaternoTitular())) > 60) {
                        $error = '1101'; break;
                    }
                    if (strlen(trim($det->getNoTitular())) < 1 || strlen(trim($det->getNoTitular())) > 35) {
                        $error = '1102'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoTitular()) !== '0' || strlen(trim($det->getCoTitular())) < 2 || strlen(trim($det->getCoTitular())) > 80) {
                        $error = '1103'; break;
                    }
                    if (strlen(trim($det->getApMaternoTitular())) < 1 || strlen(trim($det->getApMaternoTitular())) > 60) {
                        $error = '1104'; continue;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getTiDocumentoTitular()) !== '0' || strlen(trim($det->getTiDocumentoTitular())) < 1 || strlen(trim($det->getTiDocumentoTitular())) > 2) {
                        $error = '1105'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getNuDocumentoTitular()) !== '0' || strlen(trim($det->getNuDocumentoTitular())) < 1 || strlen(trim($det->getNuDocumentoTitular())) > 20) {
                        $error = '1107'; break;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeFallecidoTitular(), 'YYYYmmdd') || strlen(trim($det->getFeFallecidoTitular())) !== 8) {
                        $error = '1110'; break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoPaisTitular()) !== '0' || strlen(trim($det->getCoPaisTitular())) < 2 || strlen(trim($det->getCoPaisTitular())) > 3) {
                        $error = '1111'; break;
                    }
                }
            }
        }

        return $error;
    }
}
