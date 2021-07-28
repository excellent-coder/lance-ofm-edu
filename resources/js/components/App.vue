<template>
    <div>
        <div class="container">
            <div>
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},
    computed: {
        // ...mapState({
        //     msg: (state) => state.flash.msg,
        // }),
        // ...mapState("flash", {
        //     msg: (state) => state.msg,
        // }),
        // ...mapState("flash", ["msg", "bgcolor"]),
    },
};
</script>

<style lang="scss" scoped></style>
