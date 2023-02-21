require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import swal from 'sweetalert2';
window.Swal = swal;

import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor';
var ready = (callback) => {
    if (document.readyState != "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {
    ClassicEditor
        .create(document.querySelector('.ck'))
        .catch(error => {
            console.log(`error`, error)
        });
});

const {Dropzone} = require("dropzone");
import '@fortawesome/fontawesome-free/js/fontawesome'
import '@fortawesome/fontawesome-free/js/solid'
import '@fortawesome/fontawesome-free/js/regular'
import '@fortawesome/fontawesome-free/js/brands'
import 'glider-js/glider.min'
window.$ = window.jQuery = require('jquery');
import 'flexslider/jquery.flexslider-min'
import 'flexslider/flexslider.css';
var flatpickr = require("flatpickr");
require("flatpickr/dist/flatpickr.min.css");


