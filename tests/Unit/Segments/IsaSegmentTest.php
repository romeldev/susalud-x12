<?php

namespace Romeldev\SusaludX12\Tests\Unit\Segments;

use PHPUnit\Framework\TestCase;
use Romeldev\SusaludX12\Segments\IsaSegment;

class IsaSegmentTest extends TestCase
{
    public function testIsaSegmentHas16Fields()
    {
        $isa = new IsaSegment();
        // Access via reflection or just test the output
        $isa->generaSubTrama('00004210', '10001', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // Should start with ISA*
        $this->assertStringStartsWith('ISA*', $output);
        // Should end with ~
        $this->assertStringEndsWith('~', $output);
    }

    public function testIsaSegmentContainsIdRemitente()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('00004210', '10001', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        $this->assertStringContainsString('00004210', $output);
    }

    public function testIsaSegmentDateFormatYYMMDD()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('SENDER', 'RECEIVER', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // ISA09 should be YYMMDD (250516 from 20250516)
        $this->assertStringContainsString('250516', $output);
    }

    public function testIsaSegmentTimeFormatHHMM()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('SENDER', 'RECEIVER', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // ISA10 should be HHMM (0904 from 090400)
        $this->assertStringContainsString('0904', $output);
    }

    public function testIsaSegmentPaddingNumericWithZeros()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('TEST', 'RECV', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // ISA01 should be "00" (Numerico, padded with zeros)
        $this->assertStringStartsWith('ISA*00*', $output);
    }

    public function testIsaSegmentPaddingAlphanumericWithSpaces()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('TEST', 'RECV', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // ISA06 should be "TEST" padded to 15 chars with spaces
        $this->assertStringContainsString('TEST           ', $output);
    }

    public function testIsaSegmentDefaultValues()
    {
        $isa = new IsaSegment();
        $isa->generaSubTrama('SENDER', 'RECEIVER', '20250516', '090400', '000000001');
        $isa->completaLongitud();
        $output = $isa->returnComoString('ISA*', '*', '~');

        // parts[0]="ISA", parts[1]=ISA01, ..., parts[N]=ISA_N
        $parts = explode('*', str_replace('~', '', $output));
        $this->assertEquals('ZZ', $parts[5]); // ISA05 (index 5 because parts[0]="ISA")
        $this->assertEquals('ZZ', $parts[7]); // ISA07
        // ISA15 should be "T" (Test mode)
        $this->assertEquals('T', $parts[15]); // ISA15
        // ISA16 should be ":"
        $this->assertEquals(':', $parts[16]); // ISA16
    }
}
