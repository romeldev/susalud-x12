<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InRegAfi271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DmgSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\N2Segment;
use Romeldev\SusaludX12\Segments\N4Segment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class RegAfi271ToX12
{
    /**
     * @param InRegAfi271 $inRegafi
     * @return string
     */
    public static function traducirEstructura271(InRegAfi271 $inRegafi)
    {
        $inRegafi->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inRegafi->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment(); $isa->generaSubTrama($inRegafi->idRemitente, $inRegafi->idReceptor, $inRegafi->feTransaccion, $inRegafi->hoTransaccion, $inRegafi->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HB', $inRegafi->idRemitente, $inRegafi->idReceptor, $inRegafi->feTransaccion, $inRegafi->hoTransaccion, $inRegafi->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($inRegafi->idTransaccion, $inRegafi->nuControlST, ''); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0024', $inRegafi->tiFinalidad); $bht->completaLongitud();

        $hl = new HlSegment(); $hl->generaSubTrama3('1', '20', '1'); $hl->completaLongitud();
        $nm1 = new Nm1Segment(); $nm1->generaSubTrama('RGA', $inRegafi->caRemitente, $inRegafi->idRemitente, '', '', '', ''); $nm1->completaLongitud();
        $hl1 = new HlSegment(); $hl1->generaSubTrama('2', '1', '21', '1'); $hl1->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('PR', $inRegafi->caReceptor, 'PI', $inRegafi->nuRucReceptor); $nm12->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('3', '2', '22', '0'); $hl2->completaLongitud();

        $sDetalle = '';
        $detalles = $inRegafi->detalles;

        $buildDetalle = function ($det) {
            $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $det->caPaciente, $det->apPaternoPaciente, $det->noPaciente, 'MI', $det->coPaciente, $det->apMaternoPaciente); $nm13->completaLongitud();
            $r1 = new RefSegment(); $r1->generaSubTrama2('DD', $det->tiDocumentoPaciente); $r1->completaLongitud();
            $r14 = new Ref4Segment(); $r14->generaSubTrama2('4A', $det->nuDocumentoPaciente); $r14->completaLongitud();
            $r2 = new RefSegment(); $r2->generaSubTrama2('CT', $det->coContratoPaciente); $r2->completaLongitud();
            $r3 = new RefSegment(); $r3->generaSubTrama2('ACC', $det->esPaciente); $r3->completaLongitud();
            $r4 = new RefSegment(); $r4->generaSubTrama2('BLT', $det->tiRegimenPaciente); $r4->completaLongitud();
            $r5 = new RefSegment(); $r5->generaSubTrama2('6P', $det->tiPlanPaciente); $r5->completaLongitud();
            $r6 = new RefSegment(); $r6->generaSubTrama2('OZ', $det->coProductoPaciente); $r6->completaLongitud();
            $r7 = new RefSegment(); $r7->generaSubTrama2('18', $det->coPlanPaciente); $r7->completaLongitud();
            $r8 = new RefSegment(); $r8->generaSubTrama2('C6', $det->nuCarnetPaciente); $r8->completaLongitud();
            $r9 = new RefSegment(); $r9->generaSubTrama2('ACD', $det->coVinculoFamPaciente); $r9->completaLongitud();
            $n2 = new N2Segment(); $n2->generaSubTrama($det->apCasadaPaciente); $n2->completaLongitud();
            $n4 = new N4Segment(); $n4->generaSubTrama('W', $det->deUbigeoPaciente); $n4->completaLongitud();
            $dmg = new DmgSegment(); $dmg->generaSubTrama('D8', $det->feNacePaciente, $det->gePaciente, '', $det->coPaisPaciente); $dmg->completaLongitud();
            $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('442', 'D8', $det->feFallecidoPaciente); $dtp1->completaLongitud();
            $dtp2 = new DtpSegment(); $dtp2->generaSubTrama('276', 'D8', $det->feIniAfiliaPaciente); $dtp2->completaLongitud();
            $dtp3 = new DtpSegment(); $dtp3->generaSubTrama('093', 'D8', $det->feFinAfiliaPaciente); $dtp3->completaLongitud();
            $dtp4 = new DtpSegment(); $dtp4->generaSubTrama('349', 'D8', $det->feFinAtencionPaciente); $dtp4->completaLongitud();
            $nm22 = new Nm1Segment(); $nm22->generaSubTrama4('PR', $det->caAseguradora, 'PI', $det->coAseguradora); $nm22->completaLongitud();
            $nm14 = new Nm1Segment(); $nm14->generaSubTrama('C9', $det->caTitular, $det->apPaternoTitular, $det->noTitular, 'MI', $det->coTitular, $det->apMaternoTitular); $nm14->completaLongitud();
            $r10 = new RefSegment(); $r10->generaSubTrama2('DD', $det->tiDocumentoTitular); $r10->completaLongitud();
            $r104 = new Ref4Segment(); $r104->generaSubTrama2('A4', $det->nuDocumentoTitular); $r104->completaLongitud();
            $r11 = new RefSegment(); $r11->generaSubTrama2('EI', $det->coEstablecimientoTitular); $r11->completaLongitud();
            $dmg1 = new DmgSegment(); $dmg1->generaSubTrama('D8', $det->feFallecidoTitular, '', '', $det->coPaisTitular); $dmg1->completaLongitud();
            $nm15 = new Nm1Segment(); $nm15->generaSubTrama('C9', $det->caContratante, $det->apPaternoContratante, $det->noContratante, '', '', $det->apMaternoContratante); $nm15->completaLongitud();
            $r12 = new RefSegment(); $r12->generaSubTrama2('DD', $det->tiDocumentoContratante); $r12->completaLongitud();
            $r124 = new Ref4Segment(); $r124->generaSubTrama2($det->idReContratante, $det->nuDocumentoContratante); $r124->completaLongitud();
            $dmg2 = new DmgSegment(); $dmg2->generaSubTrama('', '', '', '', $det->coPaisContratante); $dmg2->completaLongitud();

            return $nm13->returnComoString('NM1*', '*', '~')
                . $r1->returnComoString('REF*', '*', '*' . $r14->returnComoString('', ':', '~'))
                . $r2->returnComoString('REF*', '*', '~')
                . $r3->returnComoString('REF*', '*', '~')
                . $r4->returnComoString('REF*', '*', '~')
                . $r5->returnComoString('REF*', '*', '~')
                . $r6->returnComoString('REF*', '*', '~')
                . $r7->returnComoString('REF*', '*', '~')
                . $r8->returnComoString('REF*', '*', '~')
                . $r9->returnComoString('REF*', '*', '~')
                . $n2->returnComoString('N2*', '*', '~')
                . $n4->returnComoString('N4*', '*', '~')
                . $dmg->returnComoString('DMG*', '*', '~')
                . $dtp1->returnComoString('DTP*', '*', '~')
                . $dtp2->returnComoString('DTP*', '*', '~')
                . $dtp3->returnComoString('DTP*', '*', '~')
                . $dtp4->returnComoString('DTP*', '*', '~')
                . $nm22->returnComoString('NM1*', '*', '~')
                . $nm14->returnComoString('NM1*', '*', '~')
                . $r10->returnComoString('REF*', '*', '*' . $r104->returnComoString('', ':', '~'))
                . $r11->returnComoString('REF*', '*', '~')
                . $dmg1->returnComoString('DMG*', '*', '~')
                . $nm15->returnComoString('NM1*', '*', '~')
                . $r12->returnComoString('REF*', '*', '*' . $r124->returnComoString('', ':', '~'))
                . $dmg2->returnComoString('DMG*', '*', '~');
        };

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $sDetalle .= $buildDetalle($det);
            }
        } else {
            $empty = new \stdClass();
            $empty->caPaciente = ''; $empty->apPaternoPaciente = ''; $empty->noPaciente = ''; $empty->coPaciente = ''; $empty->apMaternoPaciente = '';
            $empty->tiDocumentoPaciente = ''; $empty->nuDocumentoPaciente = ''; $empty->coContratoPaciente = ''; $empty->esPaciente = '';
            $empty->tiRegimenPaciente = ''; $empty->tiPlanPaciente = ''; $empty->coProductoPaciente = ''; $empty->coPlanPaciente = '';
            $empty->nuCarnetPaciente = ''; $empty->coVinculoFamPaciente = ''; $empty->apCasadaPaciente = ''; $empty->deUbigeoPaciente = '';
            $empty->feNacePaciente = ''; $empty->gePaciente = ''; $empty->coPaisPaciente = '';
            $empty->feFallecidoPaciente = ''; $empty->feIniAfiliaPaciente = ''; $empty->feFinAfiliaPaciente = ''; $empty->feFinAtencionPaciente = '';
            $empty->caAseguradora = ''; $empty->coAseguradora = '';
            $empty->caTitular = ''; $empty->apPaternoTitular = ''; $empty->noTitular = ''; $empty->coTitular = ''; $empty->apMaternoTitular = '';
            $empty->tiDocumentoTitular = ''; $empty->nuDocumentoTitular = ''; $empty->coEstablecimientoTitular = '';
            $empty->feFallecidoTitular = ''; $empty->coPaisTitular = '';
            $empty->caContratante = ''; $empty->apPaternoContratante = ''; $empty->noContratante = ''; $empty->apMaternoContratante = '';
            $empty->tiDocumentoContratante = ''; $empty->idReContratante = ''; $empty->nuDocumentoContratante = ''; $empty->coPaisContratante = '';
            $sDetalle .= $buildDetalle($empty);
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
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $inRegafi->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($inRegafi->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($inRegafi->idCorrelativo); $iea->completaLongitud();

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
