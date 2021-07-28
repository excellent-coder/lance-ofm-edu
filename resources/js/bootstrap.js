window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// pacejs;
require('pace-js');

import splide from '@splidejs/splide';
window.Splide = splide;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// toaster
import { createToast } from 'mosha-vue-toastify';
import 'mosha-vue-toastify/dist/style.css'
// sweet alert
window.Swal = require('sweetalert2');

window.notify = (main, minor={}) => {
    if (minor.type == 'error') {
        minor.type = 'danger'
    }
    main = Object.assign({ title: "", description: "" }, main);

    for (let k in minor) {
    if (!minor[k]) {
      delete minor[k];
    }
    }
    minor = Object.assign({
        type: "default",
        position: "top-right",
        timeout: 60*60*60*5,
        transition: "zoom",
        showIcon:"true"
    }, minor);

    return createToast(main, minor);
}


import { requiredFilled, isLoading, handleModal } from './utils/validate';
import {toggleDisabled, oldValues, totalSelected } from './utils/elements';
window.requiredFilled = requiredFilled;
window.isLoading = isLoading;
window.handleModal = handleModal;
window.toggleDisabled = toggleDisabled;
window.oldValues = oldValues;
window.totalSelected = totalSelected;


