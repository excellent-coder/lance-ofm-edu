<template>
    <img v-if="!done && preloader" v-bind="$attrs" :src="preloader" />
    <img
        v-bind="$attrs"
        v-show="done"
        :src="src"
        width="400"
        @load="loaded"
        @error="errored"
    />
</template>

<script>
export default {
    props: {
        src: {
            type: String,
            required: true,
        },
        preloader: {
            type: String,
            default: "",
        },
        errorSrc: {
            type: String,
        },
    },
    data() {
        return {
            done: false,
        };
    },
    methods: {
        loaded() {
            this.done = true;
        },
        errored() {
            if (this.errorSrc) {
                this.src = this.errorSrc;
            }
        },
    },
};
</script>
