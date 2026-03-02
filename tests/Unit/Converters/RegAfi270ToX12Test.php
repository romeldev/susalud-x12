<?php

namespace Romeldev\SusaludX12\Tests\Unit\Converters;

use PHPUnit\Framework\TestCase;
use Romeldev\SusaludX12\Beans\InRegAfi270;
use Romeldev\SusaludX12\Converters\RegAfi270ToX12;

class RegAfi270ToX12Test extends TestCase
{
    public function testBeanToX12GeneratesValidStructure()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // Verify ISA segment
        $this->assertStringStartsWith('ISA*', $x12);
        // Verify segment terminator
        $this->assertStringEndsWith('~', $x12);
        // Verify all expected segments are present
        $this->assertStringContainsString('ISA*', $x12);
        $this->assertStringContainsString('GS*HS*', $x12);
        $this->assertStringContainsString('ST*270*', $x12);
        $this->assertStringContainsString('BHT*0022*13', $x12);
        $this->assertStringContainsString('HL*', $x12);
        $this->assertStringContainsString('NM1*PR', $x12);
        $this->assertStringContainsString('NM1*RGA', $x12);
        $this->assertStringContainsString('NM1*IL', $x12);
        $this->assertStringContainsString('REF*DD', $x12);
        $this->assertStringContainsString('SE*', $x12);
        $this->assertStringContainsString('GE*', $x12);
        $this->assertStringContainsString('IEA*', $x12);
    }

    public function testBeanToX12ContainsCorrectIdRemitente()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // ISA06 should contain idRemitente padded to 15 chars
        $this->assertStringContainsString('00004210       ', $x12);
    }

    public function testBeanToX12ContainsCorrectIdReceptor()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // ISA08 should contain idReceptor padded to 15 chars
        $this->assertStringContainsString('10001          ', $x12);
    }

    public function testBeanToX12ContainsCorrectDate()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // ISA09 should have YYMMDD format (250516 from 20250516)
        $this->assertStringContainsString('250516', $x12);
        // GS04 should have YYYYMMDD format
        $this->assertStringContainsString('20250516', $x12);
    }

    public function testBeanToX12ContainsCorrectRuc()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // NM109 in PR segment should contain the RUC
        $this->assertStringContainsString('PI*20230089630', $x12);
    }

    public function testBeanToX12ContainsCorrectDocumento()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // REF should contain document type and number
        $this->assertStringContainsString('REF*DD', $x12);
        $this->assertStringContainsString('72918104', $x12);
    }

    public function testBeanToX12HasCorrectSegmentCount()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // Should have 11 segments before SE (ISA, GS, ST, BHT, HL, NM1, HL, NM1, HL, NM1, REF)
        $this->assertStringContainsString('SE*11', $x12);
    }

    public function testBeanToX12HasCorrectIdCorrelativo()
    {
        $bean = $this->createTestBean();
        $x12 = RegAfi270ToX12::traducirEstructura270($bean);

        // IEA02 should contain idCorrelativo
        $this->assertStringContainsString('IEA*1    *000000001~', $x12);
    }

    /**
     * @return InRegAfi270
     */
    private function createTestBean()
    {
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
        return $bean;
    }
}
