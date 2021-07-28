export const flash = {
    namespaced: true,
    state: {
        msg: '',
        color: '',
        bgcolor:''
    },
    getters:{},
    mutations: {
        set: (state, payload) => {
            let keys = Object.keys(payload);
            keys.forEach(item => {
                state[item] = payload[item];
            })
        },
    },
    actions: {},

}
