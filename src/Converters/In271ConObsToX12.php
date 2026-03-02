<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ConObs;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\EbSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\MsgSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In271ConObsToX12
{
    /**
     * Convierte un bean In271ConObs a una trama X12.
     *
     * @param In271ConObs $in271ConObs
     * @return string
     */
    public static function traducirEstructura278ConObs(In271ConObs $in271ConObs)
    {
        $in271ConObs->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in271ConObs->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $in271ConObs->idRemitente,
            $in271ConObs->idReceptor,
            $in271ConObs->feTransaccion,
            $in271ConObs->hoTransaccion,
            $in271ConObs->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HB',
            $in271ConObs->idRemitente,
            $in271ConObs->idReceptor,
            $in271ConObs->feTransaccion,
            $in271ConObs->hoTransaccion,
            $in271ConObs->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $in271ConObs->idTransaccion,
            $in271ConObs->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $in271ConObs->tiFinalidad);
        $bht->completaLongitud();

        // HL1
        $hl1 = new HlSegment();
        $hl1->generaSubTrama3('1', '20', '1');
        $hl1->completaLongitud();

        // NM1 - PR
        $nm1Pr = new Nm1Segment();
        $nm1Pr->generaSubTrama4('PR', $in271ConObs->caRemitente, 'PI', $in271ConObs->idRemitente);
        $nm1Pr->completaLongitud();

        // HL2
        $hl2 = new HlSegment();
        $hl2->generaSubTrama('2', '1', '21', '1');
        $hl2->completaLongitud();

        // NM1 - 1P
        $nm1_1P = new Nm1Segment();
        $nm1_1P->generaSubTrama4('1P', $in271ConObs->caReceptor, 'SV', $in271ConObs->nuRucReceptor);
        $nm1_1P->completaLongitud();

        // HL3
        $hl3 = new HlSegment();
        $hl3->generaSubTrama('3', '2', '22', '1');
        $hl3->completaLongitud();

        // NM1 - IL
        $nm1Il = new Nm1Segment();
        $nm1Il->generaSubTrama(
            'IL',
            $in271ConObs->caPaciente,
            $in271ConObs->apPaternoPaciente,
            $in271ConObs->noPaciente,
            'MI',
            $in271ConObs->coAfPaciente,
            $in271ConObs->apMaternoPaciente
        );
        $nm1Il->completaLongitud();

        // EB
        $eb1 = new EbSegment();
        $eb1->generaSubTrama('1', '', '', $in271ConObs->coSubCobertura, '', '', '', '');
        $eb1->completaLongitud();

        // MSG1
        $msg1 = new MsgSegment();
        $msg1->generaSubTrama($in271ConObs->teMsgLibre1);
        $msg1->completaLongitud();

        // MSG2
        $msg2 = new MsgSegment();
        $msg2->generaSubTrama($in271ConObs->teMsgLibre2);
        $msg2->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm1Pr->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm1_1P->returnComoString('NM1*', '*', '~')
            . $hl3->returnComoString('HL*', '*', '~')
            . $nm1Il->returnComoString('NM1*', '*', '~')
            . $eb1->returnComoString('EB*', '*', '~')
            . $msg1->returnComoString('MSG*', '*', '~')
            . $msg2->returnComoString('MSG*', '*', '~');

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $in271ConObs->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($in271ConObs->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($in271ConObs->idCorrelativo);
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
