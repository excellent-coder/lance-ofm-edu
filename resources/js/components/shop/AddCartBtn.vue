<template>
    <button
        class="relative block w-full h-10 text-center text-white transition-all bg-yellow-500  hover:bg-yellow-600"
    >
        <i class="absolute fas fa-cart-plus left-3 top-3"></i>
        ADD TO CART
    </button>
</template>

<script>
export default {
    name: "AddCartBtn",
    setup() {
        return {};
    },
};
</script>

<style lang="scss" scoped></style>
