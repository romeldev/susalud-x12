<?php

namespace Romeldev\SusaludX12\Segments;

class CrcSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'CRC01', 'Alfanumerico', 2, 2,  '',   1, 'Cód. Categoria');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'CRC02', 'Alfanumerico', 1, 1,  '',   1, 'Cod Rpta. de Condición');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'CRC03', 'Alfanumerico', 2, 3,  '00', 1, 'Indicador Condición');
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
