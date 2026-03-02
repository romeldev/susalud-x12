<?php

namespace Romeldev\SusaludX12\Tests\Unit\Converters;

use PHPUnit\Framework\TestCase;
use Romeldev\SusaludX12\Beans\InRegAfi270;
use Romeldev\SusaludX12\Converters\RegAfi270ToBean;

class RegAfi270ToBeanTest extends TestCase
{
    /** @var string */
    private $sampleX12 = 'ISA*00*          *00*          *ZZ*00004210       *ZZ*10001          *250516*0904*|*00501*000000001*0*T*:~GS*HS*00004210       *10001          *20250516*090400  *023000460*X *00501       ~ST*270*88462671 *                                   ~BHT*0022*13~HL*1           *            *20*1~NM1*PR *2*                                                            *                                   *                         *          *          *PI*20230089630         *  *   *                                                            ~HL*2           *1           *21*1~NM1*RGA*2*10001                                                       *                                   *                         *          *          *  *                    *  *   *                                                            ~HL*3           *2           *22*0~NM1*IL *1*                                                            *                                   *                         *          *          *  *                    *  *   *                                                            ~REF*DD *1                                                                               *                                                                                *4A :72918104            :   :                    :   :                    ~SE*11        *88462671 ~GE*1     *023000460~IEA*1    *000000001~';

    public function testX12ToBeanParsesNoTransaccion()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('270_REGAFI', $bean->noTransaccion);
    }

    public function testX12ToBeanParsesIdRemitente()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertStringContainsString('00004210', $bean->idRemitente);
    }

    public function testX12ToBeanParsesIdReceptor()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertStringContainsString('10001', $bean->idReceptor);
    }

    public function testX12ToBeanParsesFeTransaccion()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('20250516', $bean->feTransaccion);
    }

    public function testX12ToBeanParsesIdCorrelativo()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('000000001', $bean->idCorrelativo);
    }

    public function testX12ToBeanParsesIdTransaccion()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('270', trim($bean->idTransaccion));
    }

    public function testX12ToBeanParsesTiFinalidad()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('13', $bean->tiFinalidad);
    }

    public function testX12ToBeanParsesCaRemitente()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertEquals('2', trim($bean->caRemitente));
    }

    public function testX12ToBeanParsesNuRucRemitente()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertStringContainsString('20230089630', $bean->nuRucRemitente);
    }

    public function testX12ToBeanParsesTiDocumento()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertStringContainsString('1', $bean->tiDocumento);
    }

    public function testX12ToBeanParsesNuDocumento()
    {
        $bean = RegAfi270ToBean::traducirEstructura270($this->sampleX12);
        $this->assertStringContainsString('72918104', $bean->nuDocumento);
    }
}
