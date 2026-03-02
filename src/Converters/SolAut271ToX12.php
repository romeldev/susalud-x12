<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InSolAut271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DmgSegment;
use Romeldev\SusaludX12\Segments\DtpSegment;
use Romeldev\SusaludX12\Segments\EbSegment;
use Romeldev\SusaludX12\Segments\Eb13Segment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\HsdSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\MsgSegment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\Ref4Segment;
use Romeldev\SusaludX12\Segments\RefSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class SolAut271ToX12
{
    /**
     * @param InSolAut271 $inSolAut
     * @return string
     */
    public static function traducirEstructura271(InSolAut271 $inSolAut)
    {
        $inSolAut->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inSolAut->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $canDetalleTot = count($inSolAut->inSolAutProEsp271Detalles) . '#' . count($inSolAut->inSolAutTieEsp271Detalles) . '#' . count($inSolAut->inSolAutExeCar271Detalles) . '#' . count($inSolAut->inSolAut271Detalles);

        $isa = new IsaSegment(); $isa->generaSubTrama($inSolAut->idRemitente, $inSolAut->idReceptor, $inSolAut->feTransaccion, $inSolAut->hoTransaccion, $inSolAut->idCorrelativo); $isa->completaLongitud();
        $gs = new GsSegment(); $gs->generaSubTrama('HB', $inSolAut->idRemitente, $inSolAut->idReceptor, $inSolAut->feTransaccion, $inSolAut->hoTransaccion, $inSolAut->nuControl); $gs->completaLongitud();
        $st = new StSegment(); $st->generaSubTrama($inSolAut->idTransaccion, $inSolAut->nuControlST, $canDetalleTot); $st->completaLongitud();
        $bht = new BhtSegment(); $bht->generaSubTrama('0023', $inSolAut->tiFinalidad); $bht->completaLongitud();

        $hl = new HlSegment(); $hl->generaSubTrama3('1', '20', '1'); $hl->completaLongitud();
        $nm1 = new Nm1Segment(); $nm1->generaSubTrama4('PR', $inSolAut->caRemitente, 'PI', $inSolAut->nuRucRemitente); $nm1->completaLongitud();
        $r1 = new RefSegment(); $r1->generaSubTrama2('OL', $inSolAut->coAdmisionista); $r1->completaLongitud();
        $hl1 = new HlSegment(); $hl1->generaSubTrama('2', '1', '21', '1'); $hl1->completaLongitud();
        $nm12 = new Nm1Segment(); $nm12->generaSubTrama4('1P', $inSolAut->caReceptor, 'FI', $inSolAut->idReceptor); $nm12->completaLongitud();
        $hl2 = new HlSegment(); $hl2->generaSubTrama('3', '2', '22', '1'); $hl2->completaLongitud();
        $nm13 = new Nm1Segment(); $nm13->generaSubTrama('IL', $inSolAut->caPaciente, $inSolAut->apPaternoPaciente, $inSolAut->noPaciente, 'MI', $inSolAut->coAfPaciente, $inSolAut->apMaternoPaciente); $nm13->completaLongitud();

        $r2 = new RefSegment(); $r2->generaSubTrama2('ACC', $inSolAut->coEsPaciente); $r2->completaLongitud();
        $r3 = new RefSegment(); $r3->generaSubTrama2('DD', $inSolAut->tiDoPaciente); $r3->completaLongitud();
        $r3_4 = new Ref4Segment(); $r3_4->generaSubTrama2('4A', $inSolAut->nuDoPaciente); $r3_4->completaLongitud();
        $r4 = new RefSegment(); $r4->generaSubTrama2('EI', $inSolAut->nuIdenEmpleador); $r4->completaLongitud();
        $r5 = new RefSegment(); $r5->generaSubTrama2('CT', $inSolAut->nuContratoPaciente); $r5->completaLongitud();
        $r5_4 = new Ref4Segment(); $r5_4->generaSubTrama('AZ', $inSolAut->nuPoliza, 'ID', $inSolAut->nuCertificado, 'TY', $inSolAut->coTiPolizaAfiliacion); $r5_4->completaLongitud();
        $r6 = new RefSegment(); $r6->generaSubTrama('PRT', $inSolAut->coProducto, $inSolAut->deProducto); $r6->completaLongitud();
        $r7 = new RefSegment(); $r7->generaSubTrama2('18', $inSolAut->nuPlan); $r7->completaLongitud();
        $r7_4 = new Ref4Segment(); $r7_4->generaSubTrama('IMP', $inSolAut->tiPlanSalud, 'ZZ', $inSolAut->coMoneda, '', ''); $r7_4->completaLongitud();
        $r8 = new RefSegment(); $r8->generaSubTrama2('ZZ', $inSolAut->coParentesco); $r8->completaLongitud();
        $r9 = new RefSegment(); $r9->generaSubTrama2('ZZ', $inSolAut->soBeneficio); $r9->completaLongitud();
        $r9_4 = new Ref4Segment(); $r9_4->generaSubTrama('3B', $inSolAut->nuSoBeneficio, 'ZZ', $inSolAut->coEspecialidad, '', ''); $r9_4->completaLongitud();
        $dmg1 = new DmgSegment(); $dmg1->generaSubTrama('D8', $inSolAut->feNacimiento, $inSolAut->genero, $inSolAut->esMarital, ''); $dmg1->completaLongitud();
        $dtp1 = new DtpSegment(); $dtp1->generaSubTrama('356', 'D8', $inSolAut->feIniVigencia); $dtp1->completaLongitud();
        $dtp2 = new DtpSegment(); $dtp2->generaSubTrama('357', 'D8', $inSolAut->feFinVigencia); $dtp2->completaLongitud();
        $eb1 = new EbSegment(); $eb1->generaSubTrama($inSolAut->esCobertura, '', '', $inSolAut->nuDecAccidente, '', '', '', ''); $eb1->completaLongitud();
        $eb113 = new Eb13Segment(); $eb113->generaSubTrama('ZZ', $inSolAut->idInfAccidente, ''); $eb113->completaLongitud();
        $r10 = new RefSegment(); $r10->generaSubTrama2('3H', $inSolAut->deTiAccidente); $r10->completaLongitud();
        $dtp3 = new DtpSegment(); $dtp3->generaSubTrama('356', 'D8', $inSolAut->feAfiliacion); $dtp3->completaLongitud();
        $dtp4 = new DtpSegment(); $dtp4->generaSubTrama('357', 'D8', $inSolAut->feOcuAccidente); $dtp4->completaLongitud();
        $eb2 = new EbSegment(); $eb2->generaSubTrama($inSolAut->esCobertura, '', '', $inSolAut->nuAtencion, '', '', '', ''); $eb2->completaLongitud();
        $eb213 = new Eb13Segment(); $eb213->generaSubTrama('ZZ', $inSolAut->idDerFarmacia, ''); $eb213->completaLongitud();
        $r11 = new RefSegment(); $r11->generaSubTrama('PRT', $inSolAut->tiProducto, $inSolAut->deProductoDeFarmacia); $r11->completaLongitud();
        $dtp5 = new DtpSegment(); $dtp5->generaSubTrama('382', 'D8', $inSolAut->feAtencion); $dtp5->completaLongitud();
        $eb3 = new EbSegment(); $eb3->generaSubTrama($inSolAut->esCobertura, '', '', $inSolAut->nuCobertura, '', '', '', ''); $eb3->completaLongitud();
        $eb313 = new Eb13Segment(); $eb313->generaSubTrama('ZZ', $inSolAut->obsCobertura, ''); $eb313->completaLongitud();
        $msg1 = new MsgSegment(); $msg1->generaSubTrama1($inSolAut->msgObs); $msg1->completaLongitud();
        $msg2 = new MsgSegment(); $msg2->generaSubTrama1($inSolAut->msgConEspeciales); $msg2->completaLongitud();
        $nm14 = new Nm1Segment(); $nm14->generaSubTrama('P5', $inSolAut->caContratante, $inSolAut->noPaContratante, $inSolAut->noContratante, '', '', $inSolAut->noMaContratante); $nm14->completaLongitud();
        $r12 = new RefSegment(); $r12->generaSubTrama('DD', $inSolAut->tiDoContratante, ''); $r12->completaLongitud();
        $r12_4 = new Ref4Segment(); $r12_4->generaSubTrama2($inSolAut->idReContratante, $inSolAut->coReContratante); $r12_4->completaLongitud();
        $nm15 = new Nm1Segment(); $nm15->generaSubTrama('C9', $inSolAut->caTitular, $inSolAut->noPaTitular, $inSolAut->noTitular, 'MI', $inSolAut->coAfTitular, $inSolAut->noMaTitular); $nm15->completaLongitud();
        $r13 = new RefSegment(); $r13->generaSubTrama2('DD', $inSolAut->tiDoTitular); $r13->completaLongitud();
        $r13_4 = new Ref4Segment(); $r13_4->generaSubTrama2($inSolAut->idReTitular, $inSolAut->nuDoTitular); $r13_4->completaLongitud();
        $dtp6 = new DtpSegment(); $dtp6->generaSubTrama('382', 'D8', $inSolAut->feIncTitular); $dtp6->completaLongitud();
        $eb4 = new EbSegment(); $eb4->generaSubTrama($inSolAut->esCobertura, '', '', $inSolAut->nuCobPreExistencia, $inSolAut->beMaxInicial, '', '', $inSolAut->canServicio); $eb4->completaLongitud();
        $eb413 = new Eb13Segment(); $eb413->generaSubTrama('ZZ', $inSolAut->idDeProducto, ''); $eb413->completaLongitud();
        $r14 = new RefSegment(); $r14->generaSubTrama2('D7', $inSolAut->coTiCobertura); $r14->completaLongitud();
        $r14_4 = new Ref4Segment(); $r14_4->generaSubTrama2('ZZ', $inSolAut->coSubTiCobertura); $r14_4->completaLongitud();
        $msg3 = new MsgSegment(); $msg3->generaSubTrama1($inSolAut->msgObsPre); $msg3->completaLongitud();
        $msg4 = new MsgSegment(); $msg4->generaSubTrama1($inSolAut->msgConEspecialesPre); $msg4->completaLongitud();
        $eb5 = new EbSegment(); $eb5->generaSubTrama('C', '', '', $inSolAut->coTiMoneda, $inSolAut->coPagoFijo, '', $inSolAut->coCalServicio, $inSolAut->canCalServicio); $eb5->completaLongitud();
        $eb6 = new EbSegment(); $eb6->generaSubTrama($inSolAut->esCobertura, '', '', '', '', $inSolAut->coPagoVariable, '', ''); $eb6->completaLongitud();
        $eb7 = new EbSegment(); $eb7->generaSubTrama($inSolAut->flagCG, '', '', $inSolAut->deflagCG, '', '', '', ''); $eb7->completaLongitud();
        $dtp7 = new DtpSegment(); $dtp7->generaSubTrama('348', 'D8', $inSolAut->feFinCarencia); $dtp7->completaLongitud();
        $dtp8 = new DtpSegment(); $dtp8->generaSubTrama('338', 'D8', $inSolAut->feFinEspera); $dtp8->completaLongitud();

        // PE detail loop
        $sDetallePE = '';
        if (!empty($inSolAut->detallesPE)) {
            foreach ($inSolAut->detallesPE as $det) {
                $eb8 = new EbSegment(); $eb8->generaSubTrama('1', '', '', '', '', '', $det->coInProcedimiento, ''); $eb8->completaLongitud();
                $eb9 = new EbSegment(); $eb9->generaSubTrama('P', '', $det->coTiProConAmbulatoria, $det->nuPlanConAmbulatoria, $det->imDeducible, $det->poConAmbulatoria, '5U', $det->frConAmbulatoria); $eb9->completaLongitud();
                $eb9_13 = new Eb13Segment(); $eb9_13->generaSubTrama('ZZ', $det->geConAmbulatoria, ''); $eb9_13->completaLongitud();
                $hsd1 = new HsdSegment(); $hsd1->generaSubTrama('9S', $det->caConAmbulatoria); $hsd1->completaLongitud();
                $msg5 = new MsgSegment(); $msg5->generaSubTrama1($det->msgConAmbulatoria); $msg5->completaLongitud();
                $sDetallePE .= $eb8->returnComoString('EB*', '*', '~') . $eb9->returnComoString('EB*', '*', '*' . $eb9_13->returnComoString('', ':', '~')) . $hsd1->returnComoString('HSD*', '*', '~') . $msg5->returnComoString('MSG*', '*', '~');
            }
        } else {
            $eb8 = new EbSegment(); $eb8->generaSubTrama('1', '', '', '', '', '', '', ''); $eb8->completaLongitud();
            $eb9 = new EbSegment(); $eb9->generaSubTrama('P', '', '', '', '', '', '5U', ''); $eb9->completaLongitud();
            $eb9_13 = new Eb13Segment(); $eb9_13->generaSubTrama('ZZ', '', ''); $eb9_13->completaLongitud();
            $hsd1 = new HsdSegment(); $hsd1->generaSubTrama('9S', ''); $hsd1->completaLongitud();
            $msg5 = new MsgSegment(); $msg5->generaSubTrama1(''); $msg5->completaLongitud();
            $sDetallePE .= $eb8->returnComoString('EB*', '*', '~') . $eb9->returnComoString('EB*', '*', '*' . $eb9_13->returnComoString('', ':', '~')) . $hsd1->returnComoString('HSD*', '*', '~') . $msg5->returnComoString('MSG*', '*', '~');
        }

        // TE detail loop
        $sDetalleTE = '';
        if (!empty($inSolAut->detallesTE)) {
            foreach ($inSolAut->detallesTE as $det) {
                $eb10 = new EbSegment(); $eb10->generaSubTrama('W', '', $det->coTiEspera, '', '', '', '', ''); $eb10->completaLongitud();
                $eb10_13 = new Eb13Segment(); $eb10_13->generaSubTrama('ZZ', $det->idTiEspera, ''); $eb10_13->completaLongitud();
                $r15 = new RefSegment(); $r15->generaSubTrama2('82', $det->deTiEspera); $r15->completaLongitud();
                $dtp9 = new DtpSegment(); $dtp9->generaSubTrama('150', 'D8', $det->feFinVigenciaTiEspera); $dtp9->completaLongitud();
                $msg6 = new MsgSegment(); $msg6->generaSubTrama1($det->msgTiEspera); $msg6->completaLongitud();
                $sDetalleTE .= $eb10->returnComoString('EB*', '*', '*' . $eb10_13->returnComoString('', ':', '~')) . $r15->returnComoString('REF*', '*', '~') . $dtp9->returnComoString('DTP*', '*', '~') . $msg6->returnComoString('MSG*', '*', '~');
            }
        } else {
            $eb10 = new EbSegment(); $eb10->generaSubTrama('W', '', '', '', '', '', '', ''); $eb10->completaLongitud();
            $eb10_13 = new Eb13Segment(); $eb10_13->generaSubTrama('ZZ', '', ''); $eb10_13->completaLongitud();
            $r15 = new RefSegment(); $r15->generaSubTrama2('82', ''); $r15->completaLongitud();
            $dtp9 = new DtpSegment(); $dtp9->generaSubTrama('150', 'D8', ''); $dtp9->completaLongitud();
            $msg6 = new MsgSegment(); $msg6->generaSubTrama1(''); $msg6->completaLongitud();
            $sDetalleTE .= $eb10->returnComoString('EB*', '*', '*' . $eb10_13->returnComoString('', ':', '~')) . $r15->returnComoString('REF*', '*', '~') . $dtp9->returnComoString('DTP*', '*', '~') . $msg6->returnComoString('MSG*', '*', '~');
        }

        // EC detail loop
        $sDetalleEC = '';
        if (!empty($inSolAut->detallesEC)) {
            foreach ($inSolAut->detallesEC as $det) {
                $eb11 = new EbSegment(); $eb11->generaSubTrama('W', '', $det->coExCarencia, '', '', '', '', ''); $eb11->completaLongitud();
                $eb11_13 = new Eb13Segment(); $eb11_13->generaSubTrama('ZZ', $det->idExCarencia, ''); $eb11_13->completaLongitud();
                $r16 = new RefSegment(); $r16->generaSubTrama2('82', $det->deExCarencia); $r16->completaLongitud();
                $msg7 = new MsgSegment(); $msg7->generaSubTrama1($det->msgExCarencia); $msg7->completaLongitud();
                $sDetalleEC .= $eb11->returnComoString('EB*', '*', '*' . $eb11_13->returnComoString('', ':', '~')) . $r16->returnComoString('REF*', '*', '~') . $msg7->returnComoString('MSG*', '*', '~');
            }
        } else {
            $eb11 = new EbSegment(); $eb11->generaSubTrama('W', '', '', '', '', '', '', ''); $eb11->completaLongitud();
            $eb11_13 = new Eb13Segment(); $eb11_13->generaSubTrama('ZZ', '', ''); $eb11_13->completaLongitud();
            $r16 = new RefSegment(); $r16->generaSubTrama2('82', ''); $r16->completaLongitud();
            $msg7 = new MsgSegment(); $msg7->generaSubTrama1(''); $msg7->completaLongitud();
            $sDetalleEC .= $eb11->returnComoString('EB*', '*', '*' . $eb11_13->returnComoString('', ':', '~')) . $r16->returnComoString('REF*', '*', '~') . $msg7->returnComoString('MSG*', '*', '~');
        }

        // NM1 before main detail
        $nm16 = new Nm1Segment(); $nm16->generaSubTrama('IL', $inSolAut->caPaciente, $inSolAut->apPaternoPaciente, $inSolAut->noPaciente, 'MI', $inSolAut->coAfPaciente, $inSolAut->apMaternoPaciente); $nm16->completaLongitud();

        // Main detail loop (restricciones)
        $sDetalle = '';
        if (!empty($inSolAut->detalles)) {
            foreach ($inSolAut->detalles as $det) {
                $eb12 = new EbSegment(); $eb12->generaSubTrama('W', '', $det->cIE10Restricciones, '', '', '', '', ''); $eb12->completaLongitud();
                $eb12_13 = new Eb13Segment(); $eb12_13->generaSubTrama('ZZ', $det->idRestricciones, ''); $eb12_13->completaLongitud();
                $r17 = new RefSegment(); $r17->generaSubTrama2('82', $det->obsRestricciones); $r17->completaLongitud();
                $r18 = new RefSegment(); $r18->generaSubTrama2('82', $det->deRestricciones); $r18->completaLongitud();
                $msg8 = new MsgSegment(); $msg8->generaSubTrama1($det->msgRestricciones); $msg8->completaLongitud();
                $eb13x = new EbSegment(); $eb13x->generaSubTrama($inSolAut->esCobertura, '', '', '', '', $det->monTopeRestricciones, '', ''); $eb13x->completaLongitud();
                $dtp10 = new DtpSegment(); $dtp10->generaSubTrama('150', 'D8', $det->feFinEsperaRestricciones); $dtp10->completaLongitud();
                $sDetalle .= $eb12->returnComoString('EB*', '*', '*' . $eb12_13->returnComoString('', ':', '~')) . $r17->returnComoString('REF*', '*', '~') . $r18->returnComoString('REF*', '*', '~') . $msg8->returnComoString('MSG*', '*', '~') . $eb13x->returnComoString('EB*', '*', '~') . $dtp10->returnComoString('DTP*', '*', '~');
            }
        } else {
            $eb12 = new EbSegment(); $eb12->generaSubTrama('W', '', '', '', '', '', '', ''); $eb12->completaLongitud();
            $eb12_13 = new Eb13Segment(); $eb12_13->generaSubTrama('ZZ', '', ''); $eb12_13->completaLongitud();
            $r17 = new RefSegment(); $r17->generaSubTrama2('82', ''); $r17->completaLongitud();
            $r18 = new RefSegment(); $r18->generaSubTrama2('82', ''); $r18->completaLongitud();
            $msg8 = new MsgSegment(); $msg8->generaSubTrama1(''); $msg8->completaLongitud();
            $eb13x = new EbSegment(); $eb13x->generaSubTrama('', '', '', '', '', '', '', ''); $eb13x->completaLongitud();
            $dtp10 = new DtpSegment(); $dtp10->generaSubTrama('150', 'D8', ''); $dtp10->completaLongitud();
            $sDetalle .= $eb12->returnComoString('EB*', '*', '*' . $eb12_13->returnComoString('', ':', '~')) . $r17->returnComoString('REF*', '*', '~') . $r18->returnComoString('REF*', '*', '~') . $msg8->returnComoString('MSG*', '*', '~') . $eb13x->returnComoString('EB*', '*', '~') . $dtp10->returnComoString('DTP*', '*', '~');
        }

        // HL4
        $hl4 = new HlSegment(); $hl4->generaSubTrama('4', '3', '23', '0'); $hl4->completaLongitud();
        $nm17 = new Nm1Segment(); $nm17->generaSubTrama('IL', $inSolAut->caRegafi, $inSolAut->noPaRegafi, $inSolAut->noRegafi, 'MI', $inSolAut->coAfRegafi, $inSolAut->noMaRegafi); $nm17->completaLongitud();
        $r19 = new RefSegment(); $r19->generaSubTrama2('DD', $inSolAut->tiDoRegafi); $r19->completaLongitud();
        $r19_4 = new Ref4Segment(); $r19_4->generaSubTrama2($inSolAut->idReRegafi, $inSolAut->nuDoRegafi); $r19_4->completaLongitud();
        $dmg2 = new DmgSegment(); $dmg2->generaSubTrama('D8', $inSolAut->feNaRegafi, $inSolAut->geRegafi, '', $inSolAut->coPaisRegafi); $dmg2->completaLongitud();

        $sReturn = $isa->returnComoString('ISA*', '*', '~') . $gs->returnComoString('GS*', '*', '~') . $st->returnComoString('ST*', '*', '~') . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~') . $nm1->returnComoString('NM1*', '*', '~') . $r1->returnComoString('REF*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~') . $nm12->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~') . $nm13->returnComoString('NM1*', '*', '~')
            . $r2->returnComoString('REF*', '*', '~') . $r3->returnComoString('REF*', '*', '*' . $r3_4->returnComoString('', ':', '~'))
            . $r4->returnComoString('REF*', '*', '~') . $r5->returnComoString('REF*', '*', '*' . $r5_4->returnComoString('', ':', '~'))
            . $r6->returnComoString('REF*', '*', '~') . $r7->returnComoString('REF*', '*', '*' . $r7_4->returnComoString('', ':', '~'))
            . $r8->returnComoString('REF*', '*', '~') . $r9->returnComoString('REF*', '*', '*' . $r9_4->returnComoString('', ':', '~'))
            . $dmg1->returnComoString('DMG*', '*', '~') . $dtp1->returnComoString('DTP*', '*', '~') . $dtp2->returnComoString('DTP*', '*', '~')
            . $eb1->returnComoString('EB*', '*', '*' . $eb113->returnComoString('', ':', '~')) . $r10->returnComoString('REF*', '*', '~')
            . $dtp3->returnComoString('DTP*', '*', '~') . $dtp4->returnComoString('DTP*', '*', '~')
            . $eb2->returnComoString('EB*', '*', '*' . $eb213->returnComoString('', ':', '~')) . $r11->returnComoString('REF*', '*', '~')
            . $dtp5->returnComoString('DTP*', '*', '~')
            . $eb3->returnComoString('EB*', '*', '*' . $eb313->returnComoString('', ':', '~'))
            . $msg1->returnComoString('MSG*', '*', '~') . $msg2->returnComoString('MSG*', '*', '~')
            . $nm14->returnComoString('NM1*', '*', '~') . $r12->returnComoString('REF*', '*', '*' . $r12_4->returnComoString('', ':', '~'))
            . $nm15->returnComoString('NM1*', '*', '~') . $r13->returnComoString('REF*', '*', '*' . $r13_4->returnComoString('', ':', '~'))
            . $dtp6->returnComoString('DTP*', '*', '~')
            . $eb4->returnComoString('EB*', '*', '*' . $eb413->returnComoString('', ':', '~'))
            . $r14->returnComoString('REF*', '*', '*' . $r14_4->returnComoString('', ':', '~'))
            . $msg3->returnComoString('MSG*', '*', '~') . $msg4->returnComoString('MSG*', '*', '~')
            . $eb5->returnComoString('EB*', '*', '~') . $eb6->returnComoString('EB*', '*', '~') . $eb7->returnComoString('EB*', '*', '~')
            . $dtp7->returnComoString('DTP*', '*', '~') . $dtp8->returnComoString('DTP*', '*', '~')
            . $sDetallePE . $sDetalleTE . $sDetalleEC
            . $nm16->returnComoString('NM1*', '*', '~') . $sDetalle
            . $hl4->returnComoString('HL*', '*', '~') . $nm17->returnComoString('NM1*', '*', '~')
            . $r19->returnComoString('REF*', '*', '*' . $r19_4->returnComoString('', ':', '~'))
            . $dmg2->returnComoString('DMG*', '*', '~');

        $canTxSE = self::cantidadSegementosTx($sReturn);
        $se = new SeSegment(); $se->generaSubTrama($canTxSE, $inSolAut->nuControlST); $se->completaLongitud();
        $ge = new GeSegment(); $ge->generaSubTrama($inSolAut->nuControl); $ge->completaLongitud();
        $iea = new IeaSegment(); $iea->generaSubTrama($inSolAut->idCorrelativo); $iea->completaLongitud();

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
