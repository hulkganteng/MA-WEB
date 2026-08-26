@php $editing = $calendar->exists; @endphp
<x-layouts.admin :title="($editing ? 'Edit' : 'Tambah').' Agenda Kaldik'">
    <form method="POST" action="{{ $editing ? route('admin.calendars.update', $calendar) : route('admin.calendars.store') }}" x-data="{ saving: false }" @submit="saving = true">
        @csrf
        @if($editing) @method('PUT') @endif

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <a href="{{ route('admin.calendars.index') }}" class="text-xs font-semibold text-primary-700 hover:underline">← Kembali ke daftar kalender akademik</a>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-slate-950">{{ $editing ? 'Edit Agenda Kaldik' : 'Tambah Agenda Kaldik' }}</h2>
            </div>
            <button type="submit" class="btn-primary shrink-0 !py-2.5 !px-5 font-bold" :disabled="saving" x-text="saving ? 'Menyimpan…' : 'Simpan Agenda'">
                Simpan Agenda
            </button>
        </div>

        @if($errors->any())
            <div class="mt-6 rounded-2xl bg-rose-50 p-4 text-xs font-semibold text-rose-800 border border-rose-200">
                Agenda belum dapat disimpan. Periksa input yang ditandai merah.
            </div>
        @endif

        <div class="mt-6 grid gap-6 xl:grid-cols-[2fr_1fr]">
            <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-5">
                <div>
                    <label for="title" class="label text-xs font-bold text-slate-700">Nama Agenda / Kegiatan <span class="text-rose-500">*</span></label>
                    <input id="title" name="title" type="text" value="{{ old('title', $calendar->title) }}" class="input" placeholder="Contoh: Asesmen Sumatif Akhir Semester, Libur Idul Fitri..." required>
                    @error('title')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="start_date" class="label text-xs font-bold text-slate-700">Tanggal Mulai <span class="text-rose-500">*</span></label>
                        <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $calendar->start_date?->format('Y-m-d')) }}" class="input" required>
                        @error('start_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="end_date" class="label text-xs font-bold text-slate-700">Tanggal Selesai (Opsional)</label>
                        <input id="end_date" name="end_date" type="date" value="{{ old('end_date', $calendar->end_date?->format('Y-m-d')) }}" class="input">
                        @error('end_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="label text-xs font-bold text-slate-700">Keterangan / Rincian Tambahan</label>
                    <textarea id="description" name="description" rows="5" class="input" placeholder="Keterangan mengenai ketentuan pakaian, peserta, lokasi...">{{ old('description', $calendar->description) }}</textarea>
                </div>
            </section>

            <aside class="flex flex-col gap-6">
                <section class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200 space-y-4">
                    <div>
                        <label for="category" class="label text-xs font-bold text-slate-700">Kategori Agenda <span class="text-rose-500">*</span></label>
                        <select id="category" name="category" class="input" required>
                            @foreach(\App\Models\AcademicCalendar::CATEGORIES as $cat)
                                <option value="{{ $cat }}" @selected(old('category', $calendar->category ?? 'akademik') === $cat)>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="academic_year" class="label text-xs font-bold text-slate-700">Tahun Ajaran</label>
                        <input id="academic_year" name="academic_year" type="text" value="{{ old('academic_year', $calendar->academic_year ?? '2026/2027') }}" class="input" placeholder="Contoh: 2026/2027">
                    </div>
                </section>
            </aside>
        </div>
    </form>
</x-layouts.admin>
