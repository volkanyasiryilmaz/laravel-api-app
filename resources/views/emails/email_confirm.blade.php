@component('mail::message')
# E-Posta Doğrulama

Merhaba Sayın {{ $license->name }} {{ $license->surname }},

Lütfen e-posta adresinizi doğrulamak için aşağıdaki butona tıklayınız;

@component('mail::button', ['url' => $url])
Doğrula
@endcomponent

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
