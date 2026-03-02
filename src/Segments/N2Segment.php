<?php

namespace Romeldev\SusaludX12\Segments;

class N2Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'N201', 'Alfanumerico', 1, 60, '', 1, 'Nombre01');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'N202', 'Alfanumerico', 1, 60, '', 1, 'Nombre02');
    }

    /**
     * @param string $sParameter1
     * @return void
     */
    public function generaSubTrama($sParameter1)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
    }
}
