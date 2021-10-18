require('../bootstrap');

import { createApp } from 'vue';

import router from '../routes';
import {store }from '../store/apps/portal';

// importing componenets
import UInput from '../components/utils/UInput.vue';
import UButton from '../components/utils/UButton.vue';
import MultiSelect from '../npm/vue-multiselect/src';
import { onMounted, ref, toRef } from "vue";
// import axios from 'axios';
import { makePayment } from '../utils/payment';
import axios from '../../../node_modules/axios/index';
import Modal from "../components/Auth/Modal.vue";
import { isLoading } from '../utils/validate';



const app = createApp({
    setup() {
        const selected = ($event, item) => {
            switch (item) {
                case 'country':
                    getStates($event.id);
                    form.value.country_id = $event.id
                    form.value.state_id = '';
                    state.value = null;
                    break;
                case 'state':
                    form.value.state_id = $event.id;
                    break;
            }

            console.log(form.value);

        }
        const removed = (item) => {
            switch (item) {
                case 'country':
                    form.country_id = '';
                    form.value.state_id = '';
                    state.value = null;
                    break;
                case 'state':
                    form.state_id = '';
                    break;
            }
        }

        const country = ref(null);
        const state = ref(null);
        const isEditing = ref(null);

        const countries = ref([]);
        const states = ref([]);

        const form = ref({});
          const countryLabel = ({ iso2, name }) => {
            return `<img class="inline" src="/storage/web/flags/PNG-32/${iso2}-32.png"/>&nbsp; ${name}`;
          };
          const stateLabel = ({ name }) => {
            return name;
          };
          const cityLabel = ({  name }) => {
            return name;
          };

          const getCountries = () => {
            axios
                .get("/api/address/countries")
                .then((res) => {
                    isEditing.value = true;
                    return (countries.value = res.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        const getStates = (countryId) => {
            axios
                .get(`/api/address/countries/${countryId}`)
                .then((res) => {
                    return (states.value = res.data);
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        const editPage = (editing=false) => {
            if (editing) {
                if (isEditing.value) {
                    isEditing.value = false;
                    return
                }

                if (countries.value.length > 100) {
                    isEditing.value = true;
                    return;
                }
                getStates(form.value.country_id);
                return getCountries();

            }
            axios.get('/portal/profile/status').then(res => {
                if (res.data.profile != 1) {
                    return getCountries();
                }
                state.value = res.data.state;
                form.value.state_id = res.data.state.id;
                country.value = res.data.country;
                form.value.country_id = res.data.country.id;
            })
        }
        onMounted(() => {
            if (window.location.href.includes('profile/edit')) {
                editPage();
            }
            // getCountries();
        });

        return {
            countryLabel,
            stateLabel,

            editPage,
            // address array
            countries,
            states,

            form,

            // selected
            country,
            state,

            // select events
            selected,
            removed,
            isEditing



        }
    },
    components: {
        UInput,
        MultiSelect,
        UButton
    },
    data() {
        return {
            item: '',
            form:{}
        }
    },
    computed: {
      greeting() {
            let hour = new Date().getHours();
            if (hour < 12) {
                return "Morning";
            } else if (hour < 16) {
                return "Afternoon";
            } else {
                return "Evening";
            }
        },
    },
    methods: {
         toggleNav(id) {
            let nav = document.getElementById(id);
            if(nav.classList.contains('show')){
                nav.classList.remove('show');
                // nav.classList.add('block');
            } else{
                nav.classList.add('show');
                // nav.classList.remove('block');
            }
        },

        submit(event) {
            let form = event.target;
               let url = form.getAttribute('action');

            //validate all required fields
            // if(!requiredFilled(form)){
            //     return;
            // }
            // start loading animation
            isLoading();
            let formData = new FormData(form);

            // upload formdata using axios
            // show upload progress
              this.axiosSubmit(url, formData);
        },

        axiosSubmit(url, formData) {
             isLoading();
            axios.post(url, formData).then(res => {
                return this.processResponse(res.data);
            }).catch(err => {
               console.log(err);
                if (err.response && err.response.status<500) {
                  return  this.processResponse(err.response.data);
                }
                isLoading(false);
                notify({ title: 'something went wrong' }, { 'type': 'danger' });
            });
        },
         processResponse(data) {
            isLoading(false);
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

                if (data.payment) {
                    console.log('making payment')
                    let p = data.payment;
                    makePayment(
                        p.public_key,
                        p.ref,
                        p.amount,
                        p.currency,
                        p.country,
                        p.redirect,
                        p.meta,
                        p.customer,
                        p.customization
                    );
                    return;
                }
                if (data.to) {
                    window.location.href = data.to;
                }

                if (data.reload) {
                    window.location.reload()
                }

                return;
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
                return;
            }

            if (data.message) {
                notify(
                    { title: data.message },
                    {
                        type: data.type ? data.type : 'info',
                        timeout: data.timeout?data.timeout: 60* 60 * 60
                    }
                );
            }

            return
        },

        updatePassport(event, url) {
            let passport = event.target.files[0]
            if (!passport) {
                return;
            }
            this.form.passport = URL.createObjectURL(passport)
            let data = new FormData();
            data.append('passport', passport);
            axios.post(url, data).then(res => {
                return this.processResponse(res.data);
            }).catch(err => {
               console.log(err);
                if (err.response && err.response.status<500) {
                  return  this.processResponse(err.response.data);
                }
                notify({ title: 'something went wrong' }, { 'type': 'danger' });
            });
        },

        memberPayment(bill) {
            handleModal(`payment-modal`, true);
            return;
        },

        purchaseLicense(event, data, currency) {
              Swal.fire({
                title:`Apply For ${data.name} License`,
                icon: 'info',
                  html: `<span>You will be prompted to make payment of <b> ${currency} ${data.fee} </b>
                       Once you click continue, This is
                        the price for this license</span>
                        <p><b>Duration: </b>${data.duration} Year${data.duration>1?'s':''}</p>
                        <p><b>Renewal Fee after ${data.duration} Year${data.duration>1?'s':''}: </b> ${currency} ${data.renewal}</p>
                        `,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Continue',
            }).then(result => {
                if (result.isConfirmed) {
                    isLoading(1)
                    axios.post(event.target.href).then(res => {
                         return this.processResponse(res.data);
                    }).catch(err => {
                       console.log(err);
                        if (err.response && err.response.status<500) {
                          return  this.processResponse(err.response.data);
                        }
                        isLoading(false);
                        notify({ title: 'something went wrong' }, { 'type': 'danger' });
                    });
                }
            });


        },
        scsProgram(event, data, currency) {
              Swal.fire({
                title:`Apply For ${data.title} program`,
                icon: 'info',
                  html: `<span>You will be prompted to make payment of <b> ${currency} ${data.scs_app_fee} </b>
                       Once you click continue, This is
                        the price for this Program</span>
                        `,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: 'Continue',
            }).then(result => {
                if (result.isConfirmed) {
                    isLoading(1)
                    axios.post(event.target.href).then(res => {
                         return this.processResponse(res.data);
                    }).catch(err => {
                       console.log(err);
                        if (err.response && err.response.status<500) {
                          return  this.processResponse(err.response.data);
                        }
                        isLoading(false);
                        notify({ title: 'something went wrong' }, { 'type': 'danger' });
                    });
                }
            });


        }
    },
    mounted() {
        var treeNav = document.querySelector('#portal-sidebar')
    .querySelectorAll('.has-children');

// console.log(treeNav);

treeNav.forEach(item => {
    item.addEventListener('click', (e) => {
        if (!e.target.closest('.nav-children')) {
            e.preventDefault();
        if (item.classList.contains('open')) {
            item.classList.remove('open');
            return;
        } else {
            item.classList.add('open');
       }
        }
   })
});

    },
    watch: {
        item(newValue) {
            console.log(newValue);
        }
    }
});
app.use(store);
app.use(router);

app.component('Modal', Modal);


// router.afterEach((to, from, failure) => {
//     store.dispatch('bindJQPkgs');
// })
window.Vm = app;

app.mount('#portal')
isLoading(false);
