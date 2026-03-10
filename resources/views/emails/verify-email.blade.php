@component('mail::message')
# Verificar tu Dirección de Correo Electrónico

Por favor, haz clic en el botón a continuación para verificar tu dirección de correo electrónico.

@component('mail::button', ['url' => $actionUrl])
Verificar Dirección de Correo
@endcomponent

Si no creaste esta cuenta, puedes ignorar este correo.

Saludos,<br>
{{ config('app.name') }}
@endcomponent
