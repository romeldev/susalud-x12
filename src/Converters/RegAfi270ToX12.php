<?php

namespace Romeldev\SusaludX12\Converters;

use Romeldev\SusaludX12\Beans\InRegAfi270;
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

class RegAfi270ToX12
{
    /**
     * Convierte un bean InRegAfi270 a una trama X12.
     *
     * @param InRegAfi270 $inRegafi
     * @return string
     */
    public static function traducirEstructura270(InRegAfi270 $inRegafi)
    {
        $inRegafi->nuControl = TransaccionUtil::generarAleatorio(1000000000, 8);
        $inRegafi->nuControlST = TransaccionUtil::generarAleatorioST(1000000000, 8);

        // ISA - Interchange Service Agreement
        $isa = new IsaSegment();
        $isa->generaSubTrama(
            $inRegafi->idRemitente,
            $inRegafi->idReceptor,
            $inRegafi->feTransaccion,
            $inRegafi->hoTransaccion,
            $inRegafi->idCorrelativo
        );
        $isa->completaLongitud();

        // GS - Functional Group
        $gs = new GsSegment();
        $gs->generaSubTrama(
            'HS',
            $inRegafi->idRemitente,
            $inRegafi->idReceptor,
            $inRegafi->feTransaccion,
            $inRegafi->hoTransaccion,
            $inRegafi->nuControl
        );
        $gs->completaLongitud();

        // ST - Transaction Set Header
        $st = new StSegment();
        $st->generaSubTrama(
            $inRegafi->idTransaccion,
            $inRegafi->nuControlST,
            ''
        );
        $st->completaLongitud();

        // BHT - Beginning of Hierarchical Transaction
        $bht = new BhtSegment();
        $bht->generaSubTrama('0022', $inRegafi->tiFinalidad);
        $bht->completaLongitud();

        // HL1 - Information Source (level 20)
        $hl1 = new HlSegment();
        $hl1->generaSubTrama3('1', '20', '1');
        $hl1->completaLongitud();

        // NM1 - Payer (PR)
        $nm1Pr = new Nm1Segment();
        $nm1Pr->generaSubTrama4('PR', $inRegafi->caRemitente, 'PI', $inRegafi->nuRucRemitente);
        $nm1Pr->completaLongitud();

        // HL2 - Information Receiver (level 21)
        $hl2 = new HlSegment();
        $hl2->generaSubTrama('2', '1', '21', '1');
        $hl2->completaLongitud();

        // NM1 - Receiver (RGA)
        $nm1Rga = new Nm1Segment();
        $nm1Rga->generaSubTrama('RGA', $inRegafi->caReceptor, $inRegafi->idReceptor, '', '', '', '');
        $nm1Rga->completaLongitud();

        // HL3 - Subscriber (level 22)
        $hl3 = new HlSegment();
        $hl3->generaSubTrama('3', '2', '22', '0');
        $hl3->completaLongitud();

        // NM1 - Subscriber (IL)
        $nm1Il = new Nm1Segment();
        $nm1Il->generaSubTrama(
            'IL',
            $inRegafi->caPaciente,
            $inRegafi->apPaternoPaciente,
            $inRegafi->noPaciente,
            '',
            '',
            $inRegafi->apMaternoPaciente
        );
        $nm1Il->completaLongitud();

        // REF - Reference (Document Type)
        $ref = new RefSegment();
        $ref->generaSubTrama2('DD', $inRegafi->tiDocumento);
        $ref->completaLongitud();

        // REF04 - Reference component (Document Number)
        $ref4 = new Ref4Segment();
        $ref4->generaSubTrama2('4A', $inRegafi->nuDocumento);
        $ref4->completaLongitud();

        // Build the X12 string
        $sReturn = $isa->returnComoString('ISA*', '*', '~')
            . $gs->returnComoString('GS*', '*', '~')
            . $st->returnComoString('ST*', '*', '~')
            . $bht->returnComoString('BHT*', '*', '~')
            . $hl1->returnComoString('HL*', '*', '~')
            . $nm1Pr->returnComoString('NM1*', '*', '~')
            . $hl2->returnComoString('HL*', '*', '~')
            . $nm1Rga->returnComoString('NM1*', '*', '~')
            . $hl3->returnComoString('HL*', '*', '~')
            . $nm1Il->returnComoString('NM1*', '*', '~')
            . $ref->returnComoString('REF*', '*', '*' . $ref4->returnComoString('', ':', '~'));

        // Count segments for SE
        $canTxSE = self::cantidadSegementosTx($sReturn);

        // SE - Transaction Set Trailer
        $se = new SeSegment();
        $se->generaSubTrama($canTxSE, $inRegafi->nuControlST);
        $se->completaLongitud();

        // GE - Functional Group Trailer
        $ge = new GeSegment();
        $ge->generaSubTrama($inRegafi->nuControl);
        $ge->completaLongitud();

        // IEA - Interchange Control Trailer
        $iea = new IeaSegment();
        $iea->generaSubTrama($inRegafi->idCorrelativo);
        $iea->completaLongitud();

        return $sReturn
            . $se->returnComoString('SE*', '*', '~')
            . $ge->returnComoString('GE*', '*', '~')
            . $iea->returnComoString('IEA*', '*', '~');
    }

    /**
     * Cuenta la cantidad de segmentos en la trama.
     *
     * @param string $sReturn
     * @return string
     */
    private static function cantidadSegementosTx($sReturn)
    {
        $arrayCadena = explode('~', $sReturn);
        // Excluir el último elemento vacío si la cadena termina en ~
        $count = count(array_filter($arrayCadena, function ($s) {
            return $s !== '';
        }));
        return (string) $count;
    }
}
