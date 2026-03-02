<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConMed271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\EbSegment;
use Romeldev\SusaludX12\Segments\Eb13Segment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\MsgSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class ConMed271ToX12
{
    /**
     * Convierte un bean InConMed271 a una trama X12.
     *
     * @param InConMed271 $inConMed
     * @return string
     */
    public static function traducirEstructura271(InConMed271 $inConMed)
    {
        $inConMed->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConMed->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment();
        $isa->generaSubTrama($inConMed->idRemitente, $inConMed->idReceptor, $inConMed->feTransaccion, $inConMed->hoTransaccion, $inConMed->idCorrelativo);
        $isa->completaLongitud();

        $gs = new GsSegment();
        $gs->generaSubTrama('HB', $inConMed->idRemitente, $inConMed->idReceptor, $inConMed->feTransaccion, $inConMed->hoTransaccion, $inConMed->nuControl);
        $gs->completaLongitud();

        $st = new StSegment();
        $st->generaSubTrama($inConMed->idTransaccion, $inConMed->nuControlST, '');
        $st->completaLongitud();

        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $inConMed->tiFinalidad);
        $bht->completaLongitud();

        $hl = new HlSegment();
        $hl->generaSubTrama3('1', '20', '1');
        $hl->completaLongitud();

        $nm1 = new Nm1Segment();
        $nm1->generaSubTrama4('PR', $inConMed->caRemitente, 'PI', $inConMed->idRemitente);
        $nm1->completaLongitud();

        $hl1 = new HlSegment();
        $hl1->generaSubTrama('2', '1', '21', '1');
        $hl1->completaLongitud();

        $nm12 = new Nm1Segment();
        $nm12->generaSubTrama4('1P', $inConMed->caReceptor, 'SV', $inConMed->nuRucReceptor);
        $nm12->completaLongitud();

        $hl2 = new HlSegment();
        $hl2->generaSubTrama('3', '2', '22', '0');
        $hl2->completaLongitud();

        $nm13 = new Nm1Segment();
        $nm13->generaSubTrama('IL', $inConMed->caPaciente, $inConMed->apPaternoPaciente, $inConMed->noPaciente, 'MI', $inConMed->coPaciente, $inConMed->apMaternoPaciente);
        $nm13->completaLongitud();

        $sDetalle = '';
        $detalles = $inConMed->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $eb1 = new EbSegment();
                $eb1->generaSubTrama('W', '', $det->coSeCIE10, '', '', '', '', '');
                $eb1->completaLongitud();
                $eb113 = new Eb13Segment();
                $eb113->generaSubTrama('ZZ', $det->coRestriccion, '');
                $eb113->completaLongitud();
                $r1 = new RefSegment();
                $r1->generaSubTrama('82', '', $det->dePreexistencia);
                $r1->completaLongitud();
                $msg1 = new MsgSegment();
                $msg1->generaSubTrama($det->msgObsPr, 'LC', $det->idFuenteRE);
                $msg1->completaLongitud();
                $eb2 = new EbSegment();
                $eb2->generaSubTrama($det->esCobertura, '', '', '', '', $det->moDiagnostico, '', '');
                $eb2->completaLongitud();
                $dtp1 = new DtpSegment();
                $dtp1->generaSubTrama('150', 'D8', $det->tiEspera);
                $dtp1->completaLongitud();

                $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                    . $eb1->returnComoString('EB*', '*', '*' . $eb113->returnComoString('', ':', '~'))
                    . $r1->returnComoString('REF*', '*', '~')
                    . $msg1->returnComoString('MSG*', '*', '~')
                    . $eb2->returnComoString('EB*', '*', '~')
                    . $dtp1->returnComoString('DTP*', '*', '~');
            }
        } else {
            $eb1 = new EbSegment();
            $eb1->generaSubTrama('W', '', '', '', '', '', '', '');
            $eb1->completaLongitud();
            $eb113 = new Eb13Segment();
            $eb113->generaSubTrama('ZZ', '', '');
            $eb113->completaLongitud();
            $r1 = new RefSegment();
            $r1->generaSubTrama('82', '', '');
            $r1->completaLongitud();
            $msg1 = new MsgSegment();
            $msg1->generaSubTrama('');
            $msg1->completaLongitud();
            $eb2 = new EbSegment();
            $eb2->generaSubTrama('', '', '', '', '', '', '', '');
            $eb2->completaLongitud();
            $dtp1 = new DtpSegment();
            $dtp1->generaSubTrama('150', 'D8', '');
            $dtp1->completaLongitud();

            $sDetalle .= $nm13->returnComoString('NM1*', '*', '~')
                . $eb1->returnComoString('EB*', '*', '*' . $eb113->returnComoString('', ':', '~'))
                . $r1->returnComoString('REF*', '*', '~')
                . $msg1->returnComoString('MSG*', '*', '~')
                . $eb2->returnComoString('EB*', '*', '~')
                . $dtp1->returnComoString('DTP*', '*', '~');
        }

        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm12->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inConMed->nuControlST);
        $se->completaLongitud();
        $ge = new GeSegment();
        $ge->generaSubTrama($inConMed->nuControl);
        $ge->completaLongitud();
        $iea = new IeaSegment();
        $iea->generaSubTrama($inConMed->idCorrelativo);
        $iea->completaLongitud();

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
