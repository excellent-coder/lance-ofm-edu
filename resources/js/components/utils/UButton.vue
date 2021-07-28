<template>
    <button
        class="
            inline-block
            bg-green-500
            text-white
            font-bold
            px-3
            rounded-lg
            h-10
        "
    >
        <slot>submit</slot>
    </button>
</template>

<script>
export default {
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped>
.input-element:disabled {
    background-color: rgba(61, 185, 123, 0.781);
    cursor: not-allowed;
}
</style>
