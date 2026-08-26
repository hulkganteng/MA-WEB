/**
 * MA Ma'arif NU Assa'adah Bungah Gresik - Islamic & Modern Interactive Hub
 * Includes:
 * 1. Live Prayer Times Calculator for Bungah Gresik (-7.0583, 112.5694, UTC+7) with dynamic countdown
 * 2. Hijri & Masehi Live Date Converter
 * 3. Interactive SPMB Peminatan (Major Recommendation) Quiz Calculator
 * 4. Command Palette (Ctrl+K / Cmd+K Quick Search)
 * 5. Audio Player state for Mars Madrasah & Tilawah
 * 6. Accessibility & Scroll Utilities
 */

// Astronomical Calculation for Prayer Times (Kemenag standard)
function calculatePrayerTimes(date = new Date()) {
    const lat = -7.0583; // Bungah, Gresik
    const lng = 112.5694;
    const tz = 7; // WIB (UTC+7)

    const year = date.getFullYear();
    const month = date.getMonth() + 1;
    const day = date.getDate();

    // Julian Day
    const a = Math.floor((14 - month) / 12);
    const y = year + 4800 - a;
    const m = month + 12 * a - 3;
    const jd = day + Math.floor((153 * m + 2) / 5) + 365 * y + Math.floor(y / 4) - Math.floor(y / 100) + Math.floor(y / 400) - 32045;

    const d = jd - 2451545.0; // days since J2000.0

    // Sun's mean anomaly and longitude
    const g = (357.529 + 0.98560028 * d) % 360;
    const q = (280.459 + 0.98564736 * d) % 360;
    const L = (q + 1.915 * Math.sin(deg2rad(g)) + 0.020 * Math.sin(deg2rad(2 * g))) % 360;

    const e = 23.439 - 0.00000036 * d; // obliquity of ecliptic
    const sinDec = Math.sin(deg2rad(e)) * Math.sin(deg2rad(L));
    const dec = rad2deg(Math.asin(sinDec));

    // Equation of time (in minutes)
    const RA = rad2deg(Math.atan2(Math.cos(deg2rad(e)) * Math.sin(deg2rad(L)), Math.cos(deg2rad(L)))) / 15;
    const EqT = (q / 15 - RA) * 60;

    // Solar noon (Dzuhur) in local hours
    const noon = 12 + tz - lng / 15 - EqT / 60;

    function sunAngleTime(angle, direction = -1) {
        const radLat = deg2rad(lat);
        const radDec = deg2rad(dec);
        const cosH = (Math.sin(deg2rad(angle)) - Math.sin(radLat) * Math.sin(radDec)) / (Math.cos(radLat) * Math.cos(radDec));
        if (cosH > 1 || cosH < -1) return null;
        const H = rad2deg(Math.acos(cosH)) / 15;
        return noon + direction * H;
    }

    function asrTime() {
        const radLat = deg2rad(lat);
        const radDec = deg2rad(dec);
        const noonAngle = Math.abs(lat - dec);
        const asrAngle = -rad2deg(Math.atan(1 + Math.tan(deg2rad(noonAngle))));
        const cosH = (Math.sin(deg2rad(asrAngle)) - Math.sin(radLat) * Math.sin(radDec)) / (Math.cos(radLat) * Math.cos(radDec));
        if (cosH > 1 || cosH < -1) return noon + 3.2; // fallback
        const H = rad2deg(Math.acos(cosH)) / 15;
        return noon + H;
    }

    function deg2rad(deg) { return (deg * Math.PI) / 180; }
    function rad2deg(rad) { return (rad * 180) / Math.PI; }

    function formatTime(hoursFloat) {
        if (hoursFloat === null || isNaN(hoursFloat)) return '--:--';
        let h = Math.floor(hoursFloat);
        let m = Math.floor((hoursFloat - h) * 60) + 2; // +2 mins ihtiyat
        if (m >= 60) {
            h += Math.floor(m / 60);
            m %= 60;
        }
        h = (h % 24 + 24) % 24;
        return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}`;
    }

    const subuhHours = sunAngleTime(-20, -1);
    const terbitHours = sunAngleTime(-0.833, -1);
    const dzuhurHours = noon;
    const asrHours = asrTime();
    const maghribHours = sunAngleTime(-0.833, 1);
    const isyaHours = sunAngleTime(-18, 1);

    return {
        subuh: formatTime(subuhHours),
        terbit: formatTime(terbitHours),
        dzuhur: formatTime(dzuhurHours),
        ashar: formatTime(asrHours),
        maghrib: formatTime(maghribHours),
        isya: formatTime(isyaHours),
        raw: {
            subuh: subuhHours,
            terbit: terbitHours,
            dzuhur: dzuhurHours,
            ashar: asrHours,
            maghrib: maghribHours,
            isya: isyaHours,
        }
    };
}

// Convert Gregorian date to Hijri
function getHijriDate(date = new Date()) {
    const dayNames = ['Ahad', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const hijriMonths = [
        'Muharram', 'Safar', 'Rabi\'ul Awwal', 'Rabi\'ul Akhir',
        'Jumadil Ula', 'Jumadil Akhir', 'Rajab', 'Sya\'ban',
        'Ramadhan', 'Syawwal', 'Dzulqa\'dah', 'Dzulhijjah'
    ];

    const d = date.getDate();
    const m = date.getMonth();
    const y = date.getFullYear();

    let jd = Math.floor((1461 * (y + 4800 + Math.floor((m - 13) / 12))) / 4) +
             Math.floor((367 * (m - 1 - 12 * Math.floor((m - 13) / 12))) / 12) -
             Math.floor((3 * Math.floor((y + 4900 + Math.floor((m - 13) / 12)) / 100)) / 4) +
             d - 32075;

    let l = jd - 1948440 + 10632;
    let n = Math.floor((l - 1) / 10631);
    l = l - 10631 * n + 354;
    let j = (Math.floor((10985 - l) / 5316)) * (Math.floor((50 * l) / 17719)) +
            (Math.floor(l / 5670)) * (Math.floor((43 * l) / 15238));
    l = l - (Math.floor((30 - j) / 15)) * (Math.floor((17719 * j) / 50)) -
        (Math.floor(j / 16)) * (Math.floor((15238 * j) / 43)) + 29;
    let hm = Math.floor((24 * l) / 709);
    let hd = l - Math.floor((709 * hm) / 24);
    let hy = 30 * n + j - 30;

    const dayName = dayNames[date.getDay()];
    const hMonthName = hijriMonths[Math.max(0, Math.min(11, hm - 1))];

    return `${dayName}, ${hd} ${hMonthName} ${hy} H`;
}

export function initIslamicHub(Alpine, createIcons, icons, confetti) {
    // 1. Prayer Store
    Alpine.store('prayer', {
        times: calculatePrayerTimes(),
        hijri: getHijriDate(),
        masehi: new Intl.DateTimeFormat('id-ID', { dateStyle: 'full' }).format(new Date()),
        currentPrayer: 'Dzuhur',
        nextPrayerName: 'Ashar',
        countdownText: '00:00:00',
        modalOpen: false,

        init() {
            this.updateSchedule();
            setInterval(() => this.updateSchedule(), 1000);
        },

        openModal() {
            this.modalOpen = true;
            if (createIcons && icons) setTimeout(() => createIcons({ icons }), 50);
        },

        closeModal() {
            this.modalOpen = false;
        },

        updateSchedule() {
            const now = new Date();
            const currentFloat = now.getHours() + now.getMinutes() / 60 + now.getSeconds() / 3600;
            const t = this.times.raw;

            const prayers = [
                { name: 'Subuh', timeFloat: t.subuh, display: this.times.subuh },
                { name: 'Terbit', timeFloat: t.terbit, display: this.times.terbit },
                { name: 'Dzuhur', timeFloat: t.dzuhur, display: this.times.dzuhur },
                { name: 'Ashar', timeFloat: t.ashar, display: this.times.ashar },
                { name: 'Maghrib', timeFloat: t.maghrib, display: this.times.maghrib },
                { name: 'Isya', timeFloat: t.isya, display: this.times.isya },
            ];

            let next = prayers.find(p => p.timeFloat > currentFloat);
            if (!next) {
                // Next is Subuh tomorrow
                next = { ...prayers[0], timeFloat: prayers[0].timeFloat + 24 };
            }

            this.nextPrayerName = next.name;

            const diffHours = next.timeFloat - currentFloat;
            const totalSeconds = Math.max(0, Math.floor(diffHours * 3600));
            const hrs = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const secs = String(totalSeconds % 60).padStart(2, '0');

            this.countdownText = `${hrs}:${mins}:${secs}`;
        }
    });

    // 2. SPMB Recommendation Calculator Store
    Alpine.store('spmbCalc', {
        isOpen: false,
        step: 1,
        totalSteps: 4,
        scores: { mipa: 0, ips: 0, keagamaan: 0, tahfidz: 0 },
        result: null,

        questions: [
            {
                title: 'Mata pelajaran atau bidang apa yang paling Anda sukai?',
                subtitle: 'Pilihlah salah satu yang paling menggambarkan ketertarikan Anda saat ini.',
                options: [
                    { label: 'Matematika, Fisika, Biologi, & Eksperimen Sains', program: 'mipa', icon: 'flask-conical' },
                    { label: 'Sosiologi, Ekonomi, Berwirausaha, & Public Speaking', program: 'ips', icon: 'trending-up' },
                    { label: 'Bahasa Arab, Nahwu-Shorof, Hadits, & Fiqih', program: 'keagamaan', icon: 'book-open' },
                    { label: 'Tahsin, Tilawah, & Menghafal Al-Qur\'an Berirama', program: 'tahfidz', icon: 'heart-handshake' },
                ]
            },
            {
                title: 'Aktivitas ekstrakurikuler mana yang paling ingin Anda ikuti?',
                subtitle: 'Pengembangan diri di luar ruang kelas madrasah.',
                options: [
                    { label: 'Karya Ilmiah Remaja (KIR), Robotika, & Coding Lab', program: 'mipa', icon: 'cpu' },
                    { label: 'OSIM, Jurnalistik Santri, Paskibra, & Bisnis Digital', program: 'ips', icon: 'users' },
                    { label: 'Kajian Kitab Kuning, Bahtsul Masail, & Kaligrafi Khat', program: 'keagamaan', icon: 'feather' },
                    { label: 'Halaqah Tahfidz Intensif & Syahadah Huffadz 30 Juz', program: 'tahfidz', icon: 'sparkles' },
                ]
            },
            {
                title: 'Apa cita-cita atau orientasi karier masa depan Anda?',
                subtitle: 'Aspirasi pendidikan lanjutan setelah lulus dari MA Assa\'adah.',
                options: [
                    { label: 'Dokter, Insinyur, Saintis, atau Software Developer', program: 'mipa', icon: 'atom' },
                    { label: 'Diplomat, Pebisnis Sukses, Pengacara, atau Akademisi Sosial', program: 'ips', icon: 'award' },
                    { label: 'Kyai, Ulama, Dosen Studi Islam, atau Lanjut ke Al-Azhar Kairo', program: 'keagamaan', icon: 'compass' },
                    { label: 'Hafidz/Hafidzah 30 Juz, Dokter Muslim, atau Duta Al-Qur\'an Dunia', program: 'tahfidz', icon: 'sun' },
                ]
            },
            {
                title: 'Suasana belajar seperti apa yang paling mendukung potensi Anda?',
                subtitle: 'Lingkungan belajar yang ideal untuk hari-hari Anda di madrasah.',
                options: [
                    { label: 'Smart Classroom modern dengan riset dan proyek sains praktis', program: 'mipa', icon: 'laptop' },
                    { label: 'Diskusi interaktif, simulasi kepemimpinan, dan kerja tim kreatif', program: 'ips', icon: 'messages-square' },
                    { label: 'Halaqah pesantren khidmat bersama para masyayikh & guru turats', program: 'keagamaan', icon: 'scroll' },
                    { label: 'Asrama karantina tahfidz kondusif dengan muraja\'ah teratur', program: 'tahfidz', icon: 'moon' },
                ]
            }
        ],

        programDetails: {
            mipa: {
                title: 'Peminatan MIPA (Sains & Madrasah Riset)',
                category: 'Reguler Unggulan',
                badge: 'Kecocokan 96%',
                description: 'Anda memiliki profil analitis yang tajam dan ketertarikan tinggi pada sains modern. Program MIPA MA Ma\'arif NU Assa\'adah membekali Anda dengan fasilitas lab terpadu, bimbingan olimpiade sains (KSM), dan proyek riset berskala nasional.',
                highlights: ['Laboratorium Komputer & Sains Lengkap', 'Bimbingan KSM & MYRES Nasional', 'Persiapan SNBT PTN Saintek & Kedokteran', 'Program Coding & Literasi Robotika'],
                actionUrl: 'https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20tertarik%20dengan%20Program%20MIPA%20Riset%20MA%20Assaadah%20setelah%20simulasi%20SPMB.'
            },
            ips: {
                title: 'Peminatan IPS (Sosial Humaniora & Digital Entrepreneur)',
                category: 'Reguler Unggulan',
                badge: 'Kecocokan 94%',
                description: 'Anda memiliki jiwa kepemimpinan komunikatif, kritis, dan berorientasi solusi sosial. Program IPS mengasah pemahaman ekonomi syariah, sosiologi, media digital, dan diplomasi publik.',
                highlights: ['Penguatan Public Speaking 3 Bahasa', 'Praktik Kewirausahaan Digital', 'Kaderisasi Kepemimpinan OSIM & IPNU-IPPNU', 'Jalur Lolos PTN Favorit Bidang Soshum'],
                actionUrl: 'https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20tertarik%20dengan%20Program%20IPS%20Entrepreneur%20MA%20Assaadah%20setelah%20simulasi%20SPMB.'
            },
            keagamaan: {
                title: 'Program Keagamaan (PK / Kajian Kitab Kuning Turats)',
                category: 'Pesantren Unggulan',
                badge: 'Kecocokan 98%',
                description: 'Pilihan paling istimewa bagi pencari ilmu syariah. Memadukan sanad keilmuan para masyayikh Pondok Pesantren Qomaruddin dengan penguasaan bahasa Arab intensif untuk persiapan studi ke Universitas Al-Azhar Kairo dan Ma\'had Aly.',
                highlights: ['Kajian Kitab Kuning Bersanad Shahih', 'Debat Bahasa Arab (Munadzarah)', 'Bimbingan Khusus Seleksi Timur Tengah & Kemenag', 'Muatan Fiqih Ushul Fiqih & Tafsir Mendalam'],
                actionUrl: 'https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20tertarik%20dengan%20Program%20Keagamaan%20Turats%20MA%20Assaadah%20setelah%20simulasi%20SPMB.'
            },
            tahfidz: {
                title: 'Program Khusus Tahfidzul Qur\'an 30 Juz',
                category: 'Pesantren Terpadu',
                badge: 'Kecocokan 99%',
                description: 'Bimbingan hafalan Al-Qur\'an terstruktur bersanad mutqin di lingkungan Pondok Pesantren Qomaruddin. Dilengkapi kurikulum akademik fleksibel sehingga hafalan tuntas dan akademik tetap cemerlang.',
                highlights: ['Bimbingan Asatidz Huffadz Bersanad', 'Wisuda Syahadah Tahfidz Akbar', 'Beasiswa Bebas SPP Santri Berprestasi', 'Target Mutqin 30 Juz & Sanad Qira\'ah'],
                actionUrl: 'https://wa.me/6281234567890?text=Assalamualaikum,%20saya%20tertarik%20dengan%20Program%20Tahfidzul%20Quran%20MA%20Assaadah%20setelah%20simulasi%20SPMB.'
            }
        },

        open() {
            this.isOpen = true;
            this.step = 1;
            this.scores = { mipa: 0, ips: 0, keagamaan: 0, tahfidz: 0 };
            this.result = null;
            if (createIcons && icons) setTimeout(() => createIcons({ icons }), 50);
        },

        close() {
            this.isOpen = false;
        },

        chooseOption(prog) {
            this.scores[prog] = (this.scores[prog] || 0) + 1;
            if (this.step < this.totalSteps) {
                this.step++;
                if (createIcons && icons) setTimeout(() => createIcons({ icons }), 50);
            } else {
                this.calculateResult();
            }
        },

        calculateResult() {
            let maxProg = 'keagamaan';
            let maxVal = -1;
            for (const [k, v] of Object.entries(this.scores)) {
                if (v > maxVal) {
                    maxVal = v;
                    maxProg = k;
                }
            }
            this.result = this.programDetails[maxProg];
            if (createIcons && icons) setTimeout(() => createIcons({ icons }), 50);

            // Celebration Particle Physics
            if (typeof confetti === 'function' && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                confetti({
                    particleCount: 90,
                    spread: 75,
                    origin: { y: 0.6 },
                    colors: ['#00923F', '#006437', '#FFF500', '#75C5F0', '#ffffff']
                });
            }
        },

        reset() {
            this.step = 1;
            this.scores = { mipa: 0, ips: 0, keagamaan: 0, tahfidz: 0 };
            this.result = null;
            if (createIcons && icons) setTimeout(() => createIcons({ icons }), 50);
        }
    });

    // 3. Command Palette Store (Ctrl+K)
    Alpine.store('cmdPalette', {
        isOpen: false,
        searchQuery: '',
        items: [
            { title: 'Beranda Madrasah', url: '/', category: 'Halaman Utama', icon: 'home' },
            { title: 'Tentang MA Ma\'arif NU Assa\'adah', url: '/profil', category: 'Profil', icon: 'school' },
            { title: 'Sejarah Pesantren Qomaruddin & Madrasah (1972)', url: '/profil/sejarah', category: 'Profil', icon: 'history' },
            { title: 'Visi, Misi & Karakter Pesantren', url: '/profil/visi-misi', category: 'Profil', icon: 'target' },
            { title: 'Sambutan Kepala Madrasah', url: '/profil/sambutan-kepala', category: 'Profil', icon: 'user' },
            { title: 'Struktur Organisasi Pimpinan', url: '/profil/struktur-organisasi', category: 'Profil', icon: 'network' },
            { title: 'Direktori Guru & Tenaga Kependidikan', url: '/guru', category: 'Pendidik', icon: 'users' },
            { title: 'Sarana & Prasarana Madrasah', url: '/fasilitas', category: 'Fasilitas', icon: 'building' },
            { title: 'Program Pendidikan & Peminatan', url: '/program', category: 'Akademik', icon: 'graduation-cap' },
            { title: 'Program Unggulan Tahfidz & Riset', url: '/program/unggulan', category: 'Akademik', icon: 'sparkles' },
            { title: 'Kurikulum Merdeka Terintegrasi Turats', url: '/akademik/kurikulum', category: 'Akademik', icon: 'book' },
            { title: 'Kalender Akademik 2026/2027', url: '/akademik/kalender', category: 'Akademik', icon: 'calendar' },
            { title: 'Prestasi Santri & Madrasah', url: '/prestasi', category: 'Prestasi', icon: 'trophy' },
            { title: 'Ekstrakurikuler Santri', url: '/kesiswaan/ekstrakurikuler', category: 'Kesiswaan', icon: 'activity' },
            { title: 'Organisasi Siswa (OSIM, IPNU, IPPNU, MPK)', url: '/kesiswaan/organisasi', category: 'Kesiswaan', icon: 'flag' },
            { title: 'Berita Terbaru Madrasah', url: '/berita', category: 'Informasi', icon: 'newspaper' },
            { title: 'Pendaftaran SPMB Online (Lynk.id)', url: 'https://lynk.id/spmb-madah', category: 'SPMB', icon: 'sparkles' },
            { title: 'Pengumuman Resmi SPMB', url: '/pengumuman', category: 'Informasi', icon: 'megaphone' },
            { title: 'Agenda & Kegiatan Mendatang', url: '/agenda', category: 'Informasi', icon: 'clock' },
            { title: 'Artikel & Khazanah Islam', url: '/artikel', category: 'Literasi', icon: 'file-text' },
            { title: 'Galeri Foto Kegiatan', url: '/galeri/foto', category: 'Media', icon: 'image' },
            { title: 'Galeri Video Dokumentasi', url: '/galeri/video', category: 'Media', icon: 'video' },
            { title: 'Direktori Alumni IKBAL MADAH', url: '/alumni', category: 'Alumni', icon: 'award' },
            { title: 'Registrasi Alumni Baru', url: '/alumni/registrasi', category: 'Alumni', icon: 'user-plus' },
            { title: 'Pusat Unduhan & Dokumen SPMB', url: '/download', category: 'Dokumen', icon: 'download' },
            { title: 'Kontak & Lokasi Madrasah Bungah', url: '/kontak', category: 'Kontak', icon: 'map-pin' },
        ],

        get filteredItems() {
            if (!this.searchQuery.trim()) return this.items.slice(0, 10);
            const q = this.searchQuery.toLowerCase();
            return this.items.filter(item =>
                item.title.toLowerCase().includes(q) ||
                item.category.toLowerCase().includes(q)
            );
        },

        open() {
            this.isOpen = true;
            this.searchQuery = '';
            setTimeout(() => {
                const el = document.getElementById('cmd-palette-input');
                if (el) el.focus();
                if (createIcons && icons) createIcons({ icons });
            }, 50);
        },

        close() {
            this.isOpen = false;
        }
    });

    // 4. Audio Player Store (Mars & Murottal)
    Alpine.store('audioPlayer', {
        isPlaying: false,
        isOpen: false,
        currentTrackIndex: 0,
        volume: 0.8,
        tracks: [
            {
                title: 'Mars Ma\'arif Nahdlatul Ulama',
                subtitle: 'Lembaga Pendidikan Ma\'arif NU',
                category: 'Mars Organisasi'
            },
            {
                title: 'Mars Santri MA Assa\'adah Bungah',
                subtitle: 'Himne Kebanggaan Santri Qomaruddin',
                category: 'Mars Madrasah'
            },
            {
                title: 'Lantunan Ayat Suci Al-Qur\'an',
                subtitle: 'Tilawah Tartil Santri Tahfidz Assa\'adah',
                category: 'Murottal'
            }
        ],

        togglePlay() {
            this.isPlaying = !this.isPlaying;
        },

        nextTrack() {
            this.currentTrackIndex = (this.currentTrackIndex + 1) % this.tracks.length;
            this.isPlaying = true;
        },

        prevTrack() {
            this.currentTrackIndex = (this.currentTrackIndex - 1 + this.tracks.length) % this.tracks.length;
            this.isPlaying = true;
        },

        get currentTrack() {
            return this.tracks[this.currentTrackIndex];
        }
    });

    // 5. Accessibility Controls
    Alpine.store('accessibility', {
        isLargeFont: false,
        toggleFontSize() {
            this.isLargeFont = !this.isLargeFont;
            if (this.isLargeFont) {
                document.documentElement.classList.add('text-lg');
            } else {
                document.documentElement.classList.remove('text-lg');
            }
        }
    });

    // Global Key Listener for Ctrl+K / Cmd+K
    window.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const store = Alpine.store('cmdPalette');
            if (store.isOpen) {
                store.close();
            } else {
                store.open();
            }
        }
    });

    // Overpowered Interaction 1: Dynamic Spotlight Border Cursor Tracker (Linear/Vercel Style)
    if (typeof window !== 'undefined' && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.spotlight-card, .interactive-card');
            cards.forEach((card) => {
                const rect = card.getBoundingClientRect();
                if (
                    e.clientX >= rect.left - 40 &&
                    e.clientX <= rect.right + 40 &&
                    e.clientY >= rect.top - 40 &&
                    e.clientY <= rect.bottom + 40
                ) {
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    card.style.setProperty('--mouse-x', `${x}px`);
                    card.style.setProperty('--mouse-y', `${y}px`);
                }
            });
        }, { passive: true });

        // Overpowered Interaction 2: Naturalistic 3D Tilt Cards (Tim Quirino Style)
        document.addEventListener('mouseover', (e) => {
            const tiltTarget = e.target.closest('[data-tilt]');
            if (!tiltTarget || tiltTarget._hasTiltListener) return;
            tiltTarget._hasTiltListener = true;

            tiltTarget.addEventListener('mousemove', (evt) => {
                const rect = tiltTarget.getBoundingClientRect();
                const x = evt.clientX - rect.left - rect.width / 2;
                const y = evt.clientY - rect.top - rect.height / 2;
                const rotX = -(y / (rect.height / 2)) * 6;
                const rotY = (x / (rect.width / 2)) * 6;
                tiltTarget.style.transform = `perspective(800px) rotateX(${rotX.toFixed(2)}deg) rotateY(${rotY.toFixed(2)}deg) scale3d(1.02, 1.02, 1.02)`;
            }, { passive: true });

            tiltTarget.addEventListener('mouseleave', () => {
                tiltTarget.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            });
        });

        // Overpowered Interaction 3: Staggered Scroll Reveal (Tellet Style)
        if ('IntersectionObserver' in window) {
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('reveal-active');
                        revealObserver.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            const observeReveals = () => {
                document.querySelectorAll('.reveal-init:not(.reveal-active)').forEach((el) => {
                    revealObserver.observe(el);
                });
            };

            observeReveals();
            window.addEventListener('load', observeReveals);
        }
    }
}

