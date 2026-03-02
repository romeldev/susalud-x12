<?php

namespace Romeldev\SusaludX12\Segments;

class GeSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'GE01', 'Alfanumerico', 1, 6, '1');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'GE02', 'Numerico',     1, 9, '');
    }

    /**
     * @param string $sNuControl
     * @return void
     */
    public function generaSubTrama($sNuControl)
    {
        $this->campoSubTrama[1]->contenido = $sNuControl;
    }
}
