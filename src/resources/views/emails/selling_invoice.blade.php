@component('mail::message')
# {{ $content['title'] }}

{{ $content['body'] }}

Untuk Mengecek Pesanan Anda Silahkan Klik Link Dibawah, Lalu Input Nomor Resi Berikut :

{{ $content['id_delivery'] }}

@component('mail::button', ['url' => $content['url'] ])
{{ $content['button'] }}
@endcomponent


Thanks,

{{ config('app.name') }}
@endcomponent