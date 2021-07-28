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
import axios from 'axios';

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
            bid:""
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

        submit(event, files=[]) {
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
                let { data } = res;
                if (data.status == 200) {
                    showToast(data.message, 'success', data.desc?data.desc:'');
                    isLoading(false);
                    if(data.to){
                        window.location.href = data.to;
                        return;
                    }
                    window.location.reload();
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
                    let desc = '';
                    errors.forEach(item => {
                        desc += `* ${item}`;
                    });
                    // ret
                    showToast(data.message?data.message:'You have some errors',
                        'error',
                        desc
                    );
                }

            }).catch(err => {
                console.log(err);
                isLoading(false);
                showToast('Something went wrong', 'error');
            });
        },

        placeBid(amount, url) {
            let formData = new FormData();
            formData.append('amount', amount);
            return this.axiosSubmit(url, formData);
        }
    }
});
app.use(store);
app.use(router);

// router.afterEach((to, from, failure) => {
//     store.dispatch('bindJQPkgs');
// })
// app.use()

// store.commit('increment');
const vm = app.mount('#app')
isLoading(false);

var prevScrollpos = window.pageYOffset;
window.addEventListener('scroll', () => {
  var currentScrollPos = window.pageYOffset;
  if (prevScrollpos > currentScrollPos) {
    document.getElementById("main-nav").classList.remove('hide');
  } else {
      document.getElementById("main-nav").classList.add('hide');
      document.getElementById("navbar").classList.add('hide');
  }
  prevScrollpos = currentScrollPos;
});

// new Splide("#splide", {
//     type: "loop",
//     perPage: 1,
//     autoplay: true,
//     pauseOnHover: false,
// }).mount();
