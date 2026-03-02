<?php

namespace Romeldev\SusaludX12\Segments;

class HlSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 4;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'HL01', 'Alfanumerico', 1, 12, '1');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'HL02', 'Alfanumerico', 1, 12, '');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'HL03', 'Numerico',     1,  2, '20');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'HL04', 'Numerico',     1,  1, '1');
    }

    /**
     * @param string $sNuJerarquico
     * @param string $sCoJerarquico
     * @param string $sCoIndicador
     * @return void
     */
    public function generaSubTrama3($sNuJerarquico, $sCoJerarquico, $sCoIndicador)
    {
        $this->campoSubTrama[0]->contenido = $sNuJerarquico;
        $this->campoSubTrama[2]->contenido = $sCoJerarquico;
        $this->campoSubTrama[3]->contenido = $sCoIndicador;
    }

    /**
     * @param string $sNuJerarquico
     * @param string $sNuPadreJerarquico
     * @param string $sCoJerarquico
     * @param string $sCoIndicaSegmentos
     * @return void
     */
    public function generaSubTrama($sNuJerarquico = '', $sNuPadreJerarquico = '', $sCoJerarquico = '', $sCoIndicaSegmentos = '')
    {
        $this->campoSubTrama[0]->contenido = $sNuJerarquico;
        $this->campoSubTrama[1]->contenido = $sNuPadreJerarquico;
        $this->campoSubTrama[2]->contenido = $sCoJerarquico;
        $this->campoSubTrama[3]->contenido = $sCoIndicaSegmentos;
    }
}
