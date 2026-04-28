<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .brutal-container { background-color: #000000; padding: 20px; font-family: 'Roboto', sans-serif; }
        .brutal-card { background-color: #ffffff; border: 4px solid #ffffff; padding: 24px; color: #000000; }
        .section-title { text-transform: uppercase; font-weight: 900; font-style: italic; font-size: 18px; margin-top: 30px; margin-bottom: 15px; padding-left: 10px; }
        .vencidos-title { border-left: 8px solid #FF2E63; } /* gym-pink */
        .inactivos-title { border-left: 8px solid #45B1FF; } /* gym-blue */
        .list-item { border-bottom: 2px solid #000000; padding: 10px 0; font-size: 14px; }
        .badge { display: inline-block; padding: 2px 6px; font-weight: 900; font-size: 12px; margin-right: 8px; border: 1px solid #000000; }
        .badge-pink { background-color: #FF2E63; color: #ffffff; }
        .badge-blue { background-color: #45B1FF; color: #000000; }
    </style>
</head>
<body>
<div class="brutal-container">
    <div class="brutal-card">
        <h1 style="text-transform: uppercase; font-weight: 900; font-size: 24px; margin: 0; border-bottom: 4px solid #000000; padding-bottom: 10px;">
            REPORTE OPERATIVO
        </h1>

        <h2 class="section-title vencidos-title">Vencimientos de Hoy</h2>
        <p style="font-size: 12px; font-weight: 600; color: #4b5563;">Abordar a estos miembros para renovación inmediata.</p>
        <div>
            @forelse($vencidosHoy as $membership)
                <div class="list-item">
                    <span class="badge badge-pink">{{ $membership->user->document_number }}</span>
                    <strong>{{ $membership->user->first_name }} {{ $membership->user->last_name }}</strong>
                </div>
            @empty
                <p style="font-style: italic; color: #6b7280;">No hay vencimientos para el día de hoy.</p>
            @endforelse
        </div>

        <h2 class="section-title inactivos-title">Sin Acceso (Últimos 30 días)</h2>
        <p style="font-size: 12px; font-weight: 600; color: #4b5563;">Miembros con membresía expirada recientemente.</p>
        <div>
            @forelse($sinAccesoRecientes as $membership)
                <div class="list-item">
                    <span class="badge badge-blue">{{ $membership->user->document_number }}</span>
                    <strong>{{ $membership->user->first_name }} {{ $membership->user->last_name }}</strong>
                    <div style="font-size: 11px; margin-top: 4px;">Venció: {{ \Carbon\Carbon::parse($membership->end_date)->format('d/m/Y') }}</div>
                </div>
            @empty
                <p style="font-style: italic; color: #6b7280;">No hay registros de inactividad reciente.</p>
            @endforelse
        </div>

        <footer style="margin-top: 40px; border-top: 2px solid #000000; pt: 10px; text-align: center;">
            <p style="font-size: 10px; font-weight: 900; text-transform: uppercase;">Sistema GYMADM - Reporte Automático</p>
        </footer>
    </div>
</div>
</body>
</html>
