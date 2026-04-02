define('custom:views/fields/postal-code', ['views/fields/varchar'], function (Dep) {
    return class extends Dep {
        afterRender() {
            super.afterRender();

            if (this.mode !== 'edit' && this.mode !== 'editSmall') {
                return;
            }

            const input = this.$element.get(0);

            if (!input) {
                return;
            }

            input.setAttribute('inputmode', 'numeric');
            input.setAttribute('maxlength', '5');
            input.setAttribute('pattern', '[0-9]{5}');

            const sanitize = () => {
                const sanitized = (input.value || '').replace(/\D+/g, '').slice(0, 5);

                if (sanitized !== input.value) {
                    input.value = sanitized;
                }
            };

            this.listenTo(this, 'change', sanitize);
            this.$element.on('input.postalCode', sanitize);
            this.$element.on('paste.postalCode', () => setTimeout(sanitize, 0));
        }

        fetch() {
            const data = super.fetch();

            if (this.name in data) {
                data[this.name] = (data[this.name] || '').replace(/\D+/g, '').slice(0, 5);
            }

            return data;
        }
    };
});
