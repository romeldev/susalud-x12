<?php

namespace Romeldev\SusaludX12\Segments;

class Ak9Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 4;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'AK901', 'Alfanumerico', 1, 1, '', 1, 'CodigoIdRechazoTransaccion');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'AK902', 'Alfanumerico', 1, 1, '', 1, 'nuTotalTransacciones');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'AK903', 'Alfanumerico', 1, 6, '', 1, 'nuConjuntosTransaccion');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'AK904', 'Alfanumerico', 1, 6, '', 1, 'nuTransaccionAceptadas');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @param string $sParameter3
     * @param string $sParameter4
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2, $sParameter3, $sParameter4)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[1]->contenido = $sParameter2;
        $this->campoSubTrama[2]->contenido = $sParameter3;
        $this->campoSubTrama[3]->contenido = $sParameter4;
    }
}
