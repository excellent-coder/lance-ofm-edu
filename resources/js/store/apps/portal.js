import {
    createStore
} from 'vuex';

import { authStore } from '../modules/user/auth';
import { flash } from '../modules/flash';
import { handleModal } from '../../utils/validate';

export const store = createStore({
    strict: process.env.NODE_ENV !== 'production',
    state() {
        return {
            loading:false,
        }
    },

    mutations: {
        setFirstName(state, payload) {
            state.firstName = payload.firstName;
        },

        set: (state, payload) => {
            let keys = Object.keys(payload);
            keys.forEach(item => {
                state[item] = payload[item];
            })
        },

        modal: (state, payload) => {
            handleModal(`${payload}-modal`, true);
        }
    },
    actions: {

        getData({ commit, state }, payload) {
            if (state[payload.item].length > 0) {
                return;
            }
            axios.get(payload.url).then((res) => {
                commit('getSData', {
                    item: payload.item,
                    data: res.data
                });
            }).catch(err => {
                console.error(err);
            });

        },

        bindJQPkgs({ commit, state}) {
            setTimeout(() => {

                //  let se
                $('.select2').select2();
                $('.dropify').dropify();
                $('.update-store').off('change');
                $(".update-store").on("change", function () {
                    let obj = {};
                    obj[$(this).attr("name")] = $(this).val();
                    console.log(obj);
                    commit("updateState", obj);
                });

            }, 1000);
        }

    },
    modules: {
        authStore,
        flash
    }
});
