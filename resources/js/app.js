import './bootstrap';
import utils from './components/fn.js';

window.__initAppUtils = function() {
    Object.defineProperty(document, 'utils', {
        value: utils,
        writable: false,
        configurable: false
    });
};

window.__initAppUtils();

document.addEventListener('DOMContentLoaded', window.__initAppUtils);

document.utils.initDynamicObserver('#alert-message', (element) => document.utils.autoClose(element));
