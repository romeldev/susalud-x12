<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In278SolCG;
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

class In278SolCGToX12
{
    /**
     * Convierte un bean In278SolCG a una trama X12.
     *
     * @param In278SolCG $in278SolCG
     * @return string
     */
    public static function traducirEstructura278Sol(In278SolCG $in278SolCG)
    {
        $in278SolCG->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in278SolCG->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $in278SolCG->idRemitente,
            $in278SolCG->idReceptor,
            $in278SolCG->feTransaccion,
            $in278SolCG->hoTransaccion,
            $in278SolCG->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HI',
            $in278SolCG->idRemitente,
            $in278SolCG->idReceptor,
            $in278SolCG->feTransaccion,
            $in278SolCG->hoTransaccion,
            $in278SolCG->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $in278SolCG->idTransaccion,
            $in278SolCG->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0020', $in278SolCG->tiFinalidad);
        $bht->completaLongitud();

        // HL
        $hl = new HlSegment();
        $hl->generaSubTrama3('1', '20', '0');
        $hl->completaLongitud();

        // NM1
        $nm1 = new Nm1Segment();
        $nm1->generaSubTrama(
            'IL',
            $in278SolCG->caPaciente,
            $in278SolCG->apPaternoPaciente,
            $in278SolCG->noPaciente,
            '',
            '',
            $in278SolCG->apMaternoPaciente
        );
        $nm1->completaLongitud();

        // REF1 + REF1_4
        $ref1 = new RefSegment();
        $ref1->generaSubTrama2('DD', $in278SolCG->coTiDoPaciente);
        $ref1->completaLongitud();

        $ref1_4 = new Ref4Segment();
        $ref1_4->generaSubTrama2('4A', $in278SolCG->nuDoPaciente);
        $ref1_4->completaLongitud();

        // REF2 + REF2_4
        $ref2 = new RefSegment();
        $ref2->generaSubTrama2('BB', $in278SolCG->nuCarGarantia);
        $ref2->completaLongitud();

        $ref2_4 = new Ref4Segment();
        $ref2_4->generaSubTrama2('ACC', $in278SolCG->esCarGarantia);
        $ref2_4->completaLongitud();

        // REF3 + REF3_4
        $ref3 = new RefSegment();
        $ref3->generaSubTrama2('5F', '');
        $ref3->completaLongitud();

        $ref3_4 = new Ref4Segment();
        $ref3_4->generaSubTrama2('ZZ', $in278SolCG->nuSoCarGarantia);
        $ref3_4->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $ref1->returnComoString('REF*', '*', '*' . $ref1_4->returnComoString('', ':', '~'))
            . $ref2->returnComoString('REF*', '*', '*' . $ref2_4->returnComoString('', ':', '~'))
            . $ref3->returnComoString('REF*', '*', '*' . $ref3_4->returnComoString('', ':', '~'));

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $in278SolCG->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($in278SolCG->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($in278SolCG->idCorrelativo);
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
