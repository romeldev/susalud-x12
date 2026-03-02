<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InLogAcreInsert271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DmgSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\EbSegment;
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

class LogAcreInsert271ToX12
{
    /**
     * @param InLogAcreInsert271 $inLogAcreInsert
     * @return string
     */
    public static function traducirEstructura271(InLogAcreInsert271 $inLogAcreInsert)
    {
        $inLogAcreInsert->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inLogAcreInsert->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment(); $isa->generaSubTrama($inLogAcreInsert->idRemitente, $inLogAcreInsert->idReceptor, $inLogAcreInsert->feTransaccion, $inLogAcreInsert->hoTransaccion, $inLogAcreInsert->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HB', $inLogAcreInsert->idRemitente, $inLogAcreInsert->idReceptor, $inLogAcreInsert->feTransaccion, $inLogAcreInsert->hoTransaccion, $inLogAcreInsert->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($inLogAcreInsert->idTransaccion, $inLogAcreInsert->nuControlST, ''); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0022', $inLogAcreInsert->tiFinalidad); $bht->completaLongitud();

        $hl = new HlSegment(); $hl->generaSubTrama3('1', '20', '1'); $hl->completaLongitud();
        $nm1 = new Nm1Segment(); $nm1->generaSubTrama4('PR', $inLogAcreInsert->caRemitente, 'PI', $inLogAcreInsert->nuRucRemitente); $nm1->completaLongitud();
        $hl1 = new HlSegment(); $hl1->generaSubTrama('2', '1', '21', '1'); $hl1->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('1P', $inLogAcreInsert->caReceptor, 'FI', $inLogAcreInsert->idReceptor); $nm12->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('3', '2', '22', '0'); $hl2->completaLongitud();
        $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $inLogAcreInsert->caPaciente, $inLogAcreInsert->apPaternoPaciente, $inLogAcreInsert->noPaciente, 'MI', $inLogAcreInsert->coAfPaciente, $inLogAcreInsert->apMaternoPaciente); $nm13->completaLongitud();

        $r1 = new RefSegment(); $r1->generaSubTrama2('ACC', $inLogAcreInsert->coEsPaciente); $r1->completaLongitud();
        $r2 = new RefSegment(); $r2->generaSubTrama2('DD', $inLogAcreInsert->tiDoPaciente); $r2->completaLongitud();
        $r24 = new Ref4Segment(); $r24->generaSubTrama2('4A', $inLogAcreInsert->nuDoPaciente); $r24->completaLongitud();
        $r3 = new RefSegment(); $r3->generaSubTrama2('CT', $inLogAcreInsert->nuContratoPaciente); $r3->completaLongitud();
        $r34 = new Ref4Segment(); $r34->generaSubTrama2('TY', $inLogAcreInsert->coTiPolizaAfiliacion); $r34->completaLongitud();
        $r4 = new RefSegment(); $r4->generaSubTrama2('PRT', $inLogAcreInsert->coProducto); $r4->completaLongitud();
        $r5 = new RefSegment(); $r5->generaSubTrama2('18', $inLogAcreInsert->nuPlan); $r5->completaLongitud();
        $r6 = new RefSegment(); $r6->generaSubTrama2('ZZ', $inLogAcreInsert->coParentesco); $r6->completaLongitud();
        $dmg1 = new DmgSegment(); $dmg1->generaSubTrama('D8', $inLogAcreInsert->feNacimiento, $inLogAcreInsert->genero, '', ''); $dmg1->completaLongitud();
        $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('356', 'D8', $inLogAcreInsert->feIniVigencia); $dtp1->completaLongitud();
        $eb1 = new EbSegment(); $eb1->generaSubTrama('1', $inLogAcreInsert->nuCobertura, '', $inLogAcreInsert->deCobertura, '', '', '', ''); $eb1->completaLongitud();
        $nm14 = new Nm1Segment(); $nm14->generaSubTrama('P5', $inLogAcreInsert->caContratante, '', ''); $nm14->completaLongitud();
        $r7 = new RefSegment(); $r7->generaSubTrama2('DD', $inLogAcreInsert->tiDoContratante); $r7->completaLongitud();
        $r74 = new Ref4Segment(); $r74->generaSubTrama2($inLogAcreInsert->idReContratante, $inLogAcreInsert->rucContratante); $r74->completaLongitud();
        $nm15 = new Nm1Segment(); $nm15->generaSubTrama4('C9', '1', 'MI', $inLogAcreInsert->coAfiliadoTitular); $nm15->completaLongitud();
        $nm16 = new Nm1Segment(); $nm16->generaSubTrama('IL', $inLogAcreInsert->caResponsableAut, $inLogAcreInsert->noPaResponsableAut, $inLogAcreInsert->noResponsableAut, '', '', $inLogAcreInsert->noMaResponsableAut); $nm16->completaLongitud();
        $r8 = new RefSegment(); $r8->generaSubTrama2('DD', $inLogAcreInsert->tiDoResponsableAut); $r8->completaLongitud();
        $r84 = new Ref4Segment(); $r84->generaSubTrama2('4A', $inLogAcreInsert->nuDoResponsableAut); $r84->completaLongitud();
        $r9 = new RefSegment(); $r9->generaSubTrama2('ZZ', $inLogAcreInsert->nuAutorizacion); $r9->completaLongitud();
        $dmg2 = new DmgSegment(); $dmg2->generaSubTrama('DT', $inLogAcreInsert->feHoAutorizacion, '', '', ''); $dmg2->completaLongitud();
        $eb2 = new EbSegment(); $eb2->generaSubTrama('1', '', '', '', $inLogAcreInsert->beMaxInicial, '', '', ''); $eb2->completaLongitud();
        $eb3 = new EbSegment(); $eb3->generaSubTrama('C', '', '', '', $inLogAcreInsert->coPagoFijo, '', '', ''); $eb3->completaLongitud();
        $eb4 = new EbSegment(); $eb4->generaSubTrama('1', '', '', '', '', $inLogAcreInsert->coPagoVariable, '', ''); $eb4->completaLongitud();
        $eb5 = new EbSegment(); $eb5->generaSubTrama($inLogAcreInsert->flagCartaGarantia, '', '', $inLogAcreInsert->deFlagCartaGarantia, '', '', '', ''); $eb5->completaLongitud();

        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm12->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm13->returnComoString('NM1*', '*', '~')
            . $r1->returnComoString('REF*', '*', '~')
            . $r2->returnComoString('REF*', '*', '*' . $r24->returnComoString('', ':', '~'))
            . $r3->returnComoString('REF*', '*', '*' . $r34->returnComoString('', ':', '~'))
            . $r4->returnComoString('REF*', '*', '~')
            . $r5->returnComoString('REF*', '*', '~')
            . $r6->returnComoString('REF*', '*', '~')
            . $dmg1->returnComoString('DMG*', '*', '~')
            . $dtp1->returnComoString('DTP*', '*', '~')
            . $eb1->returnComoString('EB*', '*', '~')
            . $nm14->returnComoString('NM1*', '*', '~')
            . $r7->returnComoString('REF*', '*', '*' . $r74->returnComoString('', ':', '~'))
            . $nm15->returnComoString('NM1*', '*', '~')
            . $nm16->returnComoString('NM1*', '*', '~')
            . $r8->returnComoString('REF*', '*', '*' . $r84->returnComoString('', ':', '~'))
            . $r9->returnComoString('REF*', '*', '~')
            . $dmg2->returnComoString('DMG*', '*', '~')
            . $eb2->returnComoString('EB*', '*', '~')
            . $eb3->returnComoString('EB*', '*', '~')
            . $eb4->returnComoString('EB*', '*', '~')
            . $eb5->returnComoString('EB*', '*', '~');

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $inLogAcreInsert->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($inLogAcreInsert->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($inLogAcreInsert->idCorrelativo); $iea->completaLongitud();

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
