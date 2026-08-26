import './bootstrap';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import { initIslamicHub } from './islamic-hub';

window.Alpine = Alpine;
window.refreshIcons = () => createIcons({ icons });

// Initialize Islamic Hub stores and calculators
initIslamicHub(Alpine, createIcons, icons);

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

