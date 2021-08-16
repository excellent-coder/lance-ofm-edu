require('../bootstrap');

import { createApp } from 'vue';

import router from '../routes';
import {store }from '../store/apps/user';

// impoering componenets
import App from '../components/App.vue';
import Modal from "../components/Auth/Modal.vue";
import Login from "../components/Auth/Login.vue";
import SignUp from '../components/Auth/Signup.vue';
import ResetPassword from '../components/Auth/ResetPassword.vue';
import CarouselSlide from '../components/utils/CarouselSlide.vue';

import MultiSelect from '../npm/vue-multiselect/src';


const app = createApp({
    components: {
        App,
        Modal,
        Login,
        SignUp,
        ResetPassword
    },
    data() {
        return {
            form:{}
        }
    },
    methods: {
        toggleNav(id) {
                let nav = document.getElementById(id);
            if(nav.classList.contains('show')){
                nav.classList.remove('show');
            } else{
                nav.classList.add('show');
            }
        },

        submit(event) {
            let form = event.target;
            let url = form.getAttribute('action');
             isLoading();

            // generate form data
            let formData = new FormData(form);
            formData.append('device', navigator.userAgent);
            // upload formdata using axios
            // show upload progress
            axios.post(url, formData).then(res => {
                if (res.data.type == 'success') {
                    form.reset();
                }
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

        showPass($event, id) {
            let btn = $event.currentTarget;
            let pass = document.getElementById(id + '-password');
            if (!pass) {
                return;
            }
            console.log(pass.type)
            if (pass.type == 'password') {
                btn.querySelector('.fa-eye').style.display = 'inline';
                btn.querySelector('.fa-eye-slash').style.display = 'none';
                pass.type = 'text';
            } else {
                pass.type = 'password'
                btn.querySelector('.fa-eye').style.display = 'none';
                btn.querySelector('.fa-eye-slash').style.display = 'inline';
            }
        }

    }
});
app.use(store);
app.use(router);
// register global components
app.component('CarouselSlide', CarouselSlide)
app.component('MultiSelect',MultiSelect)


const vm = app.mount('#app')
isLoading(false);

var prevScrollpos = window.pageYOffset;
var cdtop = document.getElementById('scroll-to-top');


// new Splide("#splide", {
//     type: "loop",
//     perPage: 1,
//     autoplay: true,
//     pauseOnHover: false,
// }).mount();

if(cdtop){

    window.addEventListener('scroll', () => {
        var currentScrollPos = window.pageYOffset;
        cdtop.style.display = 'none';

        if (window.pageYOffset > 300) {
            cdtop.style.display = 'block';
        }

    if (prevScrollpos < currentScrollPos) {
        document.getElementById("main-nav").classList.add('hide');
        document.getElementById("navbar").classList.add('hide');
    } else {
        document.getElementById("main-nav").classList.remove('hide');
    }
    prevScrollpos = currentScrollPos;
    });

    cdtop.addEventListener('click', () => {
        return window.scroll({ top: 0, left: 0, behavior: 'smooth' });
    });
}
