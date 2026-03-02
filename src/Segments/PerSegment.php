<?php

namespace Romeldev\SusaludX12\Segments;

class PerSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 6;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'PER01', 'Alfanumerico', 2,  2, '', 1, 'CodigoIdResponsabilidad');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'PER02', 'Alfanumerico', 1, 60, '', 1, 'Nombre');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'PER03', 'Alfanumerico', 2,  2, '', 1, 'CaFormaComunicacionEmail');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'PER04', 'Alfanumerico', 1, 80, '', 1, 'EmailAfiliado');
        $this->campoSubTrama[4] = $this->crearCampo(5, 'PER05', 'Alfanumerico', 2,  2, '', 1, 'CaFormaComunicacionTelefono');
        $this->campoSubTrama[5] = $this->crearCampo(6, 'PER06', 'Alfanumerico', 1, 20, '', 1, 'TelefonoAfiliado');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @return void
     */
    public function generaSubTrama2($sParameter1, $sParameter2)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[1]->contenido = $sParameter2;
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @param string $sParameter3
     * @param string $sParameter4
     * @param string $sParameter5
     * @return void
     */
    public function generaSubTrama($sParameter1 = '', $sParameter2 = '', $sParameter3 = '', $sParameter4 = '', $sParameter5 = '')
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[2]->contenido = $sParameter2;
        $this->campoSubTrama[3]->contenido = $sParameter3;
        $this->campoSubTrama[4]->contenido = $sParameter4;
        $this->campoSubTrama[5]->contenido = $sParameter5;
    }
}
