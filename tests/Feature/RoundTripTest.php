<?php

namespace Romeldev\SusaludX12\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Romeldev\SusaludX12\Beans\InRegAfi270;
use Romeldev\SusaludX12\Converters\RegAfi270ToBean;
use Romeldev\SusaludX12\Converters\RegAfi270ToX12;
use Romeldev\SusaludX12\Services\RegAfi270Service;

class RoundTripTest extends TestCase
{
    public function testRegAfi270RoundTrip()
    {
        // Create original bean
        $original = new InRegAfi270();
        $original->noTransaccion = '270_REGAFI';
        $original->idRemitente = '00004210';
        $original->idReceptor = '10001';
        $original->feTransaccion = '20250516';
        $original->hoTransaccion = '090400';
        $original->idCorrelativo = '000000001';
        $original->idTransaccion = '270';
        $original->tiFinalidad = '13';
        $original->caRemitente = '2';
        $original->nuRucRemitente = '20230089630';
        $original->caReceptor = '2';
        $original->caPaciente = '1';
        $original->tiDocumento = '1';
        $original->nuDocumento = '72918104';

        // Convert to X12
        $x12 = RegAfi270ToX12::traducirEstructura270($original);

        // Convert back to bean
        $roundTrip = RegAfi270ToBean::traducirEstructura270($x12);

        // Verify critical fields survive the round trip (trimmed comparison)
        $this->assertEquals($original->noTransaccion, $roundTrip->noTransaccion);
        $this->assertEquals($original->idRemitente, trim($roundTrip->idRemitente));
        $this->assertEquals($original->idReceptor, trim($roundTrip->idReceptor));
        $this->assertEquals($original->feTransaccion, trim($roundTrip->feTransaccion));
        $this->assertEquals($original->idCorrelativo, trim($roundTrip->idCorrelativo));
        $this->assertEquals($original->tiFinalidad, trim($roundTrip->tiFinalidad));
        $this->assertEquals($original->caRemitente, trim($roundTrip->caRemitente));
        $this->assertStringContainsString($original->nuRucRemitente, $roundTrip->nuRucRemitente);
        $this->assertEquals($original->caReceptor, trim($roundTrip->caReceptor));
        $this->assertEquals($original->caPaciente, trim($roundTrip->caPaciente));
        $this->assertStringContainsString($original->nuDocumento, $roundTrip->nuDocumento);
    }

    public function testRegAfi270ServiceBeanToX12()
    {
        $service = new RegAfi270Service();
        $bean = new InRegAfi270();
        $bean->noTransaccion = '270_REGAFI';
        $bean->idRemitente = '00004210';
        $bean->idReceptor = '10001';
        $bean->feTransaccion = '20250516';
        $bean->hoTransaccion = '090400';
        $bean->idCorrelativo = '000000001';
        $bean->idTransaccion = '270';
        $bean->tiFinalidad = '13';
        $bean->caRemitente = '2';
        $bean->nuRucRemitente = '20230089630';
        $bean->caReceptor = '2';
        $bean->caPaciente = '1';
        $bean->tiDocumento = '1';
        $bean->nuDocumento = '72918104';

        $x12 = $service->beanToX12($bean);

        $this->assertStringStartsWith('ISA*', $x12);
        $this->assertStringContainsString('GS*HS*', $x12);
        $this->assertStringContainsString('ST*270*', $x12);
        $this->assertStringContainsString('IEA*', $x12);
    }

    public function testRegAfi270ServiceX12ToBean()
    {
        $x12 = 'ISA*00*          *00*          *ZZ*00004210       *ZZ*10001          *250516*0904*|*00501*000000001*0*T*:~GS*HS*00004210       *10001          *20250516*090400  *023000460*X *00501       ~ST*270*88462671 *                                   ~BHT*0022*13~HL*1           *            *20*1~NM1*PR *2*                                                            *                                   *                         *          *          *PI*20230089630         *  *   *                                                            ~HL*2           *1           *21*1~NM1*RGA*2*10001                                                       *                                   *                         *          *          *  *                    *  *   *                                                            ~HL*3           *2           *22*0~NM1*IL *1*                                                            *                                   *                         *          *          *  *                    *  *   *                                                            ~REF*DD *1                                                                               *                                                                                *4A :72918104            :   :                    :   :                    ~SE*11        *88462671 ~GE*1     *023000460~IEA*1    *000000001~';

        $service = new RegAfi270Service();
        $bean = $service->x12ToBean($x12);

        $this->assertInstanceOf(InRegAfi270::class, $bean);
        $this->assertEquals('270_REGAFI', $bean->noTransaccion);
        $this->assertStringContainsString('00004210', $bean->idRemitente);
    }
}
