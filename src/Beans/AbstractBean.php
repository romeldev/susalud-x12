<?php

namespace Romeldev\SusaludX12\Beans;

/**
 * Clase base para todos los beans de transacciones X12 SUSALUD.
 *
 * Implementa magic methods para:
 * - Aplicar trim() automáticamente a valores string (replica comportamiento Java)
 * - Resolver aliases de propiedades (ej. getDetalles() → inConCod271Detalles)
 */
abstract class AbstractBean
{
    /**
     * Mapa de aliases de propiedades.
     * Las subclases pueden sobreescribir para definir aliases.
     *
     * Ejemplo: ['detalles' => 'inConCod271Detalles']
     *
     * @return array
     */
    protected function getPropertyAliases()
    {
        return [];
    }

    /**
     * Magic getter — retorna por referencia para que operaciones como
     * $bean->detalles[] = $item funcionen correctamente con arrays.
     *
     * @param string $name
     * @return mixed
     */
    public function &__get($name)
    {
        $realName = $this->resolveAlias($name);
        return $this->$realName;
    }

    /**
     * Magic setter — aplica trim() a valores string (replica Java setters).
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $realName = $this->resolveAlias($name);
        $this->$realName = is_string($value) ? trim($value) : $value;
    }

    /**
     * Magic isset — necesario para que empty() e isset() funcionen con propiedades protegidas.
     *
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        $realName = $this->resolveAlias($name);
        return isset($this->$realName);
    }

    /**
     * Resuelve un alias de propiedad al nombre real.
     *
     * @param string $name
     * @return string
     */
    private function resolveAlias($name)
    {
        $aliases = $this->getPropertyAliases();
        return isset($aliases[$name]) ? $aliases[$name] : $name;
    }
}
