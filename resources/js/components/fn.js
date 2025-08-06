function isValidSelector(selector) {
    return /^[a-zA-Z0-9\-_#\.,\s\[\]="']+$/.test(selector);
}
export default {
    /**
     * Configura fechamento automático para elementos
     * @param {string|HTMLElement} target - Seletor CSS ou elemento DOM
     * @param {number} delay - Tempo em milissegundos (opcional, padrão: 5000)
     */
    autoClose: (target, delay = 3000) => {
        const element = typeof target === 'string' ? document.querySelector(target) : target;

        if (!element) {
            console.warn('Elemento não encontrado:', target);
            return;
        }

        setTimeout(() => {
            element.classList.add('fade-out');
            setTimeout(() => element.remove(), 300);
        }, delay);
    },

    /**
     * Registra um MutationObserver para um elemento específico com um callback personalizado
     * @param {string} targetSelector - Seletor do elemento a ser observado (ex: "#alert-message")
     * @param {function} callback - Função a ser executada quando o elemento for detectado
     * @param {object} observerOptions - Opções do MutationObserver (opcional)
     */
    initDynamicObserver: (targetSelector, callback, observerOptions = { childList: true, subtree: true }) => {
        if (!isValidSelector(targetSelector)) throw new Error('Invalid selector');

        if (typeof callback !== 'function') throw new Error('Callback must be a function');

        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                mutation.addedNodes.forEach((node) => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        try {
                            const element = node.matches(targetSelector) ? node : node.querySelector(targetSelector);
                            if (element) setTimeout(() => callback(element), 0);
                        } catch (e) {
                            console.error('Security error:', e);
                        }
                    }
                });
            });
        });

        const container = document.querySelector('#dynamic-content-container') || document.body;
        observer.observe(container, observerOptions);

        const existingElement = targetSelector.startsWith('#') ? document.getElementById(targetSelector.slice(1)) : document.querySelector(targetSelector);

        if (existingElement) callback(existingElement);

        return {
            observer,
            disconnect: () => observer.disconnect()
        };
    }
}
