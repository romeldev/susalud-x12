<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InSolAutExeCar271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutProEsp271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutRes271Detalle;
use Romeldev\SusaludX12\Beans\Detalle\InSolAutTieEsp271Detalle;

class InSolAut271 extends AbstractBean
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
    protected $nuRucRemitente = '';
    /** @var string */
    protected $caReceptor = '';
    /** @var string */
    protected $coAdmisionista = '';
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
    protected $nuIdenEmpleador = '';
    /** @var string */
    protected $nuContratoPaciente = '';
    /** @var string */
    protected $nuPoliza = '';
    /** @var string */
    protected $nuCertificado = '';
    /** @var string */
    protected $coTiPolizaAfiliacion = '';
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
    protected $coEspecialidad = '';
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
    protected $esCobertura = '';
    /** @var string */
    protected $nuDecAccidente = '';
    /** @var string */
    protected $idInfAccidente = '';
    /** @var string */
    protected $deTiAccidente = '';
    /** @var string */
    protected $feAfiliacion = '';
    /** @var string */
    protected $feOcuAccidente = '';
    /** @var string */
    protected $nuAtencion = '';
    /** @var string */
    protected $idDerFarmacia = '';
    /** @var string */
    protected $tiProducto = '';
    /** @var string */
    protected $deProductoDeFarmacia = '';
    /** @var string */
    protected $feAtencion = '';
    /** @var string */
    protected $nuCobertura = '';
    /** @var string */
    protected $obsCobertura = '';
    /** @var string */
    protected $msgObs = '';
    /** @var string */
    protected $msgConEspeciales = '';
    /** @var string */
    protected $caContratante = '';
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
    protected $idReTitular = '';
    /** @var string */
    protected $nuDoTitular = '';
    /** @var string */
    protected $feIncTitular = '';
    /** @var string */
    protected $nuCobPreExistencia = '';
    /** @var string */
    protected $beMaxInicial = '';
    /** @var string */
    protected $canServicio = '';
    /** @var string */
    protected $idDeProducto = '';
    /** @var string */
    protected $coTiCobertura = '';
    /** @var string */
    protected $coSubTiCobertura = '';
    /** @var string */
    protected $msgObsPre = '';
    /** @var string */
    protected $msgConEspecialesPre = '';
    /** @var string */
    protected $coTiMoneda = '';
    /** @var string */
    protected $coPagoFijo = '';
    /** @var string */
    protected $coCalServicio = '';
    /** @var string */
    protected $canCalServicio = '';
    /** @var string */
    protected $coPagoVariable = '';
    /** @var string */
    protected $flagCG = '';
    /** @var string */
    protected $deflagCG = '';
    /** @var string */
    protected $feFinCarencia = '';
    /** @var string */
    protected $feFinEspera = '';
    /** @var InSolAutProEsp271Detalle[] */
    protected $inSolAutProEsp271Detalle = [];
    /** @var InSolAutTieEsp271Detalle[] */
    protected $inSolAutTieEsp271Detalle = [];
    /** @var InSolAutExeCar271Detalle[] */
    protected $inSolAutExeCar271Detalle = [];
    /** @var InSolAutRes271Detalle[] */
    protected $inSolAut271Detalle = [];
    /** @var string */
    protected $caRegafi = '';
    /** @var string */
    protected $noPaRegafi = '';
    /** @var string */
    protected $noRegafi = '';
    /** @var string */
    protected $coAfRegafi = '';
    /** @var string */
    protected $noMaRegafi = '';
    /** @var string */
    protected $tiDoRegafi = '';
    /** @var string */
    protected $idReRegafi = '';
    /** @var string */
    protected $nuDoRegafi = '';
    /** @var string */
    protected $feNaRegafi = '';
    /** @var string */
    protected $geRegafi = '';
    /** @var string */
    protected $coPaisRegafi = '';
    /** @var string */
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            // Aliases cortos (Java: getDetalles(), getDetallesPE(), etc.)
            'detalles' => 'inSolAut271Detalle',
            'detallesPE' => 'inSolAutProEsp271Detalle',
            'detallesTE' => 'inSolAutTieEsp271Detalle',
            'detallesEC' => 'inSolAutExeCar271Detalle',
            // Aliases plurales (Java: getInSolAut271Detalles(), etc.)
            'inSolAut271Detalles' => 'inSolAut271Detalle',
            'inSolAutProEsp271Detalles' => 'inSolAutProEsp271Detalle',
            'inSolAutTieEsp271Detalles' => 'inSolAutTieEsp271Detalle',
            'inSolAutExeCar271Detalles' => 'inSolAutExeCar271Detalle',
        ];
    }
}
