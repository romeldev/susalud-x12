<?php

namespace Romeldev\SusaludX12\Segments;

class EbSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 12;
        $this->campoSubTrama[0]  = $this->crearCampo(1,  'EB01', 'Alfanumerico', 1,  2, '', 1, 'Id identificador');
        $this->campoSubTrama[1]  = $this->crearCampo(2,  'EB02', 'Alfanumerico', 4,  4, '', 1, 'Cod Nivel Cobertura');
        $this->campoSubTrama[2]  = $this->crearCampo(3,  'EB03', 'Alfanumerico', 1, 35, '', 1, '');
        $this->campoSubTrama[3]  = $this->crearCampo(4,  'EB04', 'Alfanumerico', 3,  3, '', 1, '');
        $this->campoSubTrama[4]  = $this->crearCampo(5,  'EB05', 'Alfanumerico', 1, 50, '', 1, '');
        $this->campoSubTrama[5]  = $this->crearCampo(6,  'EB06', 'Alfanumerico', 1, 35, '', 1, '');
        $this->campoSubTrama[6]  = $this->crearCampo(7,  'EB07', 'Alfanumerico', 1, 18, '', 1, 'Beneficio maximo Inicial');
        $this->campoSubTrama[7]  = $this->crearCampo(8,  'EB08', 'Alfanumerico', 1, 10, '', 1, 'Monto de Cobertura');
        $this->campoSubTrama[8]  = $this->crearCampo(9,  'EB09', 'Alfanumerico', 2,  2, '', 1, 'Código de tipo de Procedimiento');
        $this->campoSubTrama[9]  = $this->crearCampo(10, 'EB10', 'Alfanumerico', 1,  3, '', 1, 'Cantidad de Servicio');
        $this->campoSubTrama[10] = $this->crearCampo(11, 'EB11', 'Alfanumerico', 2,  3, '', 1, '');
        $this->campoSubTrama[11] = $this->crearCampo(12, 'EB12', 'Alfanumerico', 1, 35, '', 1, '');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @param string $sParameter3
     * @param string $sParameter5
     * @param string $sParameter7
     * @param string $sParameter8
     * @param string $sParameter9
     * @param string $sParameter10
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2, $sParameter3, $sParameter5, $sParameter7, $sParameter8, $sParameter9, $sParameter10)
    {
        $this->campoSubTrama[0]->contenido = $sParameter1;
        $this->campoSubTrama[1]->contenido = $sParameter2;
        $this->campoSubTrama[2]->contenido = $sParameter3;
        $this->campoSubTrama[4]->contenido = $sParameter5;
        $this->campoSubTrama[6]->contenido = $sParameter7;
        $this->campoSubTrama[7]->contenido = $sParameter8;
        $this->campoSubTrama[8]->contenido = $sParameter9;
        $this->campoSubTrama[9]->contenido = $sParameter10;
    }
}
