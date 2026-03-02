<?php

namespace Romeldev\SusaludX12\Segments;

class IsaSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 16;
        $this->campoSubTrama[0]  = $this->crearCampo(1,  'ISA01', 'Numerico',      2,  2,  '00');
        $this->campoSubTrama[1]  = $this->crearCampo(2,  'ISA02', 'Alfanumerico', 10, 10, '');
        $this->campoSubTrama[2]  = $this->crearCampo(3,  'ISA03', 'Numerico',      2,  2,  '00');
        $this->campoSubTrama[3]  = $this->crearCampo(4,  'ISA04', 'Alfanumerico', 10, 10, '');
        $this->campoSubTrama[4]  = $this->crearCampo(5,  'ISA05', 'Alfanumerico',  2,  2,  'ZZ');
        $this->campoSubTrama[5]  = $this->crearCampo(6,  'ISA06', 'Alfanumerico', 15, 15, '');
        $this->campoSubTrama[6]  = $this->crearCampo(7,  'ISA07', 'Alfanumerico',  2,  2,  'ZZ');
        $this->campoSubTrama[7]  = $this->crearCampo(8,  'ISA08', 'Alfanumerico', 15, 15, '');
        $this->campoSubTrama[8]  = $this->crearCampo(9,  'ISA09', 'Alfanumerico',  6,  6,  '');
        $this->campoSubTrama[9]  = $this->crearCampo(10, 'ISA10', 'Alfanumerico',  4,  4,  '');
        $this->campoSubTrama[10] = $this->crearCampo(11, 'ISA11', 'Alfanumerico',  1,  1,  '|');
        $this->campoSubTrama[11] = $this->crearCampo(12, 'ISA12', '',              5,  5,  '00501');
        $this->campoSubTrama[12] = $this->crearCampo(13, 'ISA13', 'Numerico',      9,  9,  '');
        $this->campoSubTrama[13] = $this->crearCampo(14, 'ISA14', 'Numerico',      1,  1,  '0');
        $this->campoSubTrama[14] = $this->crearCampo(15, 'ISA15', 'Alfanumerico',  1,  1,  'T');
        $this->campoSubTrama[15] = $this->crearCampo(16, 'ISA16', '',              1,  1,  ':');
    }

    /**
     * @param string $sIdRemitente
     * @param string $sIdReceptor
     * @param string $sFeTransaccion YYYYMMDD
     * @param string $sHoTransaccion HHMMSS
     * @param string $sIdCorrelativo
     * @return void
     */
    public function generaSubTrama($sIdRemitente, $sIdReceptor, $sFeTransaccion, $sHoTransaccion, $sIdCorrelativo)
    {
        $this->campoSubTrama[5]->contenido  = $sIdRemitente;
        $this->campoSubTrama[7]->contenido  = $sIdReceptor;
        $this->campoSubTrama[8]->contenido  = substr($sFeTransaccion, 2); // YYMMDD
        $this->campoSubTrama[9]->contenido  = substr($sHoTransaccion, 0, 4); // HHMM
        $this->campoSubTrama[12]->contenido = $sIdCorrelativo;
    }
}
