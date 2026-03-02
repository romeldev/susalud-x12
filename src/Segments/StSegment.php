<?php

namespace Romeldev\SusaludX12\Segments;

class StSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'ST01', 'Numerico',      3,  3, '00');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'ST02', 'Alfanumerico',  4,  9, '');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'ST03', 'Alfanumerico',  1, 35, '');
    }

    /**
     * @param string $sNuControl
     * @return void
     */
    public function generaSubTrama1($sNuControl)
    {
        $this->campoSubTrama[1]->contenido = $sNuControl;
    }

    /**
     * @param string $sIdTransaccion
     * @param string $sNuControl
     * @param string $sCantArray
     * @return void
     */
    public function generaSubTrama($sIdTransaccion, $sNuControl, $sCantArray)
    {
        $this->campoSubTrama[0]->contenido = $sIdTransaccion;
        $this->campoSubTrama[1]->contenido = $sNuControl;
        $this->campoSubTrama[2]->contenido = $sCantArray;
    }
}
