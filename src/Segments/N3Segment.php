<?php

namespace Romeldev\SusaludX12\Segments;

class N3Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'N301', 'Alfanumerico', 1, 55, '', 1, 'Direccion01');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'N302', 'Alfanumerico', 1, 55, '', 1, 'Direccion02');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[1]->contenido = $sParameter2;
    }
}
