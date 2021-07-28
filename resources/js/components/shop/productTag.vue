<template>
    <div class="relative w-full" style="height: 300px">
        <a :href="'/shop/' + item.slug" class="block max-w-full h-2/3">
            <image-tag
                class="block w-auto h-full mx-auto"
                :alt="item.title"
                :preloader="preloader"
                :error-src="errorImg"
                :src="'/storage/' + item.image"
            />
        </a>

        <a
            :href="'/shop/' + item.slug"
            class="text-gray-900 hover:text-yellow-800"
        >
            <h3 class="text-xl font-normal capitalize truncate">
                {{ item.title }}
            </h3>
        </a>
        <h3 class="py-0 my-0 text-xl font-medium arial">{{ item.f_price }}</h3>
        <h5 class="text-sm text-gray-800 text-opacity-80">
            <del>{{ item.f_h_price }}</del>
        </h5>
    </div>
</template>

<script>
export default {
    name: "productTag",
    setup() {
        return {};
    },
    props: {
        product: {
            type: Object,
        },
        preloader: {
            type: String,
        },
        errorImg: {
            type: String,
        },
    },
    data() {
        return {
            // item: {},
        };
    },
    methods: {},
    computed: {
        item() {
            return JSON.parse(this.product);
        },
    },
    mounted() {
        console.log(this.item.id);
    },
};
</script>

<style lang="scss" scoped></style>
