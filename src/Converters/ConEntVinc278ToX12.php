<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConEntVinc278;
use Romeldev\SusaludX12\Segments\BhtSegment;
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

class ConEntVinc278ToX12
{
    /**
     * Convierte un bean InConEntVinc278 a una trama X12.
     *
     * @param InConEntVinc278 $inConEntVinc
     * @return string
     */
    public static function traducirEstructura271(InConEntVinc278 $inConEntVinc)
    {
        $inConEntVinc->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConEntVinc->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $inConEntVinc->idRemitente,
            $inConEntVinc->idReceptor,
            $inConEntVinc->feTransaccion,
            $inConEntVinc->hoTransaccion,
            $inConEntVinc->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HB',
            $inConEntVinc->idRemitente,
            $inConEntVinc->idReceptor,
            $inConEntVinc->feTransaccion,
            $inConEntVinc->hoTransaccion,
            $inConEntVinc->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $inConEntVinc->idTransaccion,
            $inConEntVinc->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0020', $inConEntVinc->tiFinalidad);
        $bht->completaLongitud();

        // HL
        $hl = new HlSegment();
        $hl->generaSubTrama3('1', '20', '0');
        $hl->completaLongitud();

        // NM1
        $nm1 = new Nm1Segment();
        $nm1->generaSubTrama(
            'IL',
            $inConEntVinc->caIPRESS,
            '',
            $inConEntVinc->noIPRESS,
            '',
            '',
            ''
        );
        $nm1->completaLongitud();

        // REF1
        $ref1 = new RefSegment();
        $ref1->generaSubTrama2('DD', $inConEntVinc->tiDoIPRESS);
        $ref1->completaLongitud();

        // REF1_4
        $ref1_4 = new Ref4Segment();
        $ref1_4->generaSubTrama2('XX5', $inConEntVinc->nuRucIPRESS);
        $ref1_4->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $ref1->returnComoString('REF*', '*', '*' . $ref1_4->returnComoString('', ':', '~'));

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inConEntVinc->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($inConEntVinc->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($inConEntVinc->idCorrelativo);
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
