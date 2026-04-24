<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .brutal-container { background-color: #f3f4f6; padding: 20px; font-family: 'Roboto', sans-serif; }
        .brutal-card {
            background-color: #ffffff;
            border: 4px solid #000000;
            box-shadow: 4px 4px 0px 0px #000000; /* shadow-brutal */
            max-width: 400px;
            margin: 0 auto;
            padding: 24px;
        }
        .brutal-header {
            background-color: #FF2E63; /* gym-pink */
            color: #ffffff;
            border-bottom: 4px solid #000000;
            margin: -24px -24px 24px -24px;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="brutal-container">
    <article class="brutal-card">
        <header class="brutal-header">
            <h1 style="margin: 0; font-size: 24px; font-weight: 900; text-transform: uppercase; font-style: italic;">
                ¡PLAN VENCIDO!
            </h1>
        </header>

        <section style="color: #000000;">
            <p style="font-size: 18px; font-weight: 700; text-transform: uppercase;">
                Hola, {{ $user->first_name }} {{ $user->last_name }}
            </p>

            <p style="font-weight: 500; line-height: 1.5;">
                Te informamos que tu membresía ha finalizado el día de hoy.
                No permitas que tu progreso se detenga; en <strong>GYMADM</strong> estamos listos para seguir entrenando contigo.
            </p>

            <div style="background-color: #45B1FF; border: 2px solid #000000; padding: 10px; margin: 20px 0;">
                <p style="margin: 0; font-weight: 900; font-size: 14px; text-transform: uppercase;">
                    Último Plan: {{ $membership->membershipPlan->name }}
                </p>
            </div>

            <p style="font-size: 14px; font-weight: 800; color: #000000; text-align: center; background-color: #FDE047; padding: 10px; border: 2px solid #000000; box-shadow: 2px 2px 0px 0px #000000;">
                ACÉRCATE A RECEPCIÓN PARA RENOVAR
            </p>
        </section>
    </article>
</div>
</body>
</html>
