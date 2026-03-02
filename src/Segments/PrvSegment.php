<?php

namespace Romeldev\SusaludX12\Segments;

class PrvSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'PRV01', 'Alfanumerico', 1, 3, '', 1, 'CódigoProveedor');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'PRV02', 'Alfanumerico', 2, 3, '', 1, 'CalificadorIdenReferencial');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'PRV03', 'Alfanumerico', 1, 3, '', 1, 'IdentificadorReferencia');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @param string $sParameter3
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2, $sParameter3)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[1]->contenido = $sParameter2;
        $this->campoSubTrama[2]->contenido = $sParameter3;
    }
}
