import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import.meta.glob([
    '../vendor/laravel/jetstream/**/*.js',
    '../vendor/laravel/jetstream/**/*.jsx',
    '../vendor/laravel/jetstream/**/*.vue',
    '../vendor/laravel/jetstream/**/*.tsx',
]);

window.Vue = require('vue');
