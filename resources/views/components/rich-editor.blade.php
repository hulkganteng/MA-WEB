@props([
    'id' => null,
    'name' => 'body',
    'value' => '',
    'label' => null,
    'placeholder' => 'Tulis konten lengkap di sini...',
    'required' => false,
    'minHeight' => '380px',
    'helper' => 'Gunakan toolbar di atas untuk memformat teks, menambahkan heading, list, kutipan, tabel, atau link.',
])

@php
    $editorId = $id ?: 'editor_'.str_replace(['[', ']', '.'], '_', $name).'_'.uniqid();
    $textareaId = 'textarea_'.$editorId;
    $initialValue = old($name, $value);
@endphp

<div class="flex flex-col gap-1.5"
     x-data="{
         isHtmlMode: false,
         content: @js($initialValue ?? ''),
         wordCount: 0,
         charCount: 0,
         quill: null,
         initEditor() {
             const loadQuill = () => {
                 if (window.Quill) {
                     this.setupQuill();
                 } else {
                     if (!document.getElementById('quill-css')) {
                         const link = document.createElement('link');
                         link.id = 'quill-css';
                         link.rel = 'stylesheet';
                         link.href = 'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css';
                         document.head.appendChild(link);
                     }
                     if (!document.getElementById('quill-js')) {
                         const script = document.createElement('script');
                         script.id = 'quill-js';
                         script.src = 'https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js';
                         script.onload = () => this.setupQuill();
                         document.head.appendChild(script);
                     } else {
                         const existing = document.getElementById('quill-js');
                         existing.addEventListener('load', () => this.setupQuill());
                     }
                 }
             };
             this.$nextTick(() => loadQuill());
         },
         setupQuill() {
             if (this.quill) return;
             const container = document.getElementById('{{ $editorId }}-container');
             if (!container) return;

             const toolbarOptions = [
                 [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                 ['bold', 'italic', 'underline', 'strike'],
                 [{ 'color': [] }, { 'background': [] }],
                 [{ 'script': 'sub'}, { 'script': 'super' }],
                 [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                 [{ 'indent': '-1'}, { 'indent': '+1' }],
                 [{ 'align': [] }],
                 ['blockquote', 'code-block'],
                 ['link', 'image', 'video', 'table'],
                 ['clean']
             ];

             this.quill = new Quill(container, {
                 theme: 'snow',
                 placeholder: @js($placeholder),
                 modules: {
                     toolbar: {
                         container: toolbarOptions,
                     }
                 }
             });

             if (this.content) {
                 this.quill.root.innerHTML = this.content;
                 this.updateCounts();
             }

             this.quill.on('text-change', () => {
                 this.content = this.quill.root.innerHTML === '<p><br></p>' ? '' : this.quill.root.innerHTML;
                 const rawTextarea = document.getElementById('{{ $textareaId }}');
                 if (rawTextarea) rawTextarea.value = this.content;
                 this.updateCounts();
             });
         },
         toggleHtmlMode() {
             this.isHtmlMode = !this.isHtmlMode;
             if (!this.isHtmlMode && this.quill) {
                 this.quill.root.innerHTML = this.content;
                 this.updateCounts();
             } else if (this.isHtmlMode && this.quill) {
                 this.content = this.quill.root.innerHTML === '<p><br></p>' ? '' : this.quill.root.innerHTML;
             }
         },
         syncFromTextarea(val) {
             this.content = val;
             if (this.quill && !this.isHtmlMode) {
                 this.quill.root.innerHTML = val;
             }
             this.updateCounts();
         },
         updateCounts() {
             const text = this.quill ? this.quill.getText().trim() : (this.content ? this.content.replace(/<[^>]*>?/gm, '').trim() : '');
             this.charCount = text.length;
             this.wordCount = text ? text.split(/\s+/).filter(Boolean).length : 0;
         }
     }"
     x-init="initEditor()">

    @if($label)
        <div class="flex items-center justify-between">
            <label for="{{ $textareaId }}" class="label mb-0">
                {{ $label }}
                @if($required) <span class="text-rose-500">*</span> @endif
            </label>
            <div class="flex items-center gap-3 text-xs text-slate-500 font-mono">
                <span><strong x-text="wordCount">0</strong> kata</span>
                <span>•</span>
                <span><strong x-text="charCount">0</strong> karakter</span>
                <button type="button"
                        @click="toggleHtmlMode()"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-sans font-semibold text-slate-700 hover:bg-primary-50 hover:text-primary-800 transition">
                    <x-icon name="code-2" class="size-3.5" />
                    <span x-text="isHtmlMode ? 'Kembali ke Visual Editor' : 'Lihat / Edit HTML Source'"></span>
                </button>
            </div>
        </div>
    @endif

    {{-- WYSIWYG Visual Editor Wrapper --}}
    <div class="rich-editor-wrapper rounded-2xl border border-slate-300 bg-white overflow-x-auto shadow-sm focus-within:border-primary-600 focus-within:ring-2 focus-within:ring-primary-600/20 transition"
         :class="isHtmlMode ? 'hidden' : 'block'">
        <div id="{{ $editorId }}-container"
             style="min-height: {{ $minHeight }};"
             class="prose max-w-none text-slate-800 text-sm leading-relaxed p-4"></div>
    </div>

    {{-- Raw HTML Code Mode Editor --}}
    <div x-show="isHtmlMode" x-cloak class="space-y-2">
        <textarea rows="14"
                  x-model="content"
                  @input="syncFromTextarea($event.target.value)"
                  class="input font-mono text-xs leading-relaxed bg-slate-900 text-emerald-300 p-4 border-slate-800 focus:ring-emerald-500/20"
                  placeholder="&lt;p&gt;Tulis kode HTML langsung di sini...&lt;/p&gt;"></textarea>
        <p class="text-xs text-slate-500">Mode HTML aktif. Anda dapat mengedit tag HTML secara langsung di atas.</p>
    </div>

    {{-- Single Dedicated Hidden Textarea for Standard Form Submit --}}
    <textarea id="{{ $textareaId }}"
              name="{{ $name }}"
              class="sr-only"
              x-model="content"
              @if($required) required @endif></textarea>

    @if($helper)
        <div class="flex items-center justify-between text-xs text-slate-500">
            <p>{{ $helper }}</p>
            @if(!$label)
                <button type="button"
                        @click="toggleHtmlMode()"
                        class="inline-flex items-center gap-1 font-semibold text-primary-700 hover:underline">
                    <span x-text="isHtmlMode ? 'Visual Editor' : 'Edit Source HTML'"></span>
                </button>
            @endif
        </div>
    @endif

    @error($name)
        <p class="mt-1 text-sm text-rose-700 font-medium">{{ $message }}</p>
    @enderror
</div>

<style>
    /* Styling kustom untuk Quill Editor agar selaras dengan Tailwind dan tema MA WEB */
    .ql-toolbar.ql-snow {
        border: none !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
        padding: 10px 14px !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
        font-family: inherit !important;
    }
    .ql-container.ql-snow {
        border: none !important;
        font-family: inherit !important;
        font-size: 0.95rem !important;
    }
    .ql-editor {
        min-height: {{ $minHeight }} !important;
        padding: 16px 20px !important;
        line-height: 1.7 !important;
        color: #1e293b !important;
    }
    .ql-editor.ql-blank::before {
        left: 20px !important;
        right: 20px !important;
        color: #94a3b8 !important;
        font-style: normal !important;
    }
    .ql-snow .ql-picker {
        color: #475569 !important;
        font-weight: 500 !important;
    }
    .ql-snow .ql-stroke {
        stroke: #475569 !important;
    }
    .ql-snow .ql-fill {
        fill: #475569 !important;
    }
    .ql-snow .ql-picker.ql-expanded .ql-picker-options {
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        z-index: 30 !important;
    }
    .ql-snow.ql-toolbar button:hover,
    .ql-snow .ql-toolbar button:hover,
    .ql-snow.ql-toolbar button.ql-active,
    .ql-snow .ql-toolbar button.ql-active {
        color: #006437 !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-stroke,
    .ql-snow .ql-toolbar button:hover .ql-stroke,
    .ql-snow.ql-toolbar button.ql-active .ql-stroke,
    .ql-snow .ql-toolbar button.ql-active .ql-stroke {
        stroke: #006437 !important;
    }
    .ql-snow.ql-toolbar button:hover .ql-fill,
    .ql-snow .ql-toolbar button:hover .ql-fill,
    .ql-snow.ql-toolbar button.ql-active .ql-fill,
    .ql-snow .ql-toolbar button.ql-active .ql-fill {
        fill: #006437 !important;
    }
</style>
