<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\In278ResCGDetalle;

class In278ResCG
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
    public $nuControl = '';
    /** @var string */
    public $nuControlST = '';
    /** @var In278ResCGDetalle[] */
    public $in278ResCGDetalles = [];
}
