<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InConNom271;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\DmgSegment;
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

class ConNom271ToX12
{
    /**
     * Convierte un bean InConNom271 a una trama X12.
     *
     * @param InConNom271 $inConNom
     * @return string
     */
    public static function traducirEstructura271(InConNom271 $inConNom)
    {
        $inConNom->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inConNom->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        $isa = new IsaSegment();
        $isa->generaSubTrama($inConNom->idRemitente, $inConNom->idReceptor, $inConNom->feTransaccion, $inConNom->hoTransaccion, $inConNom->idCorrelativo);
        $isa->completaLongitud();

        $gs = new GsSegment();
        $gs->generaSubTrama('HB', $inConNom->idRemitente, $inConNom->idReceptor, $inConNom->feTransaccion, $inConNom->hoTransaccion, $inConNom->nuControl);
        $gs->completaLongitud();

        $st = new StSegment();
        $st->generaSubTrama($inConNom->idTransaccion, $inConNom->nuControlST, '');
        $st->completaLongitud();

        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $inConNom->tiFinalidad);
        $bht->completaLongitud();

        $hl = new HlSegment();
        $hl->generaSubTrama3('1', '20', '1');
        $hl->completaLongitud();

        $nm1 = new Nm1Segment();
        $nm1->generaSubTrama4('PR', $inConNom->caRemitente, 'PI', $inConNom->idRemitente);
        $nm1->completaLongitud();

        $hl1 = new HlSegment();
        $hl1->generaSubTrama('2', '1', '21', '1');
        $hl1->completaLongitud();

        $nm11 = new Nm1Segment();
        $nm11->generaSubTrama4('1P', $inConNom->caReceptor, 'FI', $inConNom->nuRucReceptor);
        $nm11->completaLongitud();

        $hl2 = new HlSegment();
        $hl2->generaSubTrama('3', '2', '22', '0');
        $hl2->completaLongitud();

        // Detail loop
        $sDetalle = '';
        $detalles = $inConNom->detalles;

        if (!empty($detalles)) {
            foreach ($detalles as $det) {
                $nm12 = new Nm1Segment();
                $nm12->generaSubTrama('IL', $det->caPaciente, $det->apPaternoPaciente, $det->noPaciente, 'MI', $det->coAfPaciente, $det->apMaternoPaciente);
                $nm12->completaLongitud();

                $r1 = new RefSegment();
                $r1->generaSubTrama2('ACC', $det->coEsPaciente);
                $r1->completaLongitud();

                $r2 = new RefSegment();
                $r2->generaSubTrama2('DD', $det->tiDoPaciente);
                $r2->completaLongitud();
                $r24 = new Ref4Segment();
                $r24->generaSubTrama2('4A', $det->nuDoPaciente);
                $r24->completaLongitud();

                $r3 = new RefSegment();
                $r3->generaSubTrama2('CT', $det->nuContratoPaciente);
                $r3->completaLongitud();

                $r4 = new RefSegment();
                $r4->generaSubTrama('PRT', $det->coProducto, $det->coDescripcion);
                $r4->completaLongitud();
                $r44 = new Ref4Segment();
                $r44->generaSubTrama2('ZZ', $det->nuSCTR);
                $r44->completaLongitud();

                $r5 = new RefSegment();
                $r5->generaSubTrama2('ZZ', $det->coParentesco);
                $r5->completaLongitud();

                $r6 = new RefSegment();
                $r6->generaSubTrama2('18', $det->nuPlan);
                $r6->completaLongitud();

                $dmg = new DmgSegment();
                $dmg->generaSubTrama('D8', $det->feNacimiento, $det->genero, $det->esMarital, '');
                $dmg->completaLongitud();

                $nm22 = new Nm1Segment();
                $nm22->generaSubTrama('P5', $det->tiCaContratante, $det->noPaContratante, $det->noContratante, '', '', $det->noMaContratante);
                $nm22->completaLongitud();

                $r7 = new RefSegment();
                $r7->generaSubTrama2('DD', $det->tiDoContratante);
                $r7->completaLongitud();
                $r74 = new Ref4Segment();
                $r74->generaSubTrama2('XX5', $det->coReContratante);
                $r74->completaLongitud();

                $sDetalle .= $nm12->returnComoString('NM1*', '*', '~')
                    . $r1->returnComoString('REF*', '*', '~')
                    . $r2->returnComoString('REF*', '*', '*' . $r24->returnComoString('', ':', '~'))
                    . $r3->returnComoString('REF*', '*', '~')
                    . $r4->returnComoString('REF*', '*', '*' . $r44->returnComoString('', ':', '~'))
                    . $r5->returnComoString('REF*', '*', '~')
                    . $r6->returnComoString('REF*', '*', '~')
                    . $dmg->returnComoString('DMG*', '*', '~')
                    . $nm22->returnComoString('NM1*', '*', '~')
                    . $r7->returnComoString('REF*', '*', '*' . $r74->returnComoString('', ':', '~'));
            }
        } else {
            $nm12 = new Nm1Segment();
            $nm12->generaSubTrama('IL', '', '', '', 'MI', '', '');
            $nm12->completaLongitud();
            $r1 = new RefSegment();
            $r1->generaSubTrama2('ACC', '');
            $r1->completaLongitud();
            $r2 = new RefSegment();
            $r2->generaSubTrama2('DD', '');
            $r2->completaLongitud();
            $r24 = new Ref4Segment();
            $r24->generaSubTrama2('4A', '');
            $r24->completaLongitud();
            $r3 = new RefSegment();
            $r3->generaSubTrama2('CT', '');
            $r3->completaLongitud();
            $r4 = new RefSegment();
            $r4->generaSubTrama('PRT', '', '');
            $r4->completaLongitud();
            $r44 = new Ref4Segment();
            $r44->generaSubTrama2('ZZ', '');
            $r44->completaLongitud();
            $r5 = new RefSegment();
            $r5->generaSubTrama2('ZZ', '');
            $r5->completaLongitud();
            $r6 = new RefSegment();
            $r6->generaSubTrama2('18', '');
            $r6->completaLongitud();
            $dmg = new DmgSegment();
            $dmg->generaSubTrama('D8', '', '', '', '');
            $dmg->completaLongitud();
            $nm22 = new Nm1Segment();
            $nm22->generaSubTrama('P5', '', '', '', '', '', '');
            $nm22->completaLongitud();
            $r7 = new RefSegment();
            $r7->generaSubTrama2('DD', '');
            $r7->completaLongitud();
            $r74 = new Ref4Segment();
            $r74->generaSubTrama2('XX5', '');
            $r74->completaLongitud();

            $sDetalle .= $nm12->returnComoString('NM1*', '*', '~')
                . $r1->returnComoString('REF*', '*', '~')
                . $r2->returnComoString('REF*', '*', '*' . $r24->returnComoString('', ':', '~'))
                . $r3->returnComoString('REF*', '*', '~')
                . $r4->returnComoString('REF*', '*', '*' . $r44->returnComoString('', ':', '~'))
                . $r5->returnComoString('REF*', '*', '~')
                . $r6->returnComoString('REF*', '*', '~')
                . $dmg->returnComoString('DMG*', '*', '~')
                . $nm22->returnComoString('NM1*', '*', '~')
                . $r7->returnComoString('REF*', '*', '*' . $r74->returnComoString('', ':', '~'));
        }

        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl->returnComoString('HL*', '*', '~')
            . $nm1->returnComoString('NM1*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm11->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $sDetalle;

        $canTxSE = self::cantidadSegementosTx($sReturn);

        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inConNom->nuControlST);
        $se->completaLongitud();
        $ge = new GeSegment();
        $ge->generaSubTrama($inConNom->nuControl);
        $ge->completaLongitud();
        $iea = new IeaSegment();
        $iea->generaSubTrama($inConNom->idCorrelativo);
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
