<?php

namespace Romeldev\SusaludX12\Services;

use InvalidArgumentException;

/**
 * Manager principal para acceso a servicios de transacciones X12.
 */
class SusaludX12Manager
{
    /** @var array */
    private $services = [];

    /** @var array Mapa de nombres a clases de servicio */
    private static $serviceMap = [
        'RegAfi270'     => RegAfi270Service::class,
        'ConAse270'     => ConAse270Service::class,
        'RegAfi271'     => RegAfi271Service::class,
        'ConCod271'     => ConCod271Service::class,
        'ConMed271'     => ConMed271Service::class,
        'ConNom271'     => ConNom271Service::class,
        'SolAut271'     => SolAut271Service::class,
        'In271ConDtad'  => In271ConDtadService::class,
        'In271ConObs'   => In271ConObsService::class,
        'In271ConProc'  => In271ConProcService::class,
        'In271ResDeriva' => In271ResDerivaService::class,
        'In271ResSctr'  => In271ResSctrService::class,
        'LogAcreInsert271' => LogAcreInsert271Service::class,
        'In278SolCG'    => In278SolCGService::class,
        'In278ResCG'    => In278ResCGService::class,
        'ConEntVinc278' => ConEntVinc278Service::class,
        'ResEntVinc278' => ResEntVinc278Service::class,
        'In997ResAut'   => In997ResAutService::class,
    ];

    /**
     * Obtiene un servicio por nombre.
     *
     * @param string $name
     * @return \Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface
     * @throws InvalidArgumentException
     */
    public function service($name)
    {
        if (!isset($this->services[$name])) {
            if (!isset(self::$serviceMap[$name])) {
                throw new InvalidArgumentException("Servicio de transacción no encontrado: {$name}");
            }
            $class = self::$serviceMap[$name];
            $this->services[$name] = new $class();
        }
        return $this->services[$name];
    }

    /**
     * @return RegAfi270Service
     */
    public function regAfi270()
    {
        return $this->service('RegAfi270');
    }

    /**
     * @return ConAse270Service
     */
    public function conAse270()
    {
        return $this->service('ConAse270');
    }

    /**
     * Lista los servicios disponibles.
     *
     * @return array
     */
    public function availableServices()
    {
        return array_keys(self::$serviceMap);
    }

    /**
     * Magic method para acceso dinámico a servicios.
     * Ejemplo: $manager->regAfi271() resuelve a service('RegAfi271')
     *
     * @param string $name
     * @param array $arguments
     * @return \Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface
     */
    public function __call($name, $arguments)
    {
        // Convierte camelCase a PascalCase para buscar en el mapa
        $serviceName = ucfirst($name);
        return $this->service($serviceName);
    }
}
