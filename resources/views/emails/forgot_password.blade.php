@component('mail::message')
# Şifre Yenileme

Merhaba Sayın {{ $license->name }} {{ $license->surname }},

Yeni şifreniz aşağıdaki gibidir;

**{{ $new_password }}**

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
