<?php

/**
 * HTMLPurifier Configuration untuk MA WEB
 *
 * Konfigurasi ini membatasi HTML yang diizinkan di konten admin.
 * - Link (href) hanya boleh menggunakan scheme yang aman (http, https, mailto, tel).
 * - Script, iframe, object, embed DILARANG di setting default.
 * - YouTube iframe hanya diperbolehkan lewat setting 'youtube' secara eksplisit.
 * - Mencegah XSS dan injeksi link judol/malicious.
 *
 * @link http://htmlpurifier.org/live/configdoc/plain.html
 */

return [
    'encoding'         => 'UTF-8',
    'finalize'         => true,
    'ignoreNonStrings' => false,
    'cachePath'        => storage_path('app/purifier'),
    'cacheFileMode'    => 0755,
    'settings'         => [

        /*
        |--------------------------------------------------------------------------
        | Default – digunakan untuk body artikel, berita, halaman, pengumuman, dll.
        |--------------------------------------------------------------------------
        */
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'h1,h2,h3,h4,h5,h6,div,p[style],b,strong,i,em,u,s,del,ins,sub,sup,mark,a[href|title|target|rel],ul,ol,li,br,span[style],img[width|height|alt|src],table,thead,tbody,tr,th[colspan|rowspan|style],td[colspan|rowspan|style],blockquote,code,pre,hr,figure,figcaption,section,article,aside,header,footer',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align,width,height,margin,margin-left,margin-right',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => true,
            // Batasi scheme URI yang diizinkan — TIDAK ada javascript:, data:, vbscript:
            'URI.AllowedSchemes'       => ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true],
            // Target link hanya _blank dan _self
            'Attr.AllowedFrameTargets' => ['_blank', '_self'],
            // Paksa rel="noopener noreferrer" pada semua link yang buka tab baru
            'HTML.TargetBlank'         => true,
            'HTML.TargetNoopener'      => true,
            'HTML.TargetNoreferrer'    => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | youtube – digunakan jika body perlu embed YouTube
        |--------------------------------------------------------------------------
        */
        'youtube' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'h1,h2,h3,h4,h5,h6,div,p[style],b,strong,i,em,u,s,del,ins,sub,sup,mark,a[href|title|target|rel],ul,ol,li,br,span[style],img[width|height|alt|src],iframe[src|width|height|allowfullscreen|frameborder],table,thead,tbody,tr,th[colspan|rowspan|style],td[colspan|rowspan|style],blockquote,code,pre,hr,figure,figcaption,section,article,aside,header,footer',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align,width,height,margin,margin-left,margin-right',
            'AutoFormat.RemoveEmpty'   => true,
            'URI.AllowedSchemes'       => ['http' => true, 'https' => true, 'mailto' => true],
            'HTML.SafeIframe'          => true,
            // Hanya izinkan embed dari YouTube dan Vimeo — TIDAK dari domain lain
            'URI.SafeIframeRegexp'     => '%^https://(www\.youtube\.com/embed/|www\.youtube-nocookie\.com/embed/|player\.vimeo\.com/video/)[\w\-?=&]+$%',
            'Attr.AllowedFrameTargets' => ['_blank', '_self'],
            'HTML.TargetBlank'         => true,
            'HTML.TargetNoopener'      => true,
            'HTML.TargetNoreferrer'    => true,
        ],

        /*
        |--------------------------------------------------------------------------
        | custom_definition – Definisi elemen HTML5 agar HTMLPurifier mengenalinya
        |--------------------------------------------------------------------------
        */
        'custom_definition' => [
            'id'    => 'html5-definitions',
            'rev'   => 3,
            'debug' => false,
            'elements' => [
                // Semantik dokumen HTML5
                ['section',    'Block', 'Flow',     'Common'],
                ['nav',        'Block', 'Flow',     'Common'],
                ['article',    'Block', 'Flow',     'Common'],
                ['aside',      'Block', 'Flow',     'Common'],
                ['header',     'Block', 'Flow',     'Common'],
                ['footer',     'Block', 'Flow',     'Common'],
                ['address',    'Block', 'Flow',     'Common'],
                ['hgroup',     'Block', 'Required: h1 | h2 | h3 | h4 | h5 | h6', 'Common'],

                // Gambar dan caption
                ['figure',     'Block', 'Optional: (figcaption, Flow) | (Flow, figcaption) | Flow', 'Common'],
                ['figcaption', 'Inline', 'Flow',   'Common'],

                // Teks semantik
                ['s',    'Inline', 'Inline', 'Common'],
                ['var',  'Inline', 'Inline', 'Common'],
                ['sub',  'Inline', 'Inline', 'Common'],
                ['sup',  'Inline', 'Inline', 'Common'],
                ['mark', 'Inline', 'Inline', 'Common'],
                ['wbr',  'Inline', 'Empty',  'Core'],
                ['ins',  'Block',  'Flow',   'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
                ['del',  'Block',  'Flow',   'Common', ['cite' => 'URI', 'datetime' => 'CDATA']],
            ],
            'attributes' => [
                ['iframe', 'allowfullscreen', 'Bool'],
                ['table',  'height',          'Text'],
                ['td',     'border',          'Text'],
                ['th',     'border',          'Text'],
                ['tr',     'width',           'Text'],
                ['tr',     'height',          'Text'],
                ['tr',     'border',          'Text'],
                ['a',      'target',          'Enum#_blank,_self,_top'],
                ['a',      'rel',             'Text'],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | custom_attributes
        |--------------------------------------------------------------------------
        */
        'custom_attributes' => [
            ['a', 'target', 'Enum#_blank,_self,_target,_top'],
            ['a', 'rel',    'Text'],
        ],

        /*
        |--------------------------------------------------------------------------
        | custom_elements
        |--------------------------------------------------------------------------
        */
        'custom_elements' => [
            ['u', 'Inline', 'Inline', 'Common'],
        ],

    ],
];
