export const authStore = {
    namespaced:true,
    state: {
        email: "",
        password: "",
        remember:false
    },
    mutations: {
        set: (state, payload) => {
            let keys = Object.keys(payload);
            keys.forEach(item => {
                state[item] = payload[item];
            })
        },
    },
    getters: {},
    actions: {
        set({ commit }, payload) {
            commit('set', payload);
        },
        submit({ commit, state }, url) {

            let f = new FormData();
            f.append("email", state.email);
            f.append("password", state.password);
            if (state.remember) {
                f.append('remember', 1);
            }
            axios
                .post(url, f)
                .then((res) => {
                    let data = res.data;
                    if (data.status == 200) {
                        notify({ title: data.message });
                    }

                    if (data.errors) {
                        notify({ title: data.message, description:data.errors }, { type: 'error' });
                    }

                    if (data.to) {
                        window.location.href = data.to;
                    }
                })
                .catch((error) => {
                    notify({ title: 'something went wrong' }, { type: 'error' });
                });
        }
    }
}
