<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InResEntVinc278;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\CrcSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\MsgSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class ResEntVinc278ToX12
{
    /**
     * Convierte un bean InResEntVinc278 a una trama X12.
     *
     * @param InResEntVinc278 $inResEntVinc
     * @return string
     */
    public static function traducirEstructura271(InResEntVinc278 $inResEntVinc)
    {
        $inResEntVinc->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inResEntVinc->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $inResEntVinc->idRemitente,
            $inResEntVinc->idReceptor,
            $inResEntVinc->feTransaccion,
            $inResEntVinc->hoTransaccion,
            $inResEntVinc->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HB',
            $inResEntVinc->idRemitente,
            $inResEntVinc->idReceptor,
            $inResEntVinc->feTransaccion,
            $inResEntVinc->hoTransaccion,
            $inResEntVinc->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $inResEntVinc->idTransaccion,
            $inResEntVinc->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0020', $inResEntVinc->tiFinalidad);
        $bht->completaLongitud();

        // HL
        $hl = new HlSegment();
        $hl->generaSubTrama3('1', '20', '0');
        $hl->completaLongitud();

        // CRC
        $crc = new CrcSegment();
        $crc->generaSubTrama('ZZ', $inResEntVinc->respuesta);
        $crc->completaLongitud();

        // MSG
        $msg = new MsgSegment();
        $msg->generaSubTrama($inResEntVinc->msgRespuesta);
        $msg->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $crc->returnComoString('CRC*', '*', '~')
            . $msg->returnComoString('MSG*', '*', '~');

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inResEntVinc->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($inResEntVinc->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($inResEntVinc->idCorrelativo);
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
