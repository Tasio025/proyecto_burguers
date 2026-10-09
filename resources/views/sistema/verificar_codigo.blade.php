<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- $titulo viene del controlador --}}
    <title>{{ $titulo ?? 'Verificación' }}</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; justify-content: center; padding-top: 60px; }
        .caja { background: #fff; padding: 32px; border-radius: 8px; max-width: 380px; width: 100%; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        .cuadritos { display: flex; gap: 8px; justify-content: center; margin: 24px 0; }
        .cuadrito { width: 44px; height: 52px; text-align: center; font-size: 24px; border: 2px solid #ccc; border-radius: 6px; }
        .cuadrito:focus { border-color: #333; outline: none; } /* resalta el cuadrito activo */
        .error { color: #c00; margin: 12px 0; }
        button { padding: 10px 24px; font-size: 16px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="caja">
        <h2>Verificación</h2>
        <p>Te enviamos un código de 6 dígitos a tu correo.</p>

        {{-- Mensaje de error, si el controlador mandó $msg (MSG es la clave que usás en todo el sistema) --}}
        @if(isset($msg))
            <p class="error">{{ $msg["MSG"] }}</p>
        @endif

        <form method="POST" action="{{ url('admin/verificar-codigo') }}" id="formCodigo">
            {{ csrf_field() }} {{-- token anti-CSRF, igual que en tu login --}}

            <div class="cuadritos">
                @for ($i = 0; $i < 6; $i++)
                    {{-- inputmode numeric abre el teclado numérico en el celular --}}
                    {{-- one-time-code deja que el celular sugiera el código al llegar el mail --}}
                    <input type="text" inputmode="numeric" maxlength="1" class="cuadrito"
                           autocomplete="{{ $i == 0 ? 'one-time-code' : 'off' }}">
                @endfor
            </div>

            {{-- Acá se junta el código completo; el controlador lee txtCodigo --}}
            <input type="hidden" name="txtCodigo" id="txtCodigo">

            <button type="submit" id="btnVerificar">Verificar</button>
        </form>

        <p><a href="{{ url('admin/login') }}">Volver al inicio de sesión</a></p>
    </div>

    <script>
        const cuadritos = document.querySelectorAll('.cuadrito');
        const oculto = document.getElementById('txtCodigo');
        const form = document.getElementById('formCodigo');
        const boton = document.getElementById('btnVerificar');

        // Junta los 6 valores en el campo oculto
        function actualizarOculto() {
            oculto.value = Array.from(cuadritos).map(c => c.value).join('');
        }

        cuadritos.forEach((c, i) => {
            // Al escribir: deja solo dígitos y pasa al siguiente cuadrito
            c.addEventListener('input', () => {
                c.value = c.value.replace(/\D/g, '');
                if (c.value && i < cuadritos.length - 1) cuadritos[i + 1].focus();
                actualizarOculto();
            });

            // Backspace en un cuadrito vacío: vuelve al anterior
            c.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !c.value && i > 0) cuadritos[i - 1].focus();
            });

            // Pegar el código completo reparte los dígitos en los cuadritos
            c.addEventListener('paste', (e) => {
                e.preventDefault();
                const texto = (e.clipboardData.getData('text') || '').replace(/\D/g, '').slice(0, 6);
                texto.split('').forEach((d, k) => { cuadritos[k].value = d; });
                actualizarOculto();
                cuadritos[Math.min(texto.length, 5)].focus();
            });
        });

        form.addEventListener('submit', (e) => {
            actualizarOculto();
            // No envía si faltan dígitos: así no se gasta un intento de los 5 por un error de tipeo
            if (oculto.value.length < 6) {
                e.preventDefault();
                return;
            }
            // Evita el doble clic, que gastaría dos intentos
            boton.disabled = true;
        });

        cuadritos[0].focus(); // empieza con el foco en el primer cuadrito
    </script>
</body>
</html>