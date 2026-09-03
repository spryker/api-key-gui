/**
 * Copyright (c) 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

'use strict';

$(document).ready(function () {
    const validTo = $('#api-key_valid_to');

    // From spryker/gui 5.4.0 on, this field is built with `DatePickerType`, which marks it with
    // `data-spryker-picker` and lets the Gui DateTimePicker initialize it. Older Gui versions have
    // no such type, so the legacy picker below is set up instead.
    if (validTo.is('[data-spryker-picker]')) {
        return;
    }

    validTo.datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        numberOfMonths: 3,
        defaultDate: '+1d',
        minDate: '+1d',
    });
});
