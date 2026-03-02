<?php

namespace Romeldev\SusaludX12\Validators;

use Romeldev\SusaludX12\Beans\In271ResDeriva;
use Romeldev\SusaludX12\Support\ManagerUtil;

class ResDerivaValidator
{
    /**
     * @param In271ResDeriva $inResDeriva
     * @return string Error code or "0000" if valid
     */
    public static function validate($inResDeriva)
    {
        $error = '0000';

        if ('' === $inResDeriva->getNoTransaccion()) {
            $error = '0100';
        } elseif ('' === $inResDeriva->getIdRemitente()) {
            $error = '0101';
        } elseif ('' === $inResDeriva->getIdReceptor()) {
            $error = '0102';
        } elseif ('' === $inResDeriva->getFeTransaccion()) {
            $error = '0103';
        } elseif ('' === $inResDeriva->getHoTransaccion()) {
            $error = '0104';
        } elseif ('' === $inResDeriva->getIdCorrelativo()) {
            $error = '0105';
        } elseif ('' === $inResDeriva->getIdTransaccion()) {
            $error = '0106';
        } elseif ('' === $inResDeriva->getTiFinalidad()) {
            $error = '0107';
        } elseif ('' === $inResDeriva->getCaRemitente()) {
            $error = '0108';
        } elseif ('' === $inResDeriva->getCaReceptor()) {
            $error = '0116';
        } elseif ('' === $inResDeriva->getNuRucReceptor()) {
            $error = '0117';
        } else {
            $list = $inResDeriva->getIn271ResDerivaDetalles();
            for ($i = 0; $i < count($list); $i++) {
                $det = $list[$i];
                if ('' === $det->getCaPaciente()) { $error = '0150'; break; }
                if ('' === $det->getCoTiProducto()) { $error = '0252'; break; }
                if ('' === $det->getDeProducto()) { $error = '0253'; break; }
                if ('' === $det->getFeAtSalud()) { $error = '0254'; continue; }
                if ('' === $det->getNoLuAtencion()) { $error = '0255'; continue; }
                if ('' === $det->getCoLuAtencion()) { $error = '0256'; continue; }
                if ('' === $det->getTiDoContratante()) { $error = '0355'; break; }
                if ('' === $det->getIdCaReferencia()) { $error = '0356'; break; }
                if ('' === $det->getReIdContratante()) { $error = '0357'; break; }
            }
        }

        if ($error === '0000') {
            if (strlen(trim($inResDeriva->getNoTransaccion())) < 1 || strlen(trim($inResDeriva->getNoTransaccion())) > 60) {
                $error = '0750';
            } elseif (ManagerUtil::validaAlfanumerico($inResDeriva->getIdRemitente()) !== '0' || strlen($inResDeriva->getIdRemitente()) !== 15) {
                $error = '0751';
            } elseif (strlen($inResDeriva->getIdReceptor()) !== 15) {
                $error = '0752';
            } elseif (!ManagerUtil::validaFecha($inResDeriva->getFeTransaccion(), 'YYYYmmdd') || strlen(trim($inResDeriva->getFeTransaccion())) !== 8) {
                $error = '0753';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getHoTransaccion()) !== '0' || strlen(trim($inResDeriva->getHoTransaccion())) < 4 || strlen(trim($inResDeriva->getHoTransaccion())) > 8) {
                $error = '0754';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getIdCorrelativo()) !== '0' || strlen(trim($inResDeriva->getIdCorrelativo())) !== 9) {
                $error = '0755';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getIdTransaccion()) !== '0' || strlen(trim($inResDeriva->getIdTransaccion())) !== 3) {
                $error = '0756';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getTiFinalidad()) !== '0' || strlen(trim($inResDeriva->getTiFinalidad())) !== 2) {
                $error = '0757';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getCaRemitente()) !== '0' || strlen(trim($inResDeriva->getCaRemitente())) !== 1 || (trim($inResDeriva->getCaRemitente()) !== '1' && trim($inResDeriva->getCaRemitente()) !== '2')) {
                $error = '0758';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getCaReceptor()) !== '0' || strlen(trim($inResDeriva->getCaReceptor())) !== 1 || (trim($inResDeriva->getCaReceptor()) !== '1' && trim($inResDeriva->getCaReceptor()) !== '2')) {
                $error = '0766';
            } elseif (ManagerUtil::validaSoloDigito($inResDeriva->getNuRucReceptor()) !== '0' || strlen(trim($inResDeriva->getNuRucReceptor())) < 2 || strlen(trim($inResDeriva->getNuRucReceptor())) > 20 || trim($inResDeriva->getNuRucReceptor()) === '00000000000') {
                $error = '0767';
            } else {
                $list = $inResDeriva->getIn271ResDerivaDetalles();
                for ($i = 0; $i < count($list); $i++) {
                    $det = $list[$i];
                    if (ManagerUtil::validaSoloDigito($det->getCaPaciente()) !== '0' || strlen(trim($det->getCaPaciente())) !== 1 || (trim($det->getCaPaciente()) !== '1' && trim($det->getCaPaciente()) !== '2')) { $error = '0800'; break; }
                    if (ManagerUtil::validaSoloDigito($det->getCoTiProducto()) !== '0' || strlen(trim($det->getCoTiProducto())) < 1 || strlen(trim($det->getCoTiProducto())) > 20) { $error = '0952'; continue; }
                    if (strlen(trim($det->getDeProducto())) < 1 || strlen(trim($det->getDeProducto())) > 60) { $error = '0953'; continue; }
                    if (!ManagerUtil::validaFecha($det->getFeAtSalud(), 'YYYYmmdd') || strlen(trim($det->getFeAtSalud())) !== 8) { $error = '0954'; continue; }
                    if (strlen(trim($det->getNoLuAtencion())) < 1 || strlen(trim($det->getNoLuAtencion())) > 60) { $error = '0955'; continue; }
                    if (strlen(trim($det->getCoLuAtencion())) < 1 || strlen(trim($det->getCoLuAtencion())) > 20) { $error = '0956'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getTiDoContratante()) !== '0' || strlen(trim($det->getTiDoContratante())) < 1 || strlen(trim($det->getTiDoContratante())) > 2) { $error = '1055'; continue; }
                    if (strlen(trim($det->getIdCaReferencia())) < 2 || strlen(trim($det->getIdCaReferencia())) > 3 || (trim($det->getIdCaReferencia()) !== 'XX5' && trim($det->getIdCaReferencia()) !== '4A')) { $error = '1056'; continue; }
                    if (ManagerUtil::validaSoloDigito($det->getReIdContratante()) !== '0' || strlen(trim($det->getReIdContratante())) < 1 || strlen(trim($det->getReIdContratante())) > 20) { $error = '1057'; }
                }
            }
        }

        return $error;
    }
}
