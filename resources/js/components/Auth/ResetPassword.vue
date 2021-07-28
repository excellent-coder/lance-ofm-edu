<template>
    <div class="w-full max-w-xs">
        <div>
            <h2
                v-if="msg"
                class="p-3"
                :style="{ backgroundColor: bgcolor, color: color }"
            >
                {{ msg }}
            </h2>
        </div>
        <form
            @submit.prevent="submit('/passowrd')"
            class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
        >
            <div class="mb-4">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="email"
                >
                    Email
                </label>
                <input
                    class="
                        shadow
                        appearance-none
                        border
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        leading-tight
                        focus:outline-none focus:shadow-outline
                    "
                    type="text"
                    placeholder="Email"
                    v-model="email"
                />
            </div>
            <div class="text-center">
                <button
                    class="
                        bg-blue-500
                        hover:bg-blue-700
                        text-white
                        font-bold
                        py-2
                        px-4
                        rounded
                        w-28
                        focus:outline-none focus:shadow-outline
                    "
                    type="submit"
                >
                    Reset
                </button>
            </div>
            <div class="text-left my-3">
                Have Your password?
                <button
                    class="
                        inline-block
                        align-baseline
                        font-bold
                        text-sm text-blue-500
                        hover:text-blue-800
                    "
                    @click.prevent="$store.commit('modal', 'login')"
                >
                    Login
                </button>
            </div>
            <div class="w-100 text-left mb-1">
                <span
                    >Don't Have an account
                    <button
                        class="btn text-blue-500 font-bold text-lg"
                        @click.prevent="$store.commit('modal', 'register')"
                    >
                        signup
                    </button></span
                >
            </div>
        </form>
        <p class="text-center text-gray-500 text-xs">
            &copy;2020 Acme Corp. All rights reserved.
        </p>
    </div>
</template>

<script>
import { mapState } from "vuex";

export default {
    computed: {
        email: {
            get() {
                return "";
                return this.$store.state.authStore.email;
            },
            set(value) {
                return this.$store.dispatch("authStore/set", { email: value });
            },
        },
        password: {
            get() {
                return "";
                return this.$store.state.authStore.password;
            },
            set(value) {
                return this.$store.dispatch("authStore/set", {
                    password: value,
                });
            },
        },
        ...mapState("flash", ["msg", "bgcolor", "color"]),
    },
    methods: {
        submit(url, admin) {
            this.$store.dispatch("authStore/submit", url);
        },
    },
};
</script>
