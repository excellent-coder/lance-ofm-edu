require('../bootstrap');

import {
    createApp
} from 'vue';

import router from '../routes';
import {
    store
} from '../store/apps/portal';

// importing componenets
import MultiSelect from '../npm/vue-multiselect/src';
import productTag from '../components/shop/productTag.vue';
import AddCartBtn from '../components/shop/AddCartBtn.vue';
import ImageTag from '../components/utils/ImageTag.vue';
import Modal from "../components/Auth/Modal.vue";
import {
    onMounted,
    ref,
    toRef
} from "vue";
import {
    isLoading
} from '../utils/validate';
// import axios from 'axios';

const app = createApp({
    setup() {
        const form = ref({});
        return {
            form
        }
    },

    data() {
        return {
            item: '',
        }
    },

    methods: {
        toggleNav(id) {
            let nav = document.getElementById(id);
            if (nav.classList.contains('show')) {
                nav.classList.remove('show');
            } else {
                nav.classList.add('show');
            }
        },

        submit(event) {
            let form = event.target;
            let url = form.getAttribute('action');

            // start loading animation
            isLoading();
            let formData = new FormData(form);

            // upload formdata using axios
            // show upload progress
            this.axiosSubmit(url, formData);
        },

        axiosSubmit(url, formData) {
            axios.post(url, formData).then(res => {
                return this.processResponse(res.data);
            }).catch(err => {
                console.log(err);
                if (err.response) {
                    return this.processResponse(err.response.data);
                }
                isLoading(false);
                notify({
                    title: 'something went wrong'
                }, {
                    type: 'danger',
                    timeout: 20000
                });
            });
        },

        processResponse(data) {
            let type = data.type;
            let title = data.message;
            let description = data.desc;
            let timeout = data.timeout;

            if (data.status == 200) {

                notify({
                    title,
                    description
                }, {
                    type,
                    timeout
                });

                if (data.to) {
                    window.location.href = data.to;
                    return;
                }

                if (data.reload) {
                    window.location.reload()
                    return
                }
            }

            if (data.errors) {
                let errors;
                title = title ? title : 'You have some errors';
                type = 'danger';

                switch (typeof data.errors) {
                    case 'object':
                        errors = Object.values(data.errors);
                        description = '';
                        errors.forEach(e => {
                            description += `* ${e}`;
                        });
                        break
                    default:
                        description = data.errors;
                        break;
                }

                notify({
                    title,
                    description
                }, {
                    type,
                    timeout
                });
            }

            return isLoading(false);
        },

        addCart(id, total = 1) {
            let f = new FormData();
            f.app('total', total);
            return this.axiosSubmit('/shop/carts/store/' + id, f);
        },
        fullImage(src) {
            this.$store.commit('modal', 'shop-imgs');
            document.getElementById('shop-modal-img').src = src;
        }
    },
    mounted() {
        isLoading(false);
    },

    watch: {
        item(newValue) {
            console.log(newValue);
        }
    }
});

app.component('MultiSelect',MultiSelect)
app.component('productTag',productTag)
app.component('AddCartBtn', AddCartBtn);
app.component('ImageTag', ImageTag);
app.component('Modal', Modal);

app.use(store);
app.use(router);

window.Vm = app;

app.mount('#shop')
