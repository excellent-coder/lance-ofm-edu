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
        }
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
                if (err.response) {
                  return  this.processResponse(err.response.data);
                }
                isLoading(false);
                notify({ title: 'something went wrong' }, { 'type': 'danger' });
            });
        },

        processResponse(data) {

              if (data.status == 200) {
                  notify({
                      title: data.message, description: data.desc
                  },{
                          type: 'success'
                      });
                  isLoading(false);

                    if(data.to){
                        window.location.href = data.to;
                        return;
                    }

                   data.reload?window.location.reload():'';
                    return;
              }

                if(data.to){
                    window.location.href = data.to;
                }
                isLoading(false);
                // return console.log(data);
                // let desc =
                if (data.errors) {
                    let errors = Object.values(data.errors);

                    let description = '';
                    let title =data.message?data.message:'You have some errors';
                    errors.forEach(item => {
                        description += `* ${item}`;
                    });
                    // ret
                  return  notify({title, description}, {type:'danger'});
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
            return false;
        },
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

// router.afterEach((to, from, failure) => {
//     store.dispatch('bindJQPkgs');
// })
window.Vm = app;

app.mount('#portal')
isLoading(false);
