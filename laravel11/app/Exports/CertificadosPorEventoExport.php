<?php

namespace App\Exports;

use App\Models\Certificado;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;

class CertificadosPorEventoExport implements
    FromCollection,
    WithHeadings,
    WithTitle,
    ShouldAutoSize
{
    protected $idevento;

    public function __construct($idevento)
    {
        $this->idevento = $idevento;
    }

    public function collection()
    {
        return Certificado::leftJoin('certinormal', 'certificado.idCertif', '=', 'certinormal.idCertif')
            ->leftJoin('certiasiste', 'certificado.idCertif', '=', 'certiasiste.idCertif')
            ->leftJoin('asistencia', 'certiasiste.idasistnc', '=', 'asistencia.idasistnc')
            ->leftJoin('inscripcion', 'asistencia.idincrip', '=', 'inscripcion.idincrip')
            ->leftJoin('personas as p_normal', 'certinormal.idpersona', '=', 'p_normal.idpersona')
            ->leftJoin('personas as p_asiste', 'inscripcion.idpersona', '=', 'p_asiste.idpersona')
            ->leftJoin('estadocerti', 'certificado.idestcer', '=', 'estadocerti.idestcer')
            ->leftJoin('cargo', 'certificado.idcargo', '=', 'cargo.idcargo')
            ->leftJoin('tipocertificado', 'cargo.idtipcert', '=', 'tipocertificado.idtipcert')
            ->where('certificado.idevento', $this->idevento)
            ->select(
                DB::raw('ROW_NUMBER() OVER (ORDER BY COALESCE(p_normal.apell, p_asiste.apell, \'Sin Apellido\')) AS numero'),
                DB::raw('COALESCE(p_normal.dni, p_asiste.dni, \'-\') AS dni'),
                'certificado.nro AS numero_certificado',
                DB::raw("CONCAT(
                    COALESCE(p_normal.apell, p_asiste.apell, ''),
                    ' ',
                    COALESCE(p_normal.nombre, p_asiste.nombre, '')
                ) AS nombres_completos"),
                DB::raw('COALESCE(p_normal.tele, p_asiste.tele, \'-\') AS telefono'),
                DB::raw('COALESCE(p_normal.email, p_asiste.email, \'-\') AS correo'),
                DB::raw('COALESCE(estadocerti.nomestadc, \'Sin Estado\') AS estado'),
                DB::raw('COALESCE(tipocertificado.tipocertifi, \'Sin Tipo\') AS tipo_certificado'),
                DB::raw('COALESCE(certificado.tiempocapa, \'-\') AS tiempo_capa'),
                DB::raw('COALESCE(certificado.cuader, \'-\') AS cuaderno'),
                DB::raw('COALESCE(certificado.foli, \'-\') AS folio'),
                DB::raw('COALESCE(certificado.numregis, \'-\') AS nro_reg'),
                'certificado.tokenn AS token',
                DB::raw('COALESCE(certificado.descr, \'-\') AS descripcion'),
                DB::raw('COALESCE(certificado.pdff, \'Sin PDF\') AS pdf'),
                DB::raw('0 AS porcentaje_asistencia'), // Si tienes cálculo real, agrégalo aquí
                'certificado.nro AS inser_numero_certificado'
            )
            ->orderByRaw('COALESCE(p_normal.apell, p_asiste.apell)')
            ->get();
    }

    public function headings(): array
    {
        return [
            'N°',
            'DNI',
            'N° Certi',
            'Nombres y Apellidos',
            'Teléfono',
            'Correo',
            'Estado',
            'Tipo Certificado',
            'Tiempo Capa',
            'Cuaderno',
            'Folio',
            'N° Reg',
            'Token',
            'Descripción',
            'PDF',
            '% Asist',
            'Inser N° Certi'
        ];
    }

    public function title(): string
    {
        return 'Certificados del Evento';
    }
}