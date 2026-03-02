<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConCod271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DmgSegment;
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
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class ConCod271ToX12
{
    /**
     * @param InConCod271 $inConCod
     * @return string
     */
    public static function traducirEstructura271(InConCod271 $inConCod)
    {
        $inConCod->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConCod->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment(); $isa->generaSubTrama($inConCod->idRemitente, $inConCod->idReceptor, $inConCod->feTransaccion, $inConCod->hoTransaccion, $inConCod->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HB', $inConCod->idRemitente, $inConCod->idReceptor, $inConCod->feTransaccion, $inConCod->hoTransaccion, $inConCod->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($inConCod->idTransaccion, $inConCod->nuControlST, ''); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0022', $inConCod->tiFinalidad); $bht->completaLongitud();

        $hl = new HlSegment(); $hl->generaSubTrama3('1', '20', '1'); $hl->completaLongitud();
        $nm1 = new Nm1Segment(); $nm1->generaSubTrama4('PR', $inConCod->caRemitente, 'PI', $inConCod->idRemitente); $nm1->completaLongitud();
        $r1 = new RefSegment(); $r1->generaSubTrama2('OL', $inConCod->userRemitente); $r1->completaLongitud();
        $r1_4 = new Ref4Segment(); $r1_4->generaSubTrama2('Y8', $inConCod->passRemitente); $r1_4->completaLongitud();
        $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('163', 'D8', $inConCod->feUpFoto); $dtp1->completaLongitud();

        $hl1 = new HlSegment(); $hl1->generaSubTrama('2', '1', '21', '1'); $hl1->completaLongitud();
        $nm11 = new Nm1Segment(); $nm11->generaSubTrama4('1P', $inConCod->caReceptor, 'FI', $inConCod->nuRucReceptor); $nm11->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('3', '2', '22', '0'); $hl2->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama('3', $inConCod->caPaciente, $inConCod->apPaternoPaciente, $inConCod->noPaciente, 'MI', $inConCod->coAfPaciente, $inConCod->apMaternoPaciente); $nm12->completaLongitud();

        $r2 = new RefSegment(); $r2->generaSubTrama2('ACC', $inConCod->coEsPaciente); $r2->completaLongitud();
        $r3 = new RefSegment(); $r3->generaSubTrama2('DD', $inConCod->tiDoPaciente); $r3->completaLongitud();
        $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('4A', $inConCod->nuDoPaciente); $r3_4->completaLongitud();
        $r4 = new RefSegment(); $r4->generaSubTrama2('EI', $inConCod->nuIdenPaciente); $r4->completaLongitud();
        $r5 = new RefSegment(); $r5->generaSubTrama2('CT', $inConCod->nuContratoPaciente); $r5->completaLongitud();
        $r5_4 = new Ref4Segment(); $r5_4->generaSubTrama('AZ', $inConCod->nuPoliza, 'ID', $inConCod->nuCertificado, 'TY', $inConCod->coTiPoliza); $r5_4->completaLongitud();
        $r6 = new RefSegment(); $r6->generaSubTrama('PRT', $inConCod->coProducto, $inConCod->deProducto); $r6->completaLongitud();
        $r7 = new RefSegment(); $r7->generaSubTrama2('18', $inConCod->nuPlan); $r7->completaLongitud();
        $r7_4 = new Ref4Segment(); $r7_4->generaSubTrama('IMP', $inConCod->tiPlanSalud, 'ZZ', $inConCod->coMoneda, '', ''); $r7_4->completaLongitud();
        $r8 = new RefSegment(); $r8->generaSubTrama2('ZZ', $inConCod->coParentesco); $r8->completaLongitud();
        $r9 = new RefSegment(); $r9->generaSubTrama2('ZZ', $inConCod->soBeneficio); $r9->completaLongitud();
        $r9_4 = new Ref4Segment(); $r9_4->generaSubTrama2('3B', $inConCod->nuSoBeneficio); $r9_4->completaLongitud();
        $dmg = new DmgSegment(); $dmg->generaSubTrama('D8', $inConCod->feNacimiento, $inConCod->genero, $inConCod->esMarital, ''); $dmg->completaLongitud();
        $dtp2 = new DtpSegment(); $dtp2->generaSubTrama('356', 'D8', $inConCod->feIniVigencia); $dtp2->completaLongitud();
        $dtp3 = new DtpSegment(); $dtp3->generaSubTrama('357', 'D8', $inConCod->feFinVigencia); $dtp3->completaLongitud();
        $nm2 = new Nm1Segment(); $nm2->generaSubTrama('P5', $inConCod->tiCaContratante, $inConCod->noPaContratante, $inConCod->noContratante, '', '', $inConCod->noMaContratante); $nm2->completaLongitud();
        $r10 = new RefSegment(); $r10->generaSubTrama2('DD', $inConCod->tiDoContratante); $r10->completaLongitud();
        $r10_4 = new Ref4Segment(); $r10_4->generaSubTrama2('XX5', $inConCod->coReContratante); $r10_4->completaLongitud();
        $nm3 = new Nm1Segment(); $nm3->generaSubTrama('C9', $inConCod->caTitular, $inConCod->noPaTitular, $inConCod->noTitular, 'MI', $inConCod->coAfTitular, $inConCod->noMaTitular); $nm3->completaLongitud();
        $r11 = new RefSegment(); $r11->generaSubTrama2('DD', $inConCod->tiDoTitular); $r11->completaLongitud();
        $r11_4 = new Ref4Segment(); $r11_4->generaSubTrama2('4A', $inConCod->nuDoTitular); $r11_4->completaLongitud();
        $dtp4 = new DtpSegment(); $dtp4->generaSubTrama('382', 'D8', $inConCod->feInsTitular); $dtp4->completaLongitud();

        // Detail loop
        $sDetalle = '';
        $detalles = $inConCod->detalles;

        $buildDetalle = function ($det, $hasData) {
            $eb2 = new EbSegment();
            $eb2->generaSubTrama($hasData ? $det->infBeneficio : '', '', '', $hasData ? $det->nuCobertura : '', $hasData ? $det->beMaxInicial : '', $hasData ? $det->moCobertura : '', $hasData ? $det->coInRestriccion : '', $hasData ? $det->canServicio : '');
            $eb2->completaLongitud();
            $eb2_13 = new Eb13Segment(); $eb2_13->generaSubTrama('ZZ', $hasData ? $det->idProducto : '', ''); $eb2_13->completaLongitud();
            $r12 = new RefSegment(); $r12->generaSubTrama2('D7', $hasData ? $det->coTiCobertura : ''); $r12->completaLongitud();
            $r12_4 = new Ref4Segment(); $r12_4->generaSubTrama2('ZZ', $hasData ? $det->coSubTiCobertura : ''); $r12_4->completaLongitud();
            $msg1 = new MsgSegment(); $msg1->generaSubTrama1($hasData ? $det->msgObs : ''); $msg1->completaLongitud();
            $msg2 = new MsgSegment(); $msg2->generaSubTrama1($hasData ? $det->msgConEspeciales : ''); $msg2->completaLongitud();
            $eb3 = new EbSegment(); $eb3->generaSubTrama('C', '', '', $hasData ? $det->coTiMoneda : '', $hasData ? $det->coPagoFijo : '', '', $hasData ? $det->coCalServicio : '', $hasData ? $det->canCalServicio : ''); $eb3->completaLongitud();
            $eb4 = new EbSegment(); $eb4->generaSubTrama('1', '', '', '', '', $hasData ? $det->coPagoVariable : '', '', ''); $eb4->completaLongitud();
            $eb5 = new EbSegment(); $eb5->generaSubTrama($hasData ? $det->flagCaGarantia : '', '', '', $hasData ? $det->deflagCaGarantia : '', '', '', '', ''); $eb5->completaLongitud();
            $dtp5 = new DtpSegment(); $dtp5->generaSubTrama('327', 'D8', $hasData ? $det->feFinCarencia : ''); $dtp5->completaLongitud();
            $dtp6 = new DtpSegment(); $dtp6->generaSubTrama('338', 'D8', $hasData ? $det->feFinEspera : ''); $dtp6->completaLongitud();

            return $eb2->returnComoString('EB*', '*', '*' . $eb2_13->returnComoString('', ':', '~'))
                . $r12->returnComoString('REF*', '*', '*' . $r12_4->returnComoString('', ':', '~'))
                . $msg1->returnComoString('MSG*', '*', '~')
                . $msg2->returnComoString('MSG*', '*', '~')
                . $eb3->returnComoString('EB*', '*', '~')
                . $eb4->returnComoString('EB*', '*', '~')
                . $eb5->returnComoString('EB*', '*', '~')
                . $dtp5->returnComoString('DTP*', '*', '~')
                . $dtp6->returnComoString('DTP*', '*', '~');
        };

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $sDetalle .= $buildDetalle($det, true);
            }
        } else {
            $sDetalle .= $buildDetalle(null, false);
        }

        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $r1->returnComoString('REF*', '*', '*' . $r1_4->returnComoString('', ':', '~'))
            . $dtp1->returnComoString('DTP*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm11->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm12->returnComoString('NM1*', '*', '~')
            . $r2->returnComoString('REF*', '*', '~')
            . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
            . $r4->returnComoString('REF*', '*', '~')
            . $r5->returnComoString('REF*', '*', '*' . $r5_4->returnComoString('', ':', '~'))
            . $r6->returnComoString('REF*', '*', '~')
            . $r7->returnComoString('REF*', '*', '*' . $r7_4->returnComoString('', ':', '~'))
            . $r8->returnComoString('REF*', '*', '~')
            . $r9->returnComoString('REF*', '*', '*' . $r9_4->returnComoString('', ':', '~'))
            . $dmg->returnComoString('DMG*', '*', '~')
            . $dtp2->returnComoString('DTP*', '*', '~')
            . $dtp3->returnComoString('DTP*', '*', '~')
            . $nm2->returnComoString('NM1*', '*', '~')
            . $r10->returnComoString('REF*', '*', '*' . $r10_4->returnComoString('', ':', '~'))
            . $nm3->returnComoString('NM1*', '*', '~')
            . $r11->returnComoString('REF*', '*', '*' . $r11_4->returnComoString('', ':', '~'))
            . $dtp4->returnComoString('DTP*', '*', '~')
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $inConCod->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($inConCod->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($inConCod->idCorrelativo); $iea->completaLongitud();

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
