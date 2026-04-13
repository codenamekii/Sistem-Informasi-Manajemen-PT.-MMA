import './bootstrap';
import Alpine from 'alpinejs';
import { initFlowbite } from 'flowbite';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    initFlowbite();
});

document.addEventListener('livewire:navigated', function () {
    initFlowbite();
});