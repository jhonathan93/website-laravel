import './bootstrap';
import utils from './components/fn.js';

window.__initAppUtils = function() {
    if (!document.utils) {
        Object.defineProperty(document, 'utils', {
            value: utils,
            writable: false,
            configurable: false
        });
    }
};

document.addEventListener('DOMContentLoaded', () => {
    window.__initAppUtils();

    document.utils.initDynamicObserver('#alert-message', (element) => document.utils.autoClose(element));

    document.utils.initDynamicObserver('input[data-mask]', (element) => document.utils.applyInputMasks(element));
});
