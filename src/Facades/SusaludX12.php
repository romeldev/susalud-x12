<?php

namespace Romeldev\SusaludX12\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * === Transacciones 270 ===
 * @method static \Romeldev\SusaludX12\Services\ConAse270Service conAse270()
 * @method static \Romeldev\SusaludX12\Services\RegAfi270Service regAfi270()
 *
 * === Transacciones 271 ===
 * @method static \Romeldev\SusaludX12\Services\ConCod271Service conCod271()
 * @method static \Romeldev\SusaludX12\Services\ConMed271Service conMed271()
 * @method static \Romeldev\SusaludX12\Services\ConNom271Service conNom271()
 * @method static \Romeldev\SusaludX12\Services\In271ConDtadService in271ConDtad()
 * @method static \Romeldev\SusaludX12\Services\In271ConObsService in271ConObs()
 * @method static \Romeldev\SusaludX12\Services\In271ConProcService in271ConProc()
 * @method static \Romeldev\SusaludX12\Services\In271ResDerivaService in271ResDeriva()
 * @method static \Romeldev\SusaludX12\Services\In271ResSctrService in271ResSctr()
 * @method static \Romeldev\SusaludX12\Services\RegAfi271Service regAfi271()
 * @method static \Romeldev\SusaludX12\Services\LogAcreInsert271Service logAcreInsert271()
 * @method static \Romeldev\SusaludX12\Services\SolAut271Service solAut271()
 *
 * === Transacciones 278 ===
 * @method static \Romeldev\SusaludX12\Services\In278SolCGService in278SolCG()
 * @method static \Romeldev\SusaludX12\Services\In278ResCGService in278ResCG()
 * @method static \Romeldev\SusaludX12\Services\ConEntVinc278Service conEntVinc278()
 * @method static \Romeldev\SusaludX12\Services\ResEntVinc278Service resEntVinc278()
 *
 * === Transacciones 997 ===
 * @method static \Romeldev\SusaludX12\Services\In997ResAutService in997ResAut()
 *
 * === Manager ===
 * @method static \Romeldev\SusaludX12\Services\Contracts\TransactionServiceInterface service(string $name)
 * @method static array availableServices()
 *
 * @see \Romeldev\SusaludX12\Services\RomeldevSusaludX12Manager
 */
class RomeldevSusaludX12 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'susalud-x12';
    }
}
