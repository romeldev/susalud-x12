<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InConProc271Detalle;

class InConProc271 extends AbstractBean
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
    /** @var InConProc271Detalle[] */
    protected $inConProc271Detalles = [];
    /** @var string */
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            'detalles' => 'inConProc271Detalles',
        ];
    }
}
