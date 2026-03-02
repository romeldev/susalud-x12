<?php

namespace Romeldev\SusaludX12\Segments;

class SeSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'SE01', 'Alfanumerico', 1, 10, '17');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'SE02', 'Alfanumerico', 4,  9, '');
    }

    /**
     * @param string $sCaSE Cantidad de segmentos
     * @param string $sNuControl
     * @return void
     */
    public function generaSubTrama($sCaSE, $sNuControl)
    {
        $this->campoSubTrama[0]->contenido = $sCaSE;
        $this->campoSubTrama[1]->contenido = $sNuControl;
    }
}
