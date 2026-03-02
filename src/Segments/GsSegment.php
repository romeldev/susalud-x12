<?php

namespace Romeldev\SusaludX12\Segments;

class GsSegment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 8;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'GS01', 'Alfanumerico',  2,  2,  'HS');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'GS02', 'Alfanumerico',  2, 15,  '');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'GS03', 'Alfanumerico',  2, 15,  '');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'GS04', 'Alfanumerico',  8,  8,  '');
        $this->campoSubTrama[4] = $this->crearCampo(5, 'GS05', 'Alfanumerico',  4,  8,  '');
        $this->campoSubTrama[5] = $this->crearCampo(6, 'GS06', 'Numerico',      1,  9,  '');
        $this->campoSubTrama[6] = $this->crearCampo(7, 'GS07', 'Alfanumerico',  1,  2,  'X');
        $this->campoSubTrama[7] = $this->crearCampo(8, 'GS08', 'Alfanumerico',  1, 12,  '00501');
    }

    /**
     * @param string $sIdRemitente
     * @param string $sIdReceptor
     * @param string $sFeTransaccion
     * @param string $sHoTransaccion
     * @param string $sNuControl
     * @return void
     */
    public function generaSubTrama5($sIdRemitente, $sIdReceptor, $sFeTransaccion, $sHoTransaccion, $sNuControl)
    {
        $this->campoSubTrama[1]->contenido = $sIdRemitente;
        $this->campoSubTrama[2]->contenido = $sIdReceptor;
        $this->campoSubTrama[3]->contenido = $sFeTransaccion;
        $this->campoSubTrama[4]->contenido = $sHoTransaccion;
        $this->campoSubTrama[5]->contenido = $sNuControl;
    }

    /**
     * @param string $sTiTx
     * @param string $sIdRemitente
     * @param string $sIdReceptor
     * @param string $sFeTransaccion
     * @param string $sHoTransaccion
     * @param string $sNuControl
     * @return void
     */
    public function generaSubTrama($sTiTx, $sIdRemitente, $sIdReceptor, $sFeTransaccion, $sHoTransaccion, $sNuControl)
    {
        $this->campoSubTrama[0]->contenido = $sTiTx;
        $this->campoSubTrama[1]->contenido = $sIdRemitente;
        $this->campoSubTrama[2]->contenido = $sIdReceptor;
        $this->campoSubTrama[3]->contenido = $sFeTransaccion;
        $this->campoSubTrama[4]->contenido = $sHoTransaccion;
        $this->campoSubTrama[5]->contenido = $sNuControl;
    }
}
