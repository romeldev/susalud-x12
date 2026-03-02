<?php

namespace Romeldev\SusaludX12\Segments;

/**
 * Clase base para todos los segmentos X12.
 * Port directo de pe.gob.susalud.jr.transaccion.susalud.trama.SubTrama
 */
class AbstractSegment
{
    /** @var int */
    protected $numCamposSubTrama = 50;

    /** @var int */
    protected $longitudSubTrama = 1000;

    /** @var string */
    protected $contenidoSubTrama = '';

    /** @var string */
    protected $codigoErrorSubtrama = '0000';

    /** @var Campo[] */
    protected $campoSubTrama = [];

    public function __construct()
    {
        $this->campoSubTrama = array_fill(0, 120, null);
    }

    /**
     * Recibe el contenido completo de la sub-trama para procesamiento.
     *
     * @param string $subTramaEntradaTotal
     * @return void
     */
    public function recibeContenidoSubTrama($subTramaEntradaTotal)
    {
        $this->contenidoSubTrama = $subTramaEntradaTotal;
    }

    /**
     * Procesa la sub-trama: calcula posiciones y extrae contenido de cada campo.
     *
     * @return void
     */
    public function procesaSubTrama()
    {
        $this->fijaLongitud();
        if ($this->longitudSubTrama <= strlen($this->contenidoSubTrama)) {
            for ($i = 0; $i < $this->numCamposSubTrama; $i++) {
                if ($i === 0) {
                    $this->campoSubTrama[$i]->ubicacionByte = 0;
                    $this->campoSubTrama[$i]->orden = 1;
                } else {
                    $this->campoSubTrama[$i]->ubicacionByte =
                        $this->campoSubTrama[$i - 1]->ubicacionByte +
                        $this->campoSubTrama[$i - 1]->longitudmax;
                    $this->campoSubTrama[$i]->orden = $i + 1;
                }
                $this->longitudSubTrama =
                    $this->campoSubTrama[$i]->ubicacionByte +
                    $this->campoSubTrama[$i]->longitudmax;
                $this->campoSubTrama[$i]->llenaCampo($this->contenidoSubTrama);
            }
        } else {
            $this->codigoErrorSubtrama = '5100';
        }
    }

    /**
     * Genera la representación string del segmento con separadores.
     *
     * @param string $sPrefijo Prefijo del segmento (ej: "ISA*")
     * @param string $sCampo Separador de campo (ej: "*")
     * @param string $sSegmento Terminador de segmento (ej: "~")
     * @return string
     */
    public function returnComoString($sPrefijo, $sCampo, $sSegmento)
    {
        $cadena = $sPrefijo;
        for ($i = 0; $i < $this->numCamposSubTrama - 1; $i++) {
            $cadena .= $this->campoSubTrama[$i]->contenido . $sCampo;
        }
        $cadena .= $this->campoSubTrama[$this->numCamposSubTrama - 1]->contenido . $sSegmento;
        return $cadena;
    }

    /**
     * Completa la longitud de todos los campos con padding.
     *
     * @return void
     */
    public function completaLongitud()
    {
        for ($i = 0; $i < $this->numCamposSubTrama; $i++) {
            $this->campoSubTrama[$i]->completaLongitud();
        }
    }

    /**
     * Calcula la longitud total de la sub-trama sumando longitudmax de todos los campos.
     *
     * @return void
     */
    public function fijaLongitud()
    {
        $this->longitudSubTrama = 0;
        for ($i = 0; $i < $this->numCamposSubTrama; $i++) {
            $this->longitudSubTrama += $this->campoSubTrama[$i]->longitudmax;
        }
    }

    /**
     * Obtiene el contenido trimmed de un campo por posición.
     *
     * @param int $pos
     * @return string
     */
    public function getCampoSubTrama($pos)
    {
        return trim($this->campoSubTrama[$pos]->contenido);
    }

    /**
     * @param string $error
     * @return void
     */
    public function setCodigoErrorSubtrama($error)
    {
        $this->codigoErrorSubtrama = $error;
    }

    /**
     * @return string
     */
    public function getCodigoErrorSubtrama()
    {
        return $this->codigoErrorSubtrama;
    }

    /**
     * Helper para crear e inicializar un campo.
     *
     * @param int $orden
     * @param string $nombre
     * @param string $atributo
     * @param int $longitudmin
     * @param int $longitudmax
     * @param string $contenido
     * @param int $requerido
     * @param string $descripcion
     * @return Campo
     */
    protected function crearCampo($orden, $nombre, $atributo, $longitudmin, $longitudmax, $contenido = '', $requerido = 1, $descripcion = '')
    {
        $campo = new Campo();
        $campo->orden = $orden;
        $campo->nombre = $nombre;
        $campo->atributo = $atributo;
        $campo->ubicacionByte = 0;
        $campo->longitudmin = $longitudmin;
        $campo->longitudmax = $longitudmax;
        $campo->descripcion = $descripcion;
        $campo->contenido = $contenido;
        $campo->requerido = $requerido;
        $campo->validar = 0;
        return $campo;
    }
}
