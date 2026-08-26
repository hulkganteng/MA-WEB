@php
    $enabled = setting('whatsapp.enabled', true);
    $number = setting('whatsapp.number');
    $message = setting('whatsapp.message', 'Assalamualaikum, saya ingin bertanya tentang MA Ma\'arif NU Assa\'adah.');
    $message = rawurlencode($message);
@endphp

@if ($enabled && $number)
    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $number) }}?text={{ $message }}"
       target="_blank" rel="noopener"
       class="fixed bottom-5 right-5 z-40 flex h-13 w-13 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lift transition hover:scale-105"
       style="height:52px;width:52px"
       aria-label="Chat WhatsApp">
        <x-icon name="message-circle" class="h-6 w-6" />
    </a>
@endif
