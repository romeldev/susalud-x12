<?php

namespace Romeldev\SusaludX12\Segments;

class InsSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 17;
        $this->campoSubTrama[0]  = $this->crearCampo(1,  'INS01', 'Alfanumerico', 1,  1, '', 1, 'Cód.Res');
        $this->campoSubTrama[1]  = $this->crearCampo(2,  'INS02', 'Alfanumerico', 2,  2, '', 1, 'Cód.RelacionCliente');
        $this->campoSubTrama[2]  = $this->crearCampo(3,  'INS03', 'Alfanumerico', 3,  3, '', 1, '');
        $this->campoSubTrama[3]  = $this->crearCampo(4,  'INS04', 'Alfanumerico', 2,  3, '', 1, '');
        $this->campoSubTrama[4]  = $this->crearCampo(5,  'INS05', 'Alfanumerico', 1,  1, '', 1, '');
        $this->campoSubTrama[5]  = $this->crearCampo(6,  'INS06', 'Alfanumerico', 1,  6, '', 1, '');
        $this->campoSubTrama[6]  = $this->crearCampo(7,  'INS07', 'Alfanumerico', 1,  2, '', 1, '');
        $this->campoSubTrama[7]  = $this->crearCampo(8,  'INS08', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[8]  = $this->crearCampo(9,  'INS09', 'Alfanumerico', 1,  1, '', 1, '');
        $this->campoSubTrama[9]  = $this->crearCampo(10, 'INS10', 'Alfanumerico', 1,  1, '', 1, '');
        $this->campoSubTrama[10] = $this->crearCampo(11, 'INS11', 'Alfanumerico', 2,  3, '', 1, '');
        $this->campoSubTrama[11] = $this->crearCampo(12, 'INS12', 'Alfanumerico', 1, 35, '', 1, '');
        $this->campoSubTrama[12] = $this->crearCampo(13, 'INS13', 'Alfanumerico', 1,  1, '', 1, '');
        $this->campoSubTrama[13] = $this->crearCampo(14, 'INS14', 'Alfanumerico', 2, 30, '', 1, '');
        $this->campoSubTrama[14] = $this->crearCampo(15, 'INS15', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[15] = $this->crearCampo(16, 'INS16', 'Alfanumerico', 2,  3, '', 1, '');
        $this->campoSubTrama[16] = $this->crearCampo(17, 'INS17', 'Alfanumerico', 1,  9, '', 1, 'Numero');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @param string $sParameter3
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2, $sParameter3)
    {
        $this->campoSubTrama[0]->contenido  = $sParameter1;
        $this->campoSubTrama[1]->contenido  = $sParameter2;
        $this->campoSubTrama[16]->contenido = $sParameter3;
    }
}
