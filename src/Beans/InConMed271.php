<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InConMed271Detalle;

class InConMed271 extends AbstractBean
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
    protected $coPaciente = '';
    /** @var string */
    protected $apMaternoPaciente = '';
    /** @var InConMed271Detalle[] */
    protected $inConMed271Detalles = [];
    /** @var string */
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            'detalles' => 'inConMed271Detalles',
        ];
    }
}
