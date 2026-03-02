<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConProc271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\EbSegment;
use Romeldev\SusaludX12\Segments\Eb13Segment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\HsdSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\MsgSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In271ConProcToX12
{
    /**
     * @param InConProc271 $inConProc271
     * @return string
     */
    public static function traducirEstructura278ConProc(InConProc271 $inConProc271)
    {
        $inConProc271->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConProc271->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment();
        $isa->generaSubTrama($inConProc271->idRemitente, $inConProc271->idReceptor, $inConProc271->feTransaccion, $inConProc271->hoTransaccion, $inConProc271->idCorrelativo);
        $isa->completaLongitud();
        $gs = new GsSegment();
        $gs->generaSubTrama('HI', $inConProc271->idRemitente, $inConProc271->idReceptor, $inConProc271->feTransaccion, $inConProc271->hoTransaccion, $inConProc271->nuControl);
        $gs->completaLongitud();
        $st = new StSegment();
        $st->generaSubTrama($inConProc271->idTransaccion, $inConProc271->nuControlST, '');
        $st->completaLongitud();
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $inConProc271->tiFinalidad);
        $bht->completaLongitud();

        $hl1 = new HlSegment();
        $hl1->generaSubTrama3('1', '20', '1');
        $hl1->completaLongitud();
        $nm11 = new Nm1Segment();
        $nm11->generaSubTrama4('PR', $inConProc271->caRemitente, 'PI', $inConProc271->idRemitente);
        $nm11->completaLongitud();

        $hl2 = new HlSegment();
        $hl2->generaSubTrama('2', '1', '21', '1');
        $hl2->completaLongitud();
        $nm12 = new Nm1Segment();
        $nm12->generaSubTrama4('1P', $inConProc271->caReceptor, 'SV', $inConProc271->nuRucReceptor);
        $nm12->completaLongitud();

        $hl3 = new HlSegment();
        $hl3->generaSubTrama('3', '2', '22', '0');
        $hl3->completaLongitud();
        $nm13 = new Nm1Segment();
        $nm13->generaSubTrama('IL', $inConProc271->caPaciente, $inConProc271->apPaternoPaciente, $inConProc271->noPaciente, 'MI', $inConProc271->coAfPaciente, $inConProc271->apMaternoPaciente);
        $nm13->completaLongitud();

        $sDetalle = '';
        $detalles = $inConProc271->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $eb1 = new EbSegment();
                $eb1->generaSubTrama('1', '', '', '', '', '', $det->coInProcedimiento, '');
                $eb1->completaLongitud();
                $eb2 = new EbSegment();
                $eb2->generaSubTrama('1', '', '', '', '', '', $det->coInRestriccion, '');
                $eb2->completaLongitud();
                $eb3 = new EbSegment();
                $eb3->generaSubTrama('PE', '', $det->coProcedimiento, '', $det->imDeducible, $det->poCuExDecimal, '5U', $det->nuFrecuencia);
                $eb3->completaLongitud();
                $eb3_13 = new Eb13Segment();
                $eb3_13->generaSubTrama('ZZ', $det->coSexo, '');
                $eb3_13->completaLongitud();
                $hsd1 = new HsdSegment();
                $hsd1->generaSubTrama('9S', $det->tiNuDias);
                $hsd1->completaLongitud();
                $msg1 = new MsgSegment();
                $msg1->generaSubTrama3($det->teMsgObservacion, 'LC', $det->idFuentePE);
                $msg1->completaLongitud();
                $eb4 = new EbSegment();
                $eb4->generaSubTrama('TE', '', $det->coTiEspera, '', '', '', '', '');
                $eb4->completaLongitud();
                $r1 = new RefSegment();
                $r1->generaSubTrama('82', '', $det->deTiEspera);
                $r1->completaLongitud();
                $dtp1 = new DtpSegment();
                $dtp1->generaSubTrama('327', 'D8', $det->feFinVigencia);
                $dtp1->completaLongitud();
                $msg2 = new MsgSegment();
                $msg2->generaSubTrama3($det->teMsgTiEspera, 'LC', $det->idFuenteTE);
                $msg2->completaLongitud();
                $eb5 = new EbSegment();
                $eb5->generaSubTrama('EC', '', $det->coExCarencia, '', '', '', '', '');
                $eb5->completaLongitud();
                $r2 = new RefSegment();
                $r2->generaSubTrama('82', '', $det->deExCarencia);
                $r2->completaLongitud();
                $msg3 = new MsgSegment();
                $msg3->generaSubTrama3($det->teMsgExCarencia, 'LC', $det->idFuenteEC);
                $msg3->completaLongitud();

                $sDetalle .= $eb1->returnComoString('EB*', '*', '~')
                    . $eb2->returnComoString('EB*', '*', '~')
                    . $eb3->returnComoString('EB*', '*', '*' . $eb3_13->returnComoString('', ':', '~'))
                    . $hsd1->returnComoString('HSD*', '*', '~')
                    . $msg1->returnComoString('MSG*', '*', '~')
                    . $eb4->returnComoString('EB*', '*', '~')
                    . $r1->returnComoString('REF*', '*', '~')
                    . $dtp1->returnComoString('DTP*', '*', '~')
                    . $msg2->returnComoString('MSG*', '*', '~')
                    . $eb5->returnComoString('EB*', '*', '~')
                    . $r2->returnComoString('REF*', '*', '~')
                    . $msg3->returnComoString('MSG*', '*', '~');
            }
        } else {
            $eb1 = new EbSegment(); $eb1->generaSubTrama('1', '', '', '', '', '', '', ''); $eb1->completaLongitud();
            $eb2 = new EbSegment(); $eb2->generaSubTrama('1', '', '', '', '', '', '', ''); $eb2->completaLongitud();
            $eb3 = new EbSegment(); $eb3->generaSubTrama('PE', '', '', '', '', '', '5U', ''); $eb3->completaLongitud();
            $eb3_13 = new Eb13Segment(); $eb3_13->generaSubTrama('ZZ', '', ''); $eb3_13->completaLongitud();
            $hsd1 = new HsdSegment(); $hsd1->generaSubTrama('9S', ''); $hsd1->completaLongitud();
            $msg1 = new MsgSegment(); $msg1->generaSubTrama1(''); $msg1->completaLongitud();
            $eb4 = new EbSegment(); $eb4->generaSubTrama('TE', '', '', '', '', '', '', ''); $eb4->completaLongitud();
            $r1 = new RefSegment(); $r1->generaSubTrama('82', '', ''); $r1->completaLongitud();
            $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('327', 'D8', ''); $dtp1->completaLongitud();
            $msg2 = new MsgSegment(); $msg2->generaSubTrama1(''); $msg2->completaLongitud();
            $eb5 = new EbSegment(); $eb5->generaSubTrama('EC', '', '', '', '', '', '', ''); $eb5->completaLongitud();
            $r2 = new RefSegment(); $r2->generaSubTrama('82', '', ''); $r2->completaLongitud();
            $msg3 = new MsgSegment(); $msg3->generaSubTrama1(''); $msg3->completaLongitud();

            $sDetalle .= $eb1->returnComoString('EB*', '*', '~')
                . $eb2->returnComoString('EB*', '*', '~')
                . $eb3->returnComoString('EB*', '*', '*' . $eb3_13->returnComoString('', ':', '~'))
                . $hsd1->returnComoString('HSD*', '*', '~')
                . $msg1->returnComoString('MSG*', '*', '~')
                . $eb4->returnComoString('EB*', '*', '~')
                . $r1->returnComoString('REF*', '*', '~')
                . $dtp1->returnComoString('DTP*', '*', '~')
                . $msg2->returnComoString('MSG*', '*', '~')
                . $eb5->returnComoString('EB*', '*', '~')
                . $r2->returnComoString('REF*', '*', '~')
                . $msg3->returnComoString('MSG*', '*', '~');
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
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $inConProc271->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($inConProc271->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($inConProc271->idCorrelativo); $iea->completaLongitud();

        return $sReturn
            . $se->returnComoString('SE*', '*', '~')
            . $ge->returnComoString('GE*', '*', '~')
            . $iea->returnComoString('IEA*', '*', '~');
    }

    /**
     * @param string $sReturn
     * @return string
     */
    private static function cantidadSegementosTx($sReturn)
    {
        $arrayCadena = explode('~', $sReturn);
        $count = count(array_filter($arrayCadena, function ($s) {
            return $s !== '';
        }));
        return (string) $count;
    }
}
