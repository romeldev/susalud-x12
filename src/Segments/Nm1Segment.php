<?php

namespace Romeldev\SusaludX12\Segments;

class Nm1Segment extends AbstractSegment
{
    public function __construct()
    {
        parent::__construct();
        $this->numCamposSubTrama = 12;
        $this->campoSubTrama[0]  = $this->crearCampo(1,  'NM101', 'Alfanumerico', 2,  3,  '', 1, 'Codigo identificador');
        $this->campoSubTrama[1]  = $this->crearCampo(2,  'NM102', 'Alfanumerico', 1,  1,  '', 1, 'Tipo calificador');
        $this->campoSubTrama[2]  = $this->crearCampo(3,  'NM103', 'Alfanumerico', 1, 60,  '', 1, 'Apellido pat/Nombre Org.');
        $this->campoSubTrama[3]  = $this->crearCampo(4,  'NM104', 'Alfanumerico', 1, 35,  '', 1, 'Nombres');
        $this->campoSubTrama[4]  = $this->crearCampo(5,  'NM105', 'Alfanumerico', 1, 25,  '', 0, 'Segundo nombre');
        $this->campoSubTrama[5]  = $this->crearCampo(6,  'NM106', 'Alfanumerico', 1, 10,  '', 0, 'Prefijo de nombre');
        $this->campoSubTrama[6]  = $this->crearCampo(7,  'NM107', 'Alfanumerico', 1, 10,  '', 0, 'Sufijo de nombre');
        $this->campoSubTrama[7]  = $this->crearCampo(8,  'NM108', 'Alfanumerico', 1,  2,  '', 0, 'Codigo Calificador');
        $this->campoSubTrama[8]  = $this->crearCampo(9,  'NM109', 'Alfanumerico', 2, 20,  '', 0, 'Codigo de Identificacion');
        $this->campoSubTrama[9]  = $this->crearCampo(10, 'NM110', 'Alfanumerico', 2,  2,  '', 0, 'Codigo de referencia con Entidad');
        $this->campoSubTrama[10] = $this->crearCampo(11, 'NM111', 'Alfanumerico', 2,  3,  '', 0, 'Codigo de identificacion de Entidad');
        $this->campoSubTrama[11] = $this->crearCampo(12, 'NM112', 'Alfanumerico', 1, 60,  '', 0, 'Apellido materno');
    }

    /**
     * Genera NM1 con identificador y calificador (para PR/payer).
     *
     * @param string $sCoIdentificador
     * @param string $sTiCalificador
     * @param string $sCoCalificador
     * @param string $sCoIdentificacion
     * @return void
     */
    public function generaSubTrama4($sCoIdentificador, $sTiCalificador, $sCoCalificador, $sCoIdentificacion)
    {
        $this->campoSubTrama[0]->contenido = $sCoIdentificador;
        $this->campoSubTrama[1]->contenido = $sTiCalificador;
        $this->campoSubTrama[7]->contenido = $sCoCalificador;
        $this->campoSubTrama[8]->contenido = $sCoIdentificacion;
    }

    /**
     * Genera NM1 con dos parámetros.
     *
     * @param string $sParam1
     * @param string $sParam5
     * @return void
     */
    public function generaSubTrama2($sParam1, $sParam5)
    {
        $this->campoSubTrama[0]->contenido = $sParam1;
        $this->campoSubTrama[4]->contenido = $sParam5;
    }

    /**
     * Genera NM1 con datos de persona (para IL/subscriber, RGA/receiver, etc).
     *
     * @param string $sCoIdentificador
     * @param string $sTiCalificador
     * @param string $sApPaterno
     * @param string $sNombres
     * @param string $coIdentificacion
     * @param string $coAfiliado
     * @param string $sApMaterno
     * @return void
     */
    public function generaSubTrama($sCoIdentificador, $sTiCalificador, $sApPaterno, $sNombres, $coIdentificacion, $coAfiliado, $sApMaterno)
    {
        $this->campoSubTrama[0]->contenido  = $sCoIdentificador;
        $this->campoSubTrama[1]->contenido  = $sTiCalificador;
        $this->campoSubTrama[2]->contenido  = $sApPaterno;
        $this->campoSubTrama[3]->contenido  = $sNombres;
        $this->campoSubTrama[7]->contenido  = $coIdentificacion;
        $this->campoSubTrama[8]->contenido  = $coAfiliado;
        $this->campoSubTrama[11]->contenido = $sApMaterno;
    }
}
