define('custom:views/fields/date', ['views/fields/date', 'moment'], function (Dep, moment) {
    return class extends Dep {
        convertDateValueForDetail(value) {
            if (this.useNumericFormat) {
                return this.getDateTime().toDisplayDate(value);
            }

            const timeZone = this.getDateTime().getTimeZone();
            const internalFormat = this.getDateTime().internalDateTimeFormat;
            const readableFormat = this.getDateTime().getReadableDateFormat();
            const dateTimeValue = value + ' 00:00:00';

            const now = moment.tz(timeZone).startOf('day');
            const currentYear = now.format('YYYY');
            const date = moment.utc(dateTimeValue, internalFormat);

            if (!date.isValid()) {
                return this.getDateTime().toDisplayDate(value);
            }

            return date.format(readableFormat + ', YYYY');
        }
    };
});
