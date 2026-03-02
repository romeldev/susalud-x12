<?php

namespace Romeldev\SusaludX12\Segments;

class IeaSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'IEA01', 'Alfanumerico', 1, 5, '1');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'IEA02', 'Numerico',     9, 9, '');
    }

    /**
     * @param string $sIdCorrelativo
     * @return void
     */
    public function generaSubTrama($sIdCorrelativo)
    {
        $this->campoSubTrama[1]->contenido = $sIdCorrelativo;
    }
}
