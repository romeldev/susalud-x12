<?php

namespace Romeldev\SusaludX12\Segments;

class Sv2Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'SV201', 'Alfanumerico', 1, 18, '', 1, 'Monto Monetario');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'SV202', 'Alfanumerico', 0,  0, '', 0, '');
    }

    /**
     * @param string $sParameter
     * @return void
     */
    public function generaSubTrama($sParameter)
    {
        $this->campoSubTrama[0]->contenido = $sParameter;
    }
}
