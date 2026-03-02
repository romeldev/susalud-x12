<?php

namespace Romeldev\SusaludX12\Segments;

class Ref4Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 6;
        $this->campoSubTrama[0] = $this->crearCampo(41, 'REF0401', 'Alfanumerico', 2,  3, '', 1, 'Calificador de identificacion referencial');
        $this->campoSubTrama[1] = $this->crearCampo(42, 'REF0402', 'Alfanumerico', 1, 20, '', 1, 'Informacion de referencia');
        $this->campoSubTrama[2] = $this->crearCampo(43, 'REF0403', 'Alfanumerico', 2,  3, '', 1, 'Calificador de identificacion referencial');
        $this->campoSubTrama[3] = $this->crearCampo(44, 'REF0404', 'Alfanumerico', 1, 20, '', 1, 'Informacion de referencia');
        $this->campoSubTrama[4] = $this->crearCampo(45, 'REF0405', 'Alfanumerico', 2,  3, '', 1, 'Calificador de identificacion referencial');
        $this->campoSubTrama[5] = $this->crearCampo(46, 'REF0406', 'Alfanumerico', 1, 20, '', 1, 'Informacion de referencia');
    }

    /**
     * @param string $sParam1
     * @param string $sParam2
     * @return void
     */
    public function generaSubTrama2($sParam1, $sParam2)
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[1]->contenido = $sParam2;
    }

    /**
     * @param string $sParam1
     * @param string $sParam2
     * @param string $sParam4
     * @return void
     */
    public function generaSubTrama3($sParam1, $sParam2, $sParam4)
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[1]->contenido = $sParam2;
        $this->campoSubTrama[3]->contenido = $sParam4;
    }

    /**
     * @param string $sParam1
     * @param string $sParam2
     * @param string $sParam3
     * @param string $sParam4
     * @param string $sParam5
     * @param string $sParam6
     * @return void
     */
    public function generaSubTrama($sParam1 = '', $sParam2 = '', $sParam3 = '', $sParam4 = '', $sParam5 = '', $sParam6 = '')
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[1]->contenido = $sParam2;
        $this->campoSubTrama[2]->contenido = $sParam3;
        $this->campoSubTrama[3]->contenido = $sParam4;
        $this->campoSubTrama[4]->contenido = $sParam5;
        $this->campoSubTrama[5]->contenido = $sParam6;
    }
}
