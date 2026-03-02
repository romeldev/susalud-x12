<?php

namespace Romeldev\SusaludX12\Segments;

class Sv1Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'SV101', 'Alfanumerico', 2, 2, '', 1, 'ID Calificador');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'SV102', 'Alfanumerico', 1, 2, '', 1, 'ID');
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
