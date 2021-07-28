import {
    createStore
} from 'vuex';


export const store = createStore({
    strict: process.env.NODE_ENV !== 'production',
    state() {
        return {
            hide_modal:false
        }
    },

    mutations: {


        set: (state, payload) => {
            console.log(state);
            let keys = Object.keys(payload);
            keys.forEach(item => {
                state[item] = payload[item];
            })
        },
    },
    actions: {},
    modules: {}
});
