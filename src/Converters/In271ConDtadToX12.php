<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\In271ConDtad;
use Romeldev\SusaludX12\Segments\BhtSegment;
use Romeldev\SusaludX12\Segments\GeSegment;
use Romeldev\SusaludX12\Segments\GsSegment;
use Romeldev\SusaludX12\Segments\HlSegment;
use Romeldev\SusaludX12\Segments\IeaSegment;
use Romeldev\SusaludX12\Segments\IsaSegment;
use Romeldev\SusaludX12\Segments\N3Segment;
use Romeldev\SusaludX12\Segments\N4Segment;
use Romeldev\SusaludX12\Segments\Nm1Segment;
use Romeldev\SusaludX12\Segments\PerSegment;
use Romeldev\SusaludX12\Segments\SeSegment;
use Romeldev\SusaludX12\Segments\StSegment;
use Romeldev\SusaludX12\Support\TransaccionUtil;

class In271ConDtadToX12
{
    /**
     * Convierte un bean In271ConDtad a una trama X12.
     *
     * @param In271ConDtad $in271ConDtad
     * @return string
     */
    public static function traducirEstructura278ConDtad(In271ConDtad $in271ConDtad)
    {
        $in271ConDtad->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $in271ConDtad->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $in271ConDtad->idRemitente,
            $in271ConDtad->idReceptor,
            $in271ConDtad->feTransaccion,
            $in271ConDtad->hoTransaccion,
            $in271ConDtad->idCorrelativo
        );
        $isa->completaLongitud();

        // GS
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HB',
            $in271ConDtad->idRemitente,
            $in271ConDtad->idReceptor,
            $in271ConDtad->feTransaccion,
            $in271ConDtad->hoTransaccion,
            $in271ConDtad->nuControl
        );
        $gs->completaLongitud();

        // ST
        $st = new StSegment();
        $st->generaSubTrama(
            $in271ConDtad->idTransaccion,
            $in271ConDtad->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $in271ConDtad->tiFinalidad);
        $bht->completaLongitud();

        // HL1
        $hl1 = new HlSegment();
        $hl1->generaSubTrama3('1', '20', '1');
        $hl1->completaLongitud();

        // NM1 - PR
        $nm1Pr = new Nm1Segment();
        $nm1Pr->generaSubTrama4('PR', $in271ConDtad->caRemitente, 'PI', $in271ConDtad->idRemitente);
        $nm1Pr->completaLongitud();

        // HL2
        $hl2 = new HlSegment();
        $hl2->generaSubTrama('2', '1', '21', '1');
        $hl2->completaLongitud();

        // NM1 - 1P
        $nm1_1P = new Nm1Segment();
        $nm1_1P->generaSubTrama4('1P', $in271ConDtad->caReceptor, 'SV', $in271ConDtad->nuRucReceptor);
        $nm1_1P->completaLongitud();

        // HL3
        $hl3 = new HlSegment();
        $hl3->generaSubTrama('3', '2', '22', '1');
        $hl3->completaLongitud();

        // NM1 - IL
        $nm1Il = new Nm1Segment();
        $nm1Il->generaSubTrama(
            'IL',
            $in271ConDtad->caPaciente,
            $in271ConDtad->apPaternoPaciente,
            $in271ConDtad->noPaciente,
            'MI',
            $in271ConDtad->coAfPaciente,
            $in271ConDtad->apMaternoPaciente
        );
        $nm1Il->completaLongitud();

        // N3
        $n3 = new N3Segment();
        $n3->generaSubTrama($in271ConDtad->deDirPaciente1, $in271ConDtad->deDirPaciente2);
        $n3->completaLongitud();

        // N4
        $n4 = new N4Segment();
        $n4->generaSubTrama('W', $in271ConDtad->coUbigeoPaciente);
        $n4->completaLongitud();

        // PER1
        $per1 = new PerSegment();
        $per1->generaSubTrama2('IC', $in271ConDtad->noContacto);
        $per1->completaLongitud();

        // PER2
        $per2 = new PerSegment();
        $per2->generaSubTrama('IP', 'EM', $in271ConDtad->emContacto, 'TE', $in271ConDtad->nuTeContacto);
        $per2->completaLongitud();

        // NM1 - CA
        $nm1Ca = new Nm1Segment();
        $nm1Ca->generaSubTrama(
            'CA',
            $in271ConDtad->tiCaCalificador,
            $in271ConDtad->apPaNoEmCalificador,
            $in271ConDtad->noEmCalificador,
            '',
            '',
            $in271ConDtad->apMaCalificador
        );
        $nm1Ca->completaLongitud();

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
            . $n3->returnComoString('N3*', '*', '~')
            . $n4->returnComoString('N4*', '*', '~')
            . $per1->returnComoString('PER*', '*', '~')
            . $per2->returnComoString('PER*', '*', '~')
            . $nm1Ca->returnComoString('NM1*', '*', '~');

        // Count segments
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $in271ConDtad->nuControlST);
        $se->completaLongitud();

        // GE
        $ge = new GeSegment();
        $ge->generaSubTrama($in271ConDtad->nuControl);
        $ge->completaLongitud();

        // IEA
        $iea = new IeaSegment();
        $iea->generaSubTrama($in271ConDtad->idCorrelativo);
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
