<?php

namespace Romeldev\SusaludX12\Segments;

class BhtSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 2;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'BHT01', 'Numerico', 4, 4, '0022');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'BHT02', 'Numerico', 2, 2, '13');
    }

    /**
     * @param string $sCoJerarquico
     * @param string $sTiFinalidad
     * @return void
     */
    public function generaSubTrama($sCoJerarquico, $sTiFinalidad)
    {
        $this->campoSubTrama[0]->contenido = $sCoJerarquico;
        $this->campoSubTrama[1]->contenido = $sTiFinalidad;
    }
}
