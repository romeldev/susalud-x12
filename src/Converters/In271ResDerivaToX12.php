<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ResDeriva;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In271ResDerivaToX12
{
    /**
     * @param In271ResDeriva $in271ResDeriva
     * @return string
     */
    public static function traducirEstructura278ResDeriva(In271ResDeriva $in271ResDeriva)
    {
        $in271ResDeriva->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in271ResDeriva->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment();
        $isa->generaSubTrama($in271ResDeriva->idRemitente, $in271ResDeriva->idReceptor, $in271ResDeriva->feTransaccion, $in271ResDeriva->hoTransaccion, $in271ResDeriva->idCorrelativo);
        $isa->completaLongitud();
        $gs = new GsSegment();
        $gs->generaSubTrama('HI', $in271ResDeriva->idRemitente, $in271ResDeriva->idReceptor, $in271ResDeriva->feTransaccion, $in271ResDeriva->hoTransaccion, $in271ResDeriva->nuControl);
        $gs->completaLongitud();
        $st = new StSegment();
        $st->generaSubTrama($in271ResDeriva->idTransaccion, $in271ResDeriva->nuControlST, '');
        $st->completaLongitud();
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $in271ResDeriva->tiFinalidad);
        $bht->completaLongitud();

        $hl1 = new HlSegment(); $hl1->generaSubTrama3('1', '20', '1'); $hl1->completaLongitud();
        $nm11 = new Nm1Segment(); $nm11->generaSubTrama4('PR', $in271ResDeriva->caRemitente, 'PI', $in271ResDeriva->idRemitente); $nm11->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('2', '1', '21', '1'); $hl2->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('1P', $in271ResDeriva->caReceptor, 'SV', $in271ResDeriva->nuRucReceptor); $nm12->completaLongitud();
        $hl3 = new HlSegment(); $hl3->generaSubTrama('3', '2', '22', '0'); $hl3->completaLongitud();

        $sDetalle = '';
        $detalles = $in271ResDeriva->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $det->caPaciente, $det->apPaternoPaciente, $det->noPaciente, 'MI', $det->coAfPaciente, $det->apMaternoPaciente); $nm13->completaLongitud();
                $r1 = new RefSegment(); $r1->generaSubTrama2('DD', $det->coTiDoPaciente); $r1->completaLongitud();
                $r1_4 = new Ref4Segment(); $r1_4->generaSubTrama2('4A', $det->nuDoPaciente); $r1_4->completaLongitud();
                $r2 = new RefSegment(); $r2->generaSubTrama2('ZZ', $det->coParentesco); $r2->completaLongitud();
                $r3 = new RefSegment(); $r3->generaSubTrama2('DD', $det->tiDoTrabajoAfiliado); $r3->completaLongitud();
                $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('XX5', $det->nuDoTrabajoAfiliado); $r3_4->completaLongitud();
                $r4 = new RefSegment(); $r4->generaSubTrama('BB', $det->nuAtencion, $det->teMsgLibre1); $r4->completaLongitud();
                $r5 = new RefSegment(); $r5->generaSubTrama('PRT', $det->coTiProducto, $det->deProducto); $r5->completaLongitud();
                $r6 = new RefSegment(); $r6->generaSubTrama2('D7', $det->coTiCobertura); $r6->completaLongitud();
                $r6_4 = new Ref4Segment(); $r6_4->generaSubTrama2('ZZ', $det->coSubTiCobertura); $r6_4->completaLongitud();
                $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('382', 'D8', $det->feAtSalud); $dtp1->completaLongitud();
                $nm1_4 = new Nm1Segment(); $nm1_4->generaSubTrama('C9', '2', $det->noLuAtencion, '', 'MI', '', ''); $nm1_4->completaLongitud();
                $r7 = new RefSegment(); $r7->generaSubTrama('EI', $det->coLuAtencion, ''); $r7->completaLongitud();
                $r8 = new RefSegment(); $r8->generaSubTrama2('DD', $det->tiDoContratante); $r8->completaLongitud();
                $r8_4 = new Ref4Segment(); $r8_4->generaSubTrama2($det->idCaReferencia, $det->reIdContratante); $r8_4->completaLongitud();

                $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                    . $r1->returnComoString('REF*', '*', '*' . $r1_4->returnComoString('', ':', '~'))
                    . $r2->returnComoString('REF*', '*', '~')
                    . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                    . $r4->returnComoString('REF*', '*', '~')
                    . $r5->returnComoString('REF*', '*', '~')
                    . $r6->returnComoString('REF*', '*', '*' . $r6_4->returnComoString('', ':', '~'))
                    . $dtp1->returnComoString('DTP*', '*', '~')
                    . $nm1_4->returnComoString('NM1*', '*', '~')
                    . $r7->returnComoString('REF*', '*', '~')
                    . $r8->returnComoString('REF*', '*', '*' . $r8_4->returnComoString('', ':', '~'));
            }
        } else {
            $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', '', '', '', 'MI', '', ''); $nm13->completaLongitud();
            $r1 = new RefSegment(); $r1->generaSubTrama2('DD', ''); $r1->completaLongitud();
            $r1_4 = new Ref4Segment(); $r1_4->generaSubTrama2('4A', ''); $r1_4->completaLongitud();
            $r2 = new RefSegment(); $r2->generaSubTrama2('ZZ', ''); $r2->completaLongitud();
            $r3 = new RefSegment(); $r3->generaSubTrama2('DD', ''); $r3->completaLongitud();
            $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('4A', ''); $r3_4->completaLongitud();
            $r4 = new RefSegment(); $r4->generaSubTrama('BB', '', ''); $r4->completaLongitud();
            $r5 = new RefSegment(); $r5->generaSubTrama('PRT', '', ''); $r5->completaLongitud();
            $r6 = new RefSegment(); $r6->generaSubTrama2('D7', ''); $r6->completaLongitud();
            $r6_4 = new Ref4Segment(); $r6_4->generaSubTrama2('ZZ', ''); $r6_4->completaLongitud();
            $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('382', 'D8', ''); $dtp1->completaLongitud();
            $nm1_4 = new Nm1Segment(); $nm1_4->generaSubTrama('C9', '2', '', '', 'MI', '', ''); $nm1_4->completaLongitud();
            $r7 = new RefSegment(); $r7->generaSubTrama('EI', '', ''); $r7->completaLongitud();
            $r8 = new RefSegment(); $r8->generaSubTrama2('DD', ''); $r8->completaLongitud();
            $r8_4 = new Ref4Segment(); $r8_4->generaSubTrama2('', ''); $r8_4->completaLongitud();

            $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                . $r1->returnComoString('REF*', '*', '*' . $r1_4->returnComoString('', ':', '~'))
                . $r2->returnComoString('REF*', '*', '~')
                . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                . $r4->returnComoString('REF*', '*', '~')
                . $r5->returnComoString('REF*', '*', '~')
                . $r6->returnComoString('REF*', '*', '*' . $r6_4->returnComoString('', ':', '~'))
                . $dtp1->returnComoString('DTP*', '*', '~')
                . $nm1_4->returnComoString('NM1*', '*', '~')
                . $r7->returnComoString('REF*', '*', '~')
                . $r8->returnComoString('REF*', '*', '*' . $r8_4->returnComoString('', ':', '~'));
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
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $in271ResDeriva->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($in271ResDeriva->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($in271ResDeriva->idCorrelativo); $iea->completaLongitud();

        return $sReturn
            . $se->returnComoString('SE*', '*', '~')
            . $ge->returnComoString('GE*', '*', '~')
            . $iea->returnComoString('IEA*', '*', '~');
    }

    /** @param string $sReturn @return string */
    private static function cantidadSegementosTx($sReturn)
    {
        $arrayCadena = explode('~', $sReturn);
        $count = count(array_filter($arrayCadena, function ($s) { return $s !== ''; }));
        return (string) $count;
    }
}
