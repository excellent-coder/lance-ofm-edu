<template>
    <div class="w-full max-w-xs md:max-w-none">
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
            @submit.prevent="submit('/login')"
            class="px-8 pt-6 pb-8 mb-4 bg-white rounded shadow-md"
        >
            <div class="mb-4">
                <label
                    class="block mb-2 text-sm font-bold text-gray-700"
                    for="email"
                >
                    Email
                </label>
                <input
                    class="w-full px-3 py-2 leading-tight text-gray-700 border rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
                    type="text"
                    placeholder="Email"
                    v-model="email"
                />
            </div>
            <div class="mb-6">
                <label
                    class="block mb-2 text-sm font-bold text-gray-700"
                    for="password"
                >
                    Password
                </label>
                <input
                    class="w-full px-3 py-2 mb-3 leading-tight text-gray-700 border border-red-500 rounded shadow appearance-none  focus:outline-none focus:shadow-outline"
                    id="password"
                    type="password"
                    placeholder="******************"
                    v-model="password"
                />
                <p class="text-xs italic text-red-500">
                    Please choose a password.
                </p>
            </div>
            <div class="flex justify-between mb-6">
                <input type="checkbox" v-model="remember" />
                <label
                    class="mb-2 text-sm font-bold text-gray-700"
                    for="password"
                >
                    Remember me
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="px-4 py-2 font-bold text-white bg-blue-500 rounded  hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                    type="submit"
                >
                    Sign In
                </button>
                <button
                    class="inline-block text-sm font-bold text-blue-500 align-baseline  hover:text-blue-800"
                    @click.prevent="$store.commit('modal', 'reset-password')"
                >
                    Forgot Password?
                </button>
            </div>
            <div class="w-full my-3 text-center">
                <span
                    >Don't Have an account
                    <button
                        class="text-lg font-bold text-blue-500 cursor-pointer  btn"
                        @click.prevent="$store.commit('modal', 'register')"
                    >
                        Register
                    </button></span
                >
            </div>
        </form>
        <p class="text-xs text-center text-gray-500">
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
        remember: {
            get() {
                return false;
            },
            set(value) {
                return this.$store.dispatch("authStore/set", {
                    remember: value,
                });
            },
        },
        ...mapState("flash", ["msg", "bgcolor", "color"]),
    },
    methods: {
        submit(url) {
            this.$store.dispatch("authStore/submit", url);
        },
    },
};
</script>
