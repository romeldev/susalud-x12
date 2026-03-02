<?php

namespace Romeldev\SusaludX12\Segments;

class N4Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 7;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'N401', 'Alfanumerico', 2, 30, '', 1, '');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'N402', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'N403', 'Alfanumerico', 3, 15, '', 1, 'Cod. Postal');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'N404', 'Alfanumerico', 2,  3, '', 1, 'Cod. País');
        $this->campoSubTrama[4] = $this->crearCampo(5, 'N405', 'Alfanumerico', 1,  2, '', 1, 'Iden. Ubigeo');
        $this->campoSubTrama[5] = $this->crearCampo(6, 'N406', 'Alfanumerico', 1, 20, '', 1, 'Ubigeo');
        $this->campoSubTrama[6] = $this->crearCampo(7, 'N407', 'Alfanumerico', 1,  3, '', 1, 'Cod. Sub. País');
    }

    /**
     * @param string $sParameter1
     * @param string $sParameter2
     * @return void
     */
    public function generaSubTrama($sParameter1, $sParameter2)
    {
        $this->campoSubTrama[4]->contenido = $sParameter1;
        $this->campoSubTrama[5]->contenido = $sParameter2;
    }
}
