<?php

namespace Romeldev\SusaludX12\Segments;

class Ak2Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'AK201', 'Alfanumerico', 3,  3, '', 1, 'CodigoIdTransaccion');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'AK202', 'Alfanumerico', 4,  9, '', 1, 'nuControlGrupo');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'AK203', 'Alfanumerico', 1, 35, '', 1, 'imReferencial');
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
