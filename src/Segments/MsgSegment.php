<?php

namespace Romeldev\SusaludX12\Segments;

class MsgSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 3;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'MSG01', 'Alfanumerico', 1, 264, '', 1, 'Texto Libre para Mensajes');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'MSG02', 'Alfanumerico', 2,   2, '', 1, 'Código de control de impresión');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'MSG03', 'Alfanumerico', 1,   2, '', 1, 'Número');
    }

    /**
     * @param string $sTextoMsg
     * @return void
     */
    public function generaSubTrama1($sTextoMsg)
    {
        $this->campoSubTrama[0]->contenido = $sTextoMsg;
    }

    /**
     * @param string $priParametro
     * @param string $segParametro
     * @param string $terParametro
     * @return void
     */
    public function generaSubTrama($priParametro = '', $segParametro = '', $terParametro = '')
    {
        $this->campoSubTrama[0]->contenido = $priParametro;
        $this->campoSubTrama[1]->contenido = $segParametro;
        $this->campoSubTrama[2]->contenido = $terParametro;
    }
}
