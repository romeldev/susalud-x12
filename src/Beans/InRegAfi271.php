<?php

namespace Romeldev\SusaludX12\Beans;

use Romeldev\SusaludX12\Beans\Detalle\InRegAfi271Detalle;

class InRegAfi271 extends AbstractBean
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
    protected $nuControl = '';
    /** @var string */
    protected $nuControlST = '';
    /** @var InRegAfi271Detalle[] */
    protected $regafi271Detalles = [];

    /** @inheritdoc */
    protected function getPropertyAliases()
    {
        return [
            'detalles' => 'regafi271Detalles',
        ];
    }
}
