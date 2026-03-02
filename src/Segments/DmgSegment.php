<?php

namespace Romeldev\SusaludX12\Segments;

class DmgSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 7;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'DMG01', 'Alfanumerico', 2,  3, '', 1, 'Código Indicador de Formato(CCYYMMDD)');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'DMG02', 'Alfanumerico', 1, 35, '', 1, 'Fecha de nacimiento');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'DMG03', 'Alfanumerico', 1,  1, '', 1, 'Indicador Genero( F Female/ M Male)');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'DMG04', 'Alfanumerico', 1,  1, '', 1, 'Estado Marital( I - Single M - Married)');
        $this->campoSubTrama[4] = $this->crearCampo(5, 'DMG05', 'Alfanumerico', 1, 20, '', 1, '');
        $this->campoSubTrama[5] = $this->crearCampo(6, 'DMG06', 'Alfanumerico', 1,  2, '', 1, '');
        $this->campoSubTrama[6] = $this->crearCampo(7, 'DMG07', 'Alfanumerico', 2,  3, 'Código del País de Origen', 1, '');
    }

    /**
     * @param string $sInFormato
     * @param string $sFeNacimiento
     * @param string $sGenero
     * @param string $sEsMarital
     * @param string $sCoPais
     * @return void
     */
    public function generaSubTrama($sInFormato, $sFeNacimiento, $sGenero, $sEsMarital, $sCoPais)
    {
        $this->campoSubTrama[0]->contenido = $sInFormato;
        $this->campoSubTrama[1]->contenido = $sFeNacimiento;
        $this->campoSubTrama[2]->contenido = $sGenero;
        $this->campoSubTrama[3]->contenido = $sEsMarital;
        $this->campoSubTrama[6]->contenido = $sCoPais;
    }
}
