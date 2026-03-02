<?php

namespace Romeldev\SusaludX12\Segments;

class Ak1Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'AK101', 'Alfanumerico', 2,  2, '', 1, 'CodigoIdentificacion');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'AK102', 'Alfanumerico', 1,  9, '', 1, 'CorrelativoGS_transaccion');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'AK103', 'Alfanumerico', 1, 12, '', 1, 'NumeroAutorizacion');
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
