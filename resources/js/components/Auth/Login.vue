<template>
    <div class="w-full max-w-xs md:max-w-none" style="width: 400px">
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
            <div class="mb-6">
                <label
                    class="block text-gray-700 text-sm font-bold mb-2"
                    for="password"
                >
                    Password
                </label>
                <input
                    class="
                        shadow
                        appearance-none
                        border border-red-500
                        rounded
                        w-full
                        py-2
                        px-3
                        text-gray-700
                        mb-3
                        leading-tight
                        focus:outline-none focus:shadow-outline
                    "
                    id="password"
                    type="password"
                    placeholder="******************"
                    v-model="password"
                />
                <p class="text-red-500 text-xs italic">
                    Please choose a password.
                </p>
            </div>
            <div class="mb-6 flex justify-between">
                <input type="checkbox" v-model="remember" />
                <label
                    class="text-gray-700 text-sm font-bold mb-2"
                    for="password"
                >
                    Remember me
                </label>
            </div>
            <div class="flex items-center justify-between">
                <button
                    class="
                        bg-blue-500
                        hover:bg-blue-700
                        text-white
                        font-bold
                        py-2
                        px-4
                        rounded
                        focus:outline-none focus:shadow-outline
                    "
                    type="submit"
                >
                    Sign In
                </button>
                <button
                    class="
                        inline-block
                        align-baseline
                        font-bold
                        text-sm text-blue-500
                        hover:text-blue-800
                    "
                    @click.prevent="$store.commit('modal', 'reset-password')"
                >
                    Forgot Password?
                </button>
            </div>
            <div class="w-full text-center my-3">
                <span
                    >Don't Have an account
                    <button
                        class="
                            btn
                            text-blue-500
                            font-bold
                            text-lg
                            cursor-pointer
                        "
                        @click.prevent="$store.commit('modal', 'register')"
                    >
                        Register
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
