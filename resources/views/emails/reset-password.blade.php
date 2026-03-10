@component('mail::message')
# Restablecer tu Contraseña

@slot('subcopy')
Si tienes problemas para hacer clic en el botón "Restablecer Contraseña", copia y pega la URL a continuación en tu navegador web:
{{ $actionUrl }}
@endslot

Recibiste este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.

@component('mail::button', ['url' => $actionUrl])
Restablecer Contraseña
@endcomponent

Este enlace de restablecimiento de contraseña expirará en {{ config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') }} minutos.

Si no solicitaste un restablecimiento de contraseña, no es necesario que hagas nada más.

Saludos,<br>
{{ config('app.name') }}
@endcomponent
