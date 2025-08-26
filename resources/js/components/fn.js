import masks from "../libs/masks/masks.js";

/**
 * @param selector
 * @returns {boolean}
 */
const isValidSelector = (selector) => {
    try {
        document.createDocumentFragment().querySelector(selector);
        return true;
    } catch {
        return false;
    }
};

export default {

    /**
     * @param target
     * @param delay
     */
    autoClose: (target, delay = 3000) => {
        const element = typeof target === 'string' ? document.querySelector(target) : target;

        if (!element) {
            console.warn('Elemento não encontrado:', target);

            return;
        }

        if (!element.classList.contains('auto-closeable')) {
            console.warn('Tentativa de autoClose em elemento não autorizado:', element);

            return;
        }

        setTimeout(() => {
            element.classList.add('fade-out');
            setTimeout(() => element.remove(), 300);
        }, delay);
    },

    /**
     * @param inputElement
     */
    applyInputMasks: (inputElement) => {
        if (!(inputElement instanceof HTMLInputElement) || !inputElement.hasAttribute('data-mask')) return;

        const maskType = inputElement.getAttribute('data-mask');
        const maskFn = masks.maskDispatcher[maskType];

        if (!maskFn) {
            console.warn(`Tipo de máscara não suportado: ${maskType}`);

            return;
        }

        if (!inputElement.__app_maskApplied) {
            inputElement.addEventListener('keyup', maskFn, { passive: true });
            inputElement.__app_maskApplied = true;
        }

        if (inputElement.value) maskFn({ target: inputElement });
    },

    /**
     * @param targetSelector
     * @param callback
     * @param container
     * @param observerOptions
     * @returns {Readonly<{observer: MutationObserver, disconnect: (function(): void), reconnect: (function(): void)}>}
     */
    initDynamicObserver: (
        targetSelector,
        callback,
        {container = document.querySelector('#dynamic-content-container') || document.body, observerOptions = { childList: true, subtree: true }} = {}) =>
    {
        if (!targetSelector || typeof targetSelector !== 'string' || !isValidSelector(targetSelector)) throw new Error('Invalid selector');

        if (typeof callback !== 'function') throw new Error('Callback must be a function');

        const processed = new WeakSet();

        const runCallback = (element) => {
            if (processed.has(element)) return;
            processed.add(element);

            try {
                callback(element);
            } catch (err) {
                console.error('Callback error:', err);
            }
        };

        const observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                for (const node of mutation.addedNodes) {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        const elements = [];

                        if (node.matches?.(targetSelector)) elements.push(node);

                        elements.push(...node.querySelectorAll?.(targetSelector));

                        for (const el of elements) {
                            queueMicrotask(() => runCallback(el));
                        }
                    }
                }
            }
        });

        observer.observe(container, observerOptions);

        container.querySelectorAll(targetSelector).forEach((el) => runCallback(el));

        return Object.freeze({
            observer,
            disconnect: () => observer.disconnect(),
            reconnect: () => observer.observe(container, observerOptions),
        });
    }
};
