<?php

namespace Romeldev\SusaludX12\Segments;

class RefSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'REF01', 'Alfanumerico', 2,  3, '', 1, 'Codigo de identificacion de referencia');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'REF02', 'Alfanumerico', 1, 80, '', 1, 'Referencia de informacion');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'REF03', 'Alfanumerico', 1, 80, '', 1, 'Descripcion');
    }

    /**
     * @param string $sParam1
     * @param string $sParam2
     * @return void
     */
    public function generaSubTrama2($sParam1, $sParam2)
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[1]->contenido = $sParam2;
    }

    /**
     * @param string $sParam1
     * @param string $sParam2
     * @param string $sParam3
     * @return void
     */
    public function generaSubTrama($sParam1, $sParam2, $sParam3)
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[1]->contenido = $sParam2;
        $this->campoSubTrama[2]->contenido = $sParam3;
    }
}
