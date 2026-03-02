<?php

namespace Romeldev\SusaludX12\Segments;

class Eb13Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 8;
        $this->campoSubTrama[0] = $this->crearCampo(1, 'EB1301', 'Numerico',     2,  2, '', 1, 'Cód. Calificador de Producto/Servicio');
        $this->campoSubTrama[1] = $this->crearCampo(2, 'EB1302', 'Alfanumerico', 1,  3, '', 1, 'ID de Producto/Servicio');
        $this->campoSubTrama[2] = $this->crearCampo(3, 'EB1303', 'Alfanumerico', 1, 35, '', 1, '');
        $this->campoSubTrama[3] = $this->crearCampo(4, 'EB1304', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[4] = $this->crearCampo(5, 'EB1305', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[5] = $this->crearCampo(6, 'EB1306', 'Alfanumerico', 2,  2, '', 1, '');
        $this->campoSubTrama[6] = $this->crearCampo(7, 'EB1307', 'Alfanumerico', 1, 80, '', 1, '');
        $this->campoSubTrama[7] = $this->crearCampo(8, 'EB1308', 'Alfanumerico', 1, 20, '', 1, '');
    }

    /**
     * @param string $sICalificadorServicio
     * @param string $sIdProductoServicio
     * @param string $sDescripcionProducto
     * @return void
     */
    public function generaSubTrama($sICalificadorServicio, $sIdProductoServicio, $sDescripcionProducto)
    {
        $this->campoSubTrama[0]->contenido = $sICalificadorServicio;
        $this->campoSubTrama[1]->contenido = $sIdProductoServicio;
        $this->campoSubTrama[4]->contenido = $sDescripcionProducto;
    }
}
