import './bootstrap';
import { initFlowbite } from 'flowbite';

document.addEventListener('DOMContentLoaded', function () {
    initFlowbite();
});

document.addEventListener('livewire:navigated', function () {
    initFlowbite();
});