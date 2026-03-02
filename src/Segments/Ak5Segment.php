<?php

namespace Romeldev\SusaludX12\Segments;

class Ak5Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'AK501', 'Alfanumerico', 1, 1, '', 1, 'CodigoIdRechazoTransaccion');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'AK502', 'Alfanumerico', 1, 3, '', 1, 'idCodigoErrorENcontrado');
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
