/**
 * Inject custom styling into the Google Maps Place Autocomplete web component.
 * The component renders inside a shadow DOM, so we intercept attachShadow
 * and append our Bootstrap-esque styles as soon as the shadow root exists.
 */
(function () {
    const originalAttachShadow = Element.prototype.attachShadow;
    const styledRoots = new WeakSet();
    const defer = typeof queueMicrotask === 'function'
        ? queueMicrotask
        : (callback) => Promise.resolve().then(callback);

    const styleByTag = {
        'gmp-place-autocomplete': `
            :host {
                display: block;
                width: 100%;
                font-family: inherit;
                border-radius: 0.375rem;
                padding: 0;
                background: inherit;
                box-shadow: 0 0 0 1px rgba(15, 40, 81, 0.38);
                transition: box-shadow 0.15s ease-in-out;
                position: relative;
            }

            :host(:hover) {
                box-shadow: 0 0 0 1px rgba(15, 40, 81, 0.55);
            }

            :host(:focus-within) {
                box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.45);
            }

            input {
                width: 100%;
                padding: 0.5rem 0.75rem;
                font: inherit;
                line-height: 1.5;
                border: 0;
                border-radius: 0.375rem;
                background: transparent;
                color: inherit;
                box-sizing: border-box;
            }

            input:focus,
            input:focus-visible,
            input::-moz-focus-inner {
                border: 0 !important;
                box-shadow: none !important;
                outline: 0 !important;
            }

            input::placeholder {
                color: #6c757d;
                opacity: 1;
            }

            .focus-ring {
                display: none !important;
            }
        `,
        'gmpx-dropdown': `
            :host {
                border-radius: 0.375rem;
                overflow: hidden;
                border: 1px solid rgba(15, 40, 81, 0.18);
                box-shadow: 0 0.5rem 1rem rgba(15, 40, 81, 0.15);
                background-color: inherit;
            }

            ul {
                margin: 0;
                padding: 0.5rem 0;
            }

            li {
                list-style: none;
                font: inherit;
            }

            button {
                width: 100%;
                text-align: left;
                padding: 0.5rem 0.75rem;
                font: inherit;
                color: inherit;
                background: transparent;
            }

            button:hover,
            button:focus-visible {
                background-color: rgba(13, 110, 253, 0.08);
                outline: none;
            }
        `
    };

    function injectStyles(tagName, shadowRoot) {
        if (!shadowRoot || styledRoots.has(shadowRoot)) {
            return;
        }

        const css = styleByTag[tagName];
        if (!css) {
            return;
        }

        const style = document.createElement('style');
        style.textContent = css;
        shadowRoot.appendChild(style);
        styledRoots.add(shadowRoot);
    }

    Element.prototype.attachShadow = function (init) {
        const shadowRoot = originalAttachShadow.call(this, init);
        const tagName = (this.tagName || '').toLowerCase();

        if (styleByTag[tagName]) {
            // Queue to allow any internal DOM to render first.
            defer(() => injectStyles(tagName, shadowRoot));
        }

        return shadowRoot;
    };

    function hydrateExistingElements(root = document) {
        Object.keys(styleByTag).forEach((selector) => {
            root.querySelectorAll(selector).forEach((element) => {
                if (element.shadowRoot) {
                    injectStyles(selector, element.shadowRoot);
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => hydrateExistingElements());
    } else {
        hydrateExistingElements();
    }
})();
