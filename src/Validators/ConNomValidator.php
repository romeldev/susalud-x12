<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\InConNom271;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ConNomValidator
{
    /**
     * @param InConNom271 $inConNom
     * @return string Error code or "0000" if valid
     */
    public static function validate($inConNom)
    {
        $error = '0000';

        if ('' === $inConNom->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inConNom->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inConNom->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inConNom->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inConNom->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inConNom->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inConNom->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inConNom->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inConNom->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inConNom->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inConNom->getNuRucReceptor()) {
            $error = '0117';
        } else {
            $list = $inConNom->getInConNom271Detalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getCaPaciente()) {
                    $error = '0150';
                    break;
                }
                if ('' === $det->getApPaternoPaciente()) {
                    $error = '0151';
                    break;
                }
                if ('' === $det->getNoPaciente()) {
                    $error = '0152';
                    break;
                }
                if ('' === $det->getCoAfPaciente()) {
                    $error = '0153';
                    break;
                }
                if ('' === $det->getApMaternoPaciente()) {
                    $error = '0154';
                    break;
                }
                if ('' === $det->getCoEsPaciente()) {
                    $error = '0155';
                    break;
                }
                if ('' === $det->getTiDoPaciente()) {
                    $error = '0156';
                    break;
                }
                if ('' === $det->getNuDoPaciente()) {
                    $error = '0157';
                    break;
                }
                if ('' === $det->getNuContratoPaciente()) {
                    $error = '0160';
                    break;
                }
                if ('' === $det->getCoProducto()) {
                    $error = '0164';
                    break;
                }
                if ('' === $det->getCoDescripcion()) {
                    $error = '0165';
                    break;
                }
                if ('' === $det->getCoParentesco()) {
                    $error = '0173';
                    break;
                }
                if ('' === $det->getFeNacimiento()) {
                    $error = '0177';
                    continue;
                }
                if ('' === $det->getGenero()) {
                    $error = '0178';
                }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inConNom->getNoTransaccion())) < 1 || strlen(trim($inConNom->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inConNom->getIdRemitente()) !== '0' || strlen($inConNom->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inConNom->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inConNom->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inConNom->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getHoTransaccion()) !== '0' || strlen(trim($inConNom->getHoTransaccion())) < 4 || strlen(trim($inConNom->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getIdCorrelativo()) !== '0' || strlen(trim($inConNom->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getIdTransaccion()) !== '0' || strlen(trim($inConNom->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getTiFinalidad()) !== '0' || strlen(trim($inConNom->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getCaRemitente()) !== '0' || strlen(trim($inConNom->getCaRemitente())) !== 1 || (trim($inConNom->getCaRemitente()) !== '1' && trim($inConNom->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inConNom->getCaReceptor()) !== '0' || strlen(trim($inConNom->getCaReceptor())) !== 1 || (trim($inConNom->getCaReceptor()) !== '1' && trim($inConNom->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (strlen(trim($inConNom->getNuRucReceptor())) < 2 || strlen(trim($inConNom->getNuRucReceptor())) > 20 || trim($inConNom->getNuRucReceptor()) === '00000000000') {
                $error = '0715';
            } else {
                $list = $inConNom->getInConNom271Detalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (ManagerUtil::validaSoloDigito($det->getCaPaciente()) !== '0' || strlen(trim($det->getCaPaciente())) !== 1 || (trim($det->getCaPaciente()) !== '1' && trim($det->getCaPaciente()) !== '2')) {
                        $error = '0800';
                        break;
                    }
                    if (strlen(trim($det->getApPaternoPaciente())) < 1 || strlen(trim($det->getApPaternoPaciente())) > 60) {
                        $error = '0801';
                        break;
                    }
                    if (strlen(trim($det->getNoPaciente())) < 1 || strlen(trim($det->getNoPaciente())) > 35) {
                        $error = '0802';
                        break;
                    }
                    if (strlen(trim($det->getCoAfPaciente())) < 2 || strlen(trim($det->getCoAfPaciente())) > 20) {
                        $error = '0803';
                        break;
                    }
                    if (strlen(trim($det->getApMaternoPaciente())) < 1 || strlen(trim($det->getApMaternoPaciente())) > 60) {
                        $error = '0804';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoEsPaciente()) !== '0' || strlen(trim($det->getCoEsPaciente())) < 1 || strlen(trim($det->getCoEsPaciente())) > 2) {
                        $error = '0805';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getTiDoPaciente()) !== '0' || strlen(trim($det->getTiDoPaciente())) < 1 || strlen(trim($det->getTiDoPaciente())) > 2) {
                        $error = '0806';
                        break;
                    }
                    if (trim($det->getNuDoPaciente()) === '00000000' || ManagerUtil::validaSoloDigito($det->getNuDoPaciente()) !== '0' || strlen(trim($det->getNuDoPaciente())) !== 8) {
                        $error = '0807';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getNuContratoPaciente()) !== '0' || strlen(trim($det->getNuContratoPaciente())) < 1 || strlen(trim($det->getNuContratoPaciente())) > 20) {
                        $error = '0810';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoProducto()) !== '0' || strlen(trim($det->getCoProducto())) < 1 || strlen(trim($det->getCoProducto())) > 20) {
                        $error = '0814';
                        break;
                    }
                    if (strlen(trim($det->getCoDescripcion())) < 1 || strlen(trim($det->getCoDescripcion())) > 80) {
                        $error = '0815';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getCoParentesco()) !== '0' || strlen(trim($det->getCoParentesco())) < 1 || strlen(trim($det->getCoParentesco())) > 2) {
                        $error = '0821';
                        break;
                    }
                    if (!ManagerUtil::validaFecha($det->getFeNacimiento(), 'YYYYmmdd') || strlen(trim($det->getFeNacimiento())) !== 8) {
                        $error = '0825';
                        break;
                    }
                    if (ManagerUtil::validaSoloDigito($det->getGenero()) !== '0' || strlen(trim($det->getGenero())) !== 1) {
                        $error = '0826';
                        break;
                    }
                }
            }
        }

        return $error;
    }
}
