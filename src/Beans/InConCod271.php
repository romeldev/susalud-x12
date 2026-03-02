<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InConCod271Detalle;

class InConCod271 extends AbstractBean
{
    /** @var string */
    protected $noTransaccion = '';
    /** @var string */
    protected $idRemitente = '';
    /** @var string */
    protected $idReceptor = '';
    /** @var string */
    protected $feTransaccion = '';
    /** @var string */
    protected $hoTransaccion = '';
    /** @var string */
    protected $idCorrelativo = '';
    /** @var string */
    protected $idTransaccion = '';
    /** @var string */
    protected $tiFinalidad = '';
    /** @var string */
    protected $caRemitente = '';
    /** @var string */
    protected $userRemitente = '';
    /** @var string */
    protected $passRemitente = '';
    /** @var string */
    protected $feUpFoto = '';
    /** @var string */
    protected $caReceptor = '';
    /** @var string */
    protected $nuRucReceptor = '';
    /** @var string */
    protected $caPaciente = '';
    /** @var string */
    protected $apPaternoPaciente = '';
    /** @var string */
    protected $noPaciente = '';
    /** @var string */
    protected $coAfPaciente = '';
    /** @var string */
    protected $apMaternoPaciente = '';
    /** @var string */
    protected $coEsPaciente = '';
    /** @var string */
    protected $tiDoPaciente = '';
    /** @var string */
    protected $nuDoPaciente = '';
    /** @var string */
    protected $nuIdenPaciente = '';
    /** @var string */
    protected $nuContratoPaciente = '';
    /** @var string */
    protected $nuPoliza = '';
    /** @var string */
    protected $nuCertificado = '';
    /** @var string */
    protected $coTiPoliza = '';
    /** @var string */
    protected $coProducto = '';
    /** @var string */
    protected $deProducto = '';
    /** @var string */
    protected $nuPlan = '';
    /** @var string */
    protected $tiPlanSalud = '';
    /** @var string */
    protected $coMoneda = '';
    /** @var string */
    protected $coParentesco = '';
    /** @var string */
    protected $soBeneficio = '';
    /** @var string */
    protected $nuSoBeneficio = '';
    /** @var string */
    protected $feNacimiento = '';
    /** @var string */
    protected $genero = '';
    /** @var string */
    protected $esMarital = '';
    /** @var string */
    protected $feIniVigencia = '';
    /** @var string */
    protected $feFinVigencia = '';
    /** @var string */
    protected $tiCaContratante = '';
    /** @var string */
    protected $noPaContratante = '';
    /** @var string */
    protected $noContratante = '';
    /** @var string */
    protected $noMaContratante = '';
    /** @var string */
    protected $tiDoContratante = '';
    /** @var string */
    protected $idReContratante = '';
    /** @var string */
    protected $coReContratante = '';
    /** @var string */
    protected $caTitular = '';
    /** @var string */
    protected $noPaTitular = '';
    /** @var string */
    protected $noTitular = '';
    /** @var string */
    protected $coAfTitular = '';
    /** @var string */
    protected $noMaTitular = '';
    /** @var string */
    protected $tiDoTitular = '';
    /** @var string */
    protected $nuDoTitular = '';
    /** @var string */
    protected $feInsTitular = '';
    /** @var string */
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';
    /** @var InConCod271Detalle[] */
    protected $inConCod271Detalles = [];

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            'detalles' => 'inConCod271Detalles',
        ];
    }
}
