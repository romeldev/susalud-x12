<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConAse270;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\PrvSegment;
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class ConAse270ToX12
{
    /**
     * Convierte un bean InConAse270 a una trama X12.
     *
     * @param InConAse270 $inConAse
     * @return string
     */
    public static function traducirEstructura270(InConAse270 $inConAse)
    {
        $inConAse->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConAse->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama($inConAse->idRemitente, $inConAse->idReceptor, $inConAse->feTransaccion, $inConAse->hoTransaccion, $inConAse->idCorrelativo);
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama('HS', $inConAse->idRemitente, $inConAse->idReceptor, $inConAse->feTransaccion, $inConAse->hoTransaccion, $inConAse->nuControl);
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama($inConAse->idTransaccion, $inConAse->nuControlST, '');
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $inConAse->tiFinalidad);
        $bht->completaLongitud();

        // HL1
        $hl1 = new HlSegment();
        $hl1->generaSubTrama3('1', '20', '1');
        $hl1->completaLongitud();

        // NM1 - PR
        $nm1Pr = new Nm1Segment();
        $nm1Pr->generaSubTrama4('PR', $inConAse->caRemitente, 'PI', $inConAse->nuRucRemitente);
        $nm1Pr->completaLongitud();

        // PRV
        $prv = new PrvSegment();
        $prv->generaSubTrama('OR', '', $inConAse->txRequest);
        $prv->completaLongitud();

        // HL2
        $hl2 = new HlSegment();
        $hl2->generaSubTrama('2', '1', '21', '1');
        $hl2->completaLongitud();

        // NM1 - 1P
        $nm1_1P = new Nm1Segment();
        $nm1_1P->generaSubTrama4('1P', $inConAse->caRemitente, 'FI', $inConAse->idReceptor);
        $nm1_1P->completaLongitud();

        // HL3
        $hl3 = new HlSegment();
        $hl3->generaSubTrama('3', '2', '22', '0');
        $hl3->completaLongitud();

        // NM1 - IL
        $nm1Il = new Nm1Segment();
        $nm1Il->generaSubTrama('IL', $inConAse->caPaciente, $inConAse->apPaternoPaciente, $inConAse->noPaciente, '', $inConAse->coAfPaciente, $inConAse->apMaternoPaciente);
        $nm1Il->completaLongitud();

        // REF1
        $ref1 = new RefSegment();
        $ref1->generaSubTrama2('DD', $inConAse->tiDocumento);
        $ref1->completaLongitud();

        // REF2
        $ref2 = new RefSegment();
        $ref2->generaSubTrama2('4A', $inConAse->nuDocumento);
        $ref2->completaLongitud();

        // REF3 + REF3_4
        $ref3 = new RefSegment();
        $ref3->generaSubTrama('PRT', $inConAse->coProducto, $inConAse->deProducto);
        $ref3->completaLongitud();
        $ref3_4 = new Ref4Segment();
        $ref3_4->generaSubTrama2('ZZ', $inConAse->coInProducto);
        $ref3_4->completaLongitud();

        // REF4 + REF4_4
        $ref4 = new RefSegment();
        $ref4->generaSubTrama('D7', $inConAse->nuCobertura, $inConAse->deCobertura);
        $ref4->completaLongitud();
        $ref4_4 = new Ref4Segment();
        $ref4_4->generaSubTrama($inConAse->caServicio, $inConAse->coCalservicio, $inConAse->beMaxInicial);
        $ref4_4->completaLongitud();

        // REF5 + REF5_4
        $ref5 = new RefSegment();
        $ref5->generaSubTrama2('D7', $inConAse->coTiCobertura);
        $ref5->completaLongitud();
        $ref5_4 = new Ref4Segment();
        $ref5_4->generaSubTrama2('ZZ', $inConAse->coSuTiCobertura);
        $ref5_4->completaLongitud();

        // REF6
        $ref6 = new RefSegment();
        $ref6->generaSubTrama2('8X', $inConAse->coAplicativoTx);
        $ref6->completaLongitud();

        // REF7
        $ref7 = new RefSegment();
        $ref7->generaSubTrama2('S2', $inConAse->coEspecialidad);
        $ref7->completaLongitud();

        // REF8
        $ref8 = new RefSegment();
        $ref8->generaSubTrama2('ZZ', $inConAse->coParentesco);
        $ref8->completaLongitud();

        // REF9 + REF9_4
        $ref9 = new RefSegment();
        $ref9->generaSubTrama2('18', $inConAse->nuPlan);
        $ref9->completaLongitud();
        $ref9_4 = new Ref4Segment();
        $ref9_4->generaSubTrama2('ZZ', $inConAse->nuAutOrigen);
        $ref9_4->completaLongitud();

        // REF10
        $ref10 = new RefSegment();
        $ref10->generaSubTrama2('PRT', $inConAse->tiAccidente);
        $ref10->completaLongitud();

        // DTP1
        $dtp1 = new DtpSegment();
        $dtp1->generaSubTrama('447', 'D8', $inConAse->feAccidente);
        $dtp1->completaLongitud();

        // NM1 - P5
        $nm1P5 = new Nm1Segment();
        $nm1P5->generaSubTrama('P5', $inConAse->tiCaContratante, $inConAse->noPaContratante, $inConAse->noContratante, '', '', $inConAse->noMaContratante);
        $nm1P5->completaLongitud();

        // REF11 + REF11_4
        $ref11 = new RefSegment();
        $ref11->generaSubTrama2('DD', $inConAse->tiDoContratante);
        $ref11->completaLongitud();
        $ref11_4 = new Ref4Segment();
        $ref11_4->generaSubTrama2($inConAse->idReContratante, $inConAse->coReContratante);
        $ref11_4->completaLongitud();

        // Build X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm1Pr->returnComoString('NM1*', '*', '~')
            . $prv->returnComoString('PRV*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm1_1P->returnComoString('NM1*', '*', '~')
            . $hl3->returnComoString('HL*', '*', '~')
            . $nm1Il->returnComoString('NM1*', '*', '~')
            . $ref1->returnComoString('REF*', '*', '~')
            . $ref2->returnComoString('REF*', '*', '~')
            . $ref3->returnComoString('REF*', '*', '*' . $ref3_4->returnComoString('', ':', '~'))
            . $ref4->returnComoString('REF*', '*', '*' . $ref4_4->returnComoString('', ':', '~'))
            . $ref5->returnComoString('REF*', '*', '*' . $ref5_4->returnComoString('', ':', '~'))
            . $ref6->returnComoString('REF*', '*', '~')
            . $ref7->returnComoString('REF*', '*', '~')
            . $ref8->returnComoString('REF*', '*', '~')
            . $ref9->returnComoString('REF*', '*', '*' . $ref9_4->returnComoString('', ':', '~'))
            . $ref10->returnComoString('REF*', '*', '~')
            . $dtp1->returnComoString('DTP*', '*', '~')
            . $nm1P5->returnComoString('NM1*', '*', '~')
            . $ref11->returnComoString('REF*', '*', '*' . $ref11_4->returnComoString('', ':', '~'));

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inConAse->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($inConAse->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($inConAse->idCorrelativo);
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
