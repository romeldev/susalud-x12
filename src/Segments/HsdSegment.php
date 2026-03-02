<?php

namespace Romeldev\SusaludX12\Segments;

class HsdSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'HSD01', 'Alfanumerico', 2, 2, '', 1, 'Identificador Cantidad');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'HSD02', 'Alfanumerico', 1, 3, '', 1, 'Cantidad');
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
