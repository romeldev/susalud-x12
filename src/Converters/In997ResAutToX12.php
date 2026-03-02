<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In997ResAut;
use Romeldev\SusaludX12\Segments\Ak1Segment;
use Romeldev\SusaludX12\Segments\Ak2Segment;
use Romeldev\SusaludX12\Segments\Ak5Segment;
use Romeldev\SusaludX12\Segments\Ak9Segment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In997ResAutToX12
{
    /**
     * Convierte un bean In997ResAut a una trama X12.
     *
     * @param In997ResAut $in997ResAut
     * @return string
     */
    public static function traducirEstructura997ResAut(In997ResAut $in997ResAut)
    {
        $in997ResAut->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in997ResAut->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $in997ResAut->idRemitente,
            $in997ResAut->idReceptor,
            $in997ResAut->feTransaccion,
            $in997ResAut->hoTransaccion,
            $in997ResAut->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'FA',
            $in997ResAut->idRemitente,
            $in997ResAut->idReceptor,
            $in997ResAut->feTransaccion,
            $in997ResAut->hoTransaccion,
            $in997ResAut->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $in997ResAut->idTransaccion,
            $in997ResAut->nuControlST,
            ''
        );
        $st->completaLongitud();

        // AK1
        $ak1 = new Ak1Segment();
        $ak1->generaSubTrama('PO', $in997ResAut->nuControl, $in997ResAut->nuAutorizacion);
        $ak1->completaLongitud();

        // AK2
        $ak2 = new Ak2Segment();
        $ak2->generaSubTrama($in997ResAut->idTransaccion, $in997ResAut->nuControlST, $in997ResAut->coSeguridad);
        $ak2->completaLongitud();

        // AK5
        $ak5 = new Ak5Segment();
        $ak5->generaSubTrama($in997ResAut->coError, $in997ResAut->inCoErrorEncontrado);
        $ak5->completaLongitud();

        // AK9
        $ak9 = new Ak9Segment();
        $ak9->generaSubTrama($in997ResAut->coError, '1', '1', '1');
        $ak9->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $ak1->returnComoString('AK1*', '*', '~')
            . $ak2->returnComoString('AK2*', '*', '~')
            . $ak5->returnComoString('AK5*', '*', '~')
            . $ak9->returnComoString('AK9*', '*', '~');

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $in997ResAut->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($in997ResAut->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($in997ResAut->idCorrelativo);
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
