import './bootstrap';
import Alpine from 'alpinejs';
import intersect from '@alpinejs/intersect';
import confetti from 'canvas-confetti';
import { createIcons, icons } from 'lucide';
import { initIslamicHub } from './islamic-hub';

Alpine.plugin(intersect);

window.Alpine = Alpine;
window.confetti = confetti;
window.refreshIcons = () => createIcons({ icons });

// Initialize Islamic Hub stores, calculators & physics animations
initIslamicHub(Alpine, createIcons, icons, confetti);

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});


