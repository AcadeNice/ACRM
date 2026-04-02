define('custom:views/fields/siret', ['views/fields/varchar'], function (Dep) {
    return class extends Dep {
        formatValue(value) {
            const digits = (value || '').replace(/\D+/g, '').slice(0, 14);

            if (!digits) {
                return '';
            }

            const parts = [];

            if (digits.length > 0) {
                parts.push(digits.slice(0, 3));
            }

            if (digits.length > 3) {
                parts.push(digits.slice(3, 6));
            }

            if (digits.length > 6) {
                parts.push(digits.slice(6, 9));
            }

            if (digits.length > 9) {
                parts.push(digits.slice(9, 14));
            }

            return parts.join(' ');
        }

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
            input.setAttribute('maxlength', '17');
            input.setAttribute('pattern', '[0-9 ]{17}');

            const sanitize = () => {
                const formatted = this.formatValue(input.value);

                if (formatted !== input.value) {
                    input.value = formatted;
                }
            };

            sanitize();

            this.$element.on('input.siret', sanitize);
            this.$element.on('paste.siret', () => setTimeout(sanitize, 0));
        }

        fetch() {
            const data = super.fetch();

            if (this.name in data) {
                data[this.name] = (data[this.name] || '').replace(/\D+/g, '').slice(0, 14);
            }

            return data;
        }
    };
});
