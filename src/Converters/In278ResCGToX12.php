<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In278ResCG;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\InsSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In278ResCGToX12
{
    /**
     * @param In278ResCG $in278ResCG
     * @return string
     */
    public static function traducirEstructura278Res(In278ResCG $in278ResCG)
    {
        $in278ResCG->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in278ResCG->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment(); $isa->generaSubTrama($in278ResCG->idRemitente, $in278ResCG->idReceptor, $in278ResCG->feTransaccion, $in278ResCG->hoTransaccion, $in278ResCG->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HI', $in278ResCG->idRemitente, $in278ResCG->idReceptor, $in278ResCG->feTransaccion, $in278ResCG->hoTransaccion, $in278ResCG->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($in278ResCG->idTransaccion, $in278ResCG->nuControlST, ''); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0022', $in278ResCG->tiFinalidad); $bht->completaLongitud();

        $hl1 = new HlSegment(); $hl1->generaSubTrama3('1', '20', '1'); $hl1->completaLongitud();
        $nm11 = new Nm1Segment(); $nm11->generaSubTrama4('PR', $in278ResCG->caRemitente, 'PI', $in278ResCG->idRemitente); $nm11->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('2', '1', '21', '1'); $hl2->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('1P', $in278ResCG->caReceptor, 'SV', $in278ResCG->nuRucReceptor); $nm12->completaLongitud();
        $hl3 = new HlSegment(); $hl3->generaSubTrama('3', '2', '22', '0'); $hl3->completaLongitud();

        $sDetalle = '';
        $detalles = $in278ResCG->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $det->caPaciente, $det->apPaternoPaciente, $det->noPaciente, 'MI', $det->coAfPaciente, $det->apMaternoPaciente); $nm13->completaLongitud();
                $r1 = new RefSegment(); $r1->generaSubTrama2('DD', $det->coTiDoPaciente); $r1->completaLongitud();
                $r1_4 = new Ref4Segment(); $r1_4->generaSubTrama2('4A', $det->nuDoPaciente); $r1_4->completaLongitud();
                $ins1 = new InsSegment(); $ins1->generaSubTrama('Y', 'F7', $det->monPago); $ins1->completaLongitud();
                $nm1_4 = new Nm1Segment(); $nm1_4->generaSubTrama('P5', $det->tiCaContratante, $det->noPaContratante, $det->noContratante, '', '', $det->noMaContratante); $nm1_4->completaLongitud();
                $r2 = new RefSegment(); $r2->generaSubTrama2('DD', $det->tiDoContratante); $r2->completaLongitud();
                $r2_4 = new Ref4Segment(); $r2_4->generaSubTrama2($det->idCaReContratante, $det->nuCaReContratante); $r2_4->completaLongitud();
                $r3 = new RefSegment(); $r3->generaSubTrama('5F', '', $det->deCarGarantia); $r3->completaLongitud();
                $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('ZZ', $det->nuSoCarGarantia); $r3_4->completaLongitud();
                $r4 = new RefSegment(); $r4->generaSubTrama2('BB', $det->nuCarGarantia); $r4->completaLongitud();
                $r4_4 = new Ref4Segment(); $r4_4->generaSubTrama2('ZZ', $det->veCarGarantia); $r4_4->completaLongitud();
                $r5 = new RefSegment(); $r5->generaSubTrama2('ACC', $det->esCarGarantia); $r5->completaLongitud();
                $r6 = new RefSegment(); $r6->generaSubTrama2('OZ', $det->coProducto); $r6->completaLongitud();
                $r7 = new RefSegment(); $r7->generaSubTrama('ZZ', $det->coProcedimiento, $det->deProcedimiento); $r7->completaLongitud();
                $r8 = new RefSegment(); $r8->generaSubTrama2('18', $det->nuPlan); $r8->completaLongitud();
                $r8_4 = new Ref4Segment(); $r8_4->generaSubTrama('IMP', $det->tiPlanSalud, 'ZZ', $det->coMoneda, '', ''); $r8_4->completaLongitud();
                $dtp6 = new DtpSegment(); $dtp6->generaSubTrama('447', 'DT', $det->feCarGarantia); $dtp6->completaLongitud();

                $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                    . $r1->returnComoString('REF*', '*', '*' . $r1_4->returnComoString('', ':', '~'))
                    . $ins1->returnComoString('INS*', '*', '~')
                    . $nm1_4->returnComoString('NM1*', '*', '~')
                    . $r2->returnComoString('REF*', '*', '*' . $r2_4->returnComoString('', ':', '~'))
                    . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                    . $r4->returnComoString('REF*', '*', '*' . $r4_4->returnComoString('', ':', '~'))
                    . $r5->returnComoString('REF*', '*', '~')
                    . $r6->returnComoString('REF*', '*', '~')
                    . $r7->returnComoString('REF*', '*', '~')
                    . $r8->returnComoString('REF*', '*', '*' . $r8_4->returnComoString('', ':', '~'))
                    . $dtp6->returnComoString('DTP*', '*', '~');
            }
        } else {
            $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', '', '', '', 'MI', '', ''); $nm13->completaLongitud();
            $r1 = new RefSegment(); $r1->generaSubTrama2('DD', ''); $r1->completaLongitud();
            $r1_4 = new Ref4Segment(); $r1_4->generaSubTrama2('4A', ''); $r1_4->completaLongitud();
            $ins1 = new InsSegment(); $ins1->generaSubTrama('Y', 'F7', ''); $ins1->completaLongitud();
            $nm1_4 = new Nm1Segment(); $nm1_4->generaSubTrama('P5', '', '', '', '', '', ''); $nm1_4->completaLongitud();
            $r2 = new RefSegment(); $r2->generaSubTrama2('DD', ''); $r2->completaLongitud();
            $r2_4 = new Ref4Segment(); $r2_4->generaSubTrama2('', ''); $r2_4->completaLongitud();
            $r3 = new RefSegment(); $r3->generaSubTrama('5F', '', ''); $r3->completaLongitud();
            $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('ZZ', ''); $r3_4->completaLongitud();
            $r4 = new RefSegment(); $r4->generaSubTrama2('BB', ''); $r4->completaLongitud();
            $r4_4 = new Ref4Segment(); $r4_4->generaSubTrama2('ZZ', ''); $r4_4->completaLongitud();
            $r5 = new RefSegment(); $r5->generaSubTrama2('ACC', ''); $r5->completaLongitud();
            $r6 = new RefSegment(); $r6->generaSubTrama2('OZ', ''); $r6->completaLongitud();
            $r7 = new RefSegment(); $r7->generaSubTrama('ZZ', '', ''); $r7->completaLongitud();
            $r8 = new RefSegment(); $r8->generaSubTrama2('18', ''); $r8->completaLongitud();
            $r8_4 = new Ref4Segment(); $r8_4->generaSubTrama('IMP', '', 'ZZ', '', '', ''); $r8_4->completaLongitud();
            $dtp6 = new DtpSegment(); $dtp6->generaSubTrama('447', 'DT', ''); $dtp6->completaLongitud();

            $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                . $r1->returnComoString('REF*', '*', '*' . $r1_4->returnComoString('', ':', '~'))
                . $ins1->returnComoString('INS*', '*', '~')
                . $nm1_4->returnComoString('NM1*', '*', '~')
                . $r2->returnComoString('REF*', '*', '*' . $r2_4->returnComoString('', ':', '~'))
                . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                . $r4->returnComoString('REF*', '*', '*' . $r4_4->returnComoString('', ':', '~'))
                . $r5->returnComoString('REF*', '*', '~')
                . $r6->returnComoString('REF*', '*', '~')
                . $r7->returnComoString('REF*', '*', '~')
                . $r8->returnComoString('REF*', '*', '*' . $r8_4->returnComoString('', ':', '~'))
                . $dtp6->returnComoString('DTP*', '*', '~');
        }

        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm11->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm12->returnComoString('NM1*', '*', '~')
            . $hl3->returnComoString('HL*', '*', '~')
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $in278ResCG->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($in278ResCG->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($in278ResCG->idCorrelativo); $iea->completaLongitud();

        return $sReturn . $se->returnComoString('SE*', '*', '~') . $ge->returnComoString('GE*', '*', '~') . $iea->returnComoString('IEA*', '*', '~');
    }

    /** @param string $sReturn @return string */
    private static function cantidadSegementosTx($sReturn)
    {
        $arrayCadena = explode('~', $sReturn);
        $count = count(array_filter($arrayCadena, function ($s) { return $s !== ''; }));
        return (string) $count;
    }
}
