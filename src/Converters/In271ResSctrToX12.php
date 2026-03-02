<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ResSctr;
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

class In271ResSctrToX12
{
    /**
     * @param In271ResSctr $in271ResSctr
     * @return string
     */
    public static function traducirEstructura271ResSctr(In271ResSctr $in271ResSctr)
    {
        $in271ResSctr->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in271ResSctr->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment(); $isa->generaSubTrama($in271ResSctr->idRemitente, $in271ResSctr->idReceptor, $in271ResSctr->feTransaccion, $in271ResSctr->hoTransaccion, $in271ResSctr->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HB', $in271ResSctr->idRemitente, $in271ResSctr->idReceptor, $in271ResSctr->feTransaccion, $in271ResSctr->hoTransaccion, $in271ResSctr->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($in271ResSctr->idTransaccion, $in271ResSctr->nuControlST, ''); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0022', $in271ResSctr->tiFinalidad); $bht->completaLongitud();

        $hl1 = new HlSegment(); $hl1->generaSubTrama3('1', '20', '1'); $hl1->completaLongitud();
        $nm11 = new Nm1Segment(); $nm11->generaSubTrama4('PR', $in271ResSctr->caRemitente, 'PI', $in271ResSctr->idRemitente); $nm11->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('2', '1', '21', '1'); $hl2->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('1P', $in271ResSctr->caReceptor, 'SV', $in271ResSctr->nuRucReceptor); $nm12->completaLongitud();
        $hl3 = new HlSegment(); $hl3->generaSubTrama('3', '2', '22', '1'); $hl3->completaLongitud();
        $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $in271ResSctr->caPaciente, $in271ResSctr->apPaternoPaciente, $in271ResSctr->noPaciente, 'MI', $in271ResSctr->coAfPaciente, $in271ResSctr->apMaternoPaciente); $nm13->completaLongitud();

        $ref1 = new RefSegment(); $ref1->generaSubTrama('DD', $in271ResSctr->coTiDoPaciente, $in271ResSctr->nuDocPaciente); $ref1->completaLongitud();
        $ref1_4 = new Ref4Segment(); $ref1_4->generaSubTrama2('4A', $in271ResSctr->nuDocPaciente); $ref1_4->completaLongitud();

        $sDetalle = '';
        $detalles = $in271ResSctr->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $nm14 = new Nm1Segment(); $nm14->generaSubTrama('C9', $det->tiCaContratante, $det->noEmApPaContratante, '', 'MI', '', ''); $nm14->completaLongitud();
                $r2 = new RefSegment(); $r2->generaSubTrama('EI', $det->coEmContratante, ''); $r2->completaLongitud();
                $r3 = new RefSegment(); $r3->generaSubTrama('DD', '6', ''); $r3->completaLongitud();
                $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2($det->idCaReContratante, $det->reIdContratante); $r3_4->completaLongitud();
                $nm15 = new Nm1Segment(); $nm15->generaSubTrama('C9', $det->tiCaLuAtencion, $det->noEmLuAtencion, '', '', '', ''); $nm15->completaLongitud();
                $r4 = new RefSegment(); $r4->generaSubTrama('EI', $det->coEmReLuAtencion, ''); $r4->completaLongitud();
                $r5 = new RefSegment(); $r5->generaSubTrama('DD', '6', ''); $r5->completaLongitud();
                $r5_4 = new Ref4Segment(); $r5_4->generaSubTrama2($det->idCaReLuAtencion, $det->reIdLuAtencion); $r5_4->completaLongitud();
                $r6 = new RefSegment(); $r6->generaSubTrama('BB', $det->coLuAtencion, ''); $r6->completaLongitud();
                $r7 = new RefSegment(); $r7->generaSubTrama2('3H', $det->deTiAccidente); $r7->completaLongitud();
                $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('382', 'D8', $det->feAfiliacion); $dtp1->completaLongitud();
                $dtp2 = new DtpSegment(); $dtp2->generaSubTrama('382', 'D8', $det->feOcAccidente); $dtp2->completaLongitud();

                $sDetalle .= $nm14->returnComoString('NM1*', '*', '~')
                    . $r2->returnComoString('REF*', '*', '~')
                    . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                    . $nm15->returnComoString('NM1*', '*', '~')
                    . $r4->returnComoString('REF*', '*', '~')
                    . $r5->returnComoString('REF*', '*', '*' . $r5_4->returnComoString('', ':', '~'))
                    . $r6->returnComoString('REF*', '*', '~')
                    . $r7->returnComoString('REF*', '*', '~')
                    . $dtp1->returnComoString('DTP*', '*', '~')
                    . $dtp2->returnComoString('DTP*', '*', '~');
            }
        } else {
            $nm14 = new Nm1Segment(); $nm14->generaSubTrama('C9', '', '', '', 'MI', '', ''); $nm14->completaLongitud();
            $r2 = new RefSegment(); $r2->generaSubTrama('EI', '', ''); $r2->completaLongitud();
            $r3 = new RefSegment(); $r3->generaSubTrama('DD', '6', ''); $r3->completaLongitud();
            $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('', ''); $r3_4->completaLongitud();
            $nm15 = new Nm1Segment(); $nm15->generaSubTrama('C9', '', '', '', '', '', ''); $nm15->completaLongitud();
            $r4 = new RefSegment(); $r4->generaSubTrama('EI', '', ''); $r4->completaLongitud();
            $r5 = new RefSegment(); $r5->generaSubTrama('DD', '6', ''); $r5->completaLongitud();
            $r5_4 = new Ref4Segment(); $r5_4->generaSubTrama2('', ''); $r5_4->completaLongitud();
            $r6 = new RefSegment(); $r6->generaSubTrama('BB', '', ''); $r6->completaLongitud();
            $r7 = new RefSegment(); $r7->generaSubTrama2('3H', ''); $r7->completaLongitud();
            $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('382', 'D8', ''); $dtp1->completaLongitud();
            $dtp2 = new DtpSegment(); $dtp2->generaSubTrama('382', 'D8', ''); $dtp2->completaLongitud();

            $sDetalle .= $nm14->returnComoString('NM1*', '*', '~')
                . $r2->returnComoString('REF*', '*', '~')
                . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
                . $nm15->returnComoString('NM1*', '*', '~')
                . $r4->returnComoString('REF*', '*', '~')
                . $r5->returnComoString('REF*', '*', '*' . $r5_4->returnComoString('', ':', '~'))
                . $r6->returnComoString('REF*', '*', '~')
                . $r7->returnComoString('REF*', '*', '~')
                . $dtp1->returnComoString('DTP*', '*', '~')
                . $dtp2->returnComoString('DTP*', '*', '~');
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
            . $nm13->returnComoString('NM1*', '*', '~')
            . $ref1->returnComoString('REF*', '*', '*' . $ref1_4->returnComoString('', ':', '~'))
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $in271ResSctr->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($in271ResSctr->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($in271ResSctr->idCorrelativo); $iea->completaLongitud();

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
