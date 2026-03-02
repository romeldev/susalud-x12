<?php

namespace Romeldev\SusaludX12\Segments;

/**
 * Representa la definición de un campo dentro de un segmento X12.
 * Port directo de pe.gob.susalud.jr.transaccion.susalud.trama.Campos
 */
class Campo
{
    /** @var int */
    public $orden = 0;

    /** @var string */
    public $nombre = '';

    /** @var string Numerico|Alfanumerico */
    public $atributo = '';

    /** @var int */
    public $ubicacionByte = 0;

    /** @var int */
    public $longitudmin = 0;

    /** @var int */
    public $longitudmax = 0;

    /** @var string */
    public $descripcion = '';

    /** @var string */
    public $contenido = '';

    /** @var int */
    public $requerido = 1;

    /** @var int */
    public $validar = 0;

    /**
     * Llena el campo extrayendo contenido desde una trama por posición de byte.
     *
     * @param string $tramaLlegada
     * @return void
     */
    public function llenaCampo($tramaLlegada)
    {
        $this->contenido = substr($tramaLlegada, $this->ubicacionByte, $this->longitudmax);
    }

    /**
     * Completa la longitud del campo con padding.
     * Numérico: padding con '0' a la izquierda.
     * Alfanumérico: padding con ' ' a la derecha.
     *
     * @return void
     */
    public function completaLongitud()
    {
        $longitudReal = ($this->contenido === null) ? 0 : strlen($this->contenido);

        if ($this->longitudmax < $longitudReal || $this->contenido === null) {
            if ($this->atributo === 'Numerico') {
                $this->contenido = '0';
            } elseif ($this->atributo === 'Alfanumerico') {
                $this->contenido = '';
            }
            $longitudReal = strlen($this->contenido);
        }

        $padding = $this->longitudmax - $longitudReal;
        if ($padding > 0) {
            if ($this->atributo === 'Numerico') {
                $this->contenido = str_repeat('0', $padding) . $this->contenido;
            } elseif ($this->atributo === 'Alfanumerico') {
                $this->contenido = $this->contenido . str_repeat(' ', $padding);
            }
        }
    }
}
