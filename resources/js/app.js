// Wir laden nur Bootstrap/Axios für eventuelle AJAX-Aufrufe.
import './bootstrap.js';

// WIR IMPORTIEREN ODER STARTEN ALPINE HIER NICHT MEHR.

// =======================================================
// WIR IMPORTIEREN NUR NOCH DIE BIBLIOTHEKEN,
// DAMIT SIE GLOBAL VERFÜGBAR SIND.
// =======================================================
import Swiper from 'swiper';
import Cropper from 'cropperjs';
import * as FilePond from 'filepond';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';

// Mache die Objekte im globalen 'window'-Objekt verfügbar,
// damit unsere seitenspezifischen Skripte in den Blade-Dateien sie finden können.
window.Swiper = Swiper;
window.Cropper = Cropper;
window.FilePond = FilePond;
window.FilePondPluginImagePreview = FilePondPluginImagePreview;
window.FilePondPluginFileValidateType = FilePondPluginFileValidateType;
window.Tiptap = { Core: { Editor }, StarterKit };