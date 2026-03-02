<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InConMed271Detalle;

class InConMed271
{
    /** @var string */
    public $noTransaccion = '';
    /** @var string */
    public $idRemitente = '';
    /** @var string */
    public $idReceptor = '';
    /** @var string */
    public $feTransaccion = '';
    /** @var string */
    public $hoTransaccion = '';
    /** @var string */
    public $idCorrelativo = '';
    /** @var string */
    public $idTransaccion = '';
    /** @var string */
    public $tiFinalidad = '';
    /** @var string */
    public $caRemitente = '';
    /** @var string */
    public $caReceptor = '';
    /** @var string */
    public $nuRucReceptor = '';
    /** @var string */
    public $caPaciente = '';
    /** @var string */
    public $apPaternoPaciente = '';
    /** @var string */
    public $noPaciente = '';
    /** @var string */
    public $coPaciente = '';
    /** @var string */
    public $apMaternoPaciente = '';
    /** @var InConMed271Detalle[] */
    public $inConMed271Detalles = [];
    /** @var string */
    public $nuControl = '';
    /** @var string */
    public $nuControlST = '';
}
