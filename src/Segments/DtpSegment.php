<?php

namespace Romeldev\SusaludX12\Segments;

class DtpSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'DTP01', 'Alfanumerico', 3,  3, '', 1, 'Código Identificador Fecha u Hora');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'DTP02', 'Alfanumerico', 2,  3, '', 1, 'Código identificador de Formato');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'DTP03', 'Alfanumerico', 1, 35, '', 1, 'Fecha');
    }

    /**
     * @param string $sIdentificadorFecha
     * @param string $sFormatofecha
     * @param string $sParameterFecha
     * @return void
     */
    public function generaSubTrama($sIdentificadorFecha, $sFormatofecha, $sParameterFecha)
    {
        $this->campoSubTrama[0]->contenido = $sIdentificadorFecha;
        $this->campoSubTrama[1]->contenido = $sFormatofecha;
        $this->campoSubTrama[2]->contenido = $sParameterFecha;
    }
}
