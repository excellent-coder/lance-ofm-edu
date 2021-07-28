<template>
    <div>
        <button
            v-show="visible"
            @click="toggle(id, true)"
            class="
                inline-block
                text-sm
                px-4
                py-2
                leading-none
                border
                rounded
                text-white
                border-white
                hover:border-transparent hover:text-indigo-500 hover:bg-white
                focus:outline-none focus:shadow-outline
                mt-4
                lg:mt-0
            "
            v-html="btnTxt"
        ></button>

        <div
            class="
                main-modal
                fixed
                w-screen
                h-screen
                inset-0
                z-50
                overflow-hidden
                flex
                justify-center
                items-center
                animated
                fadeout
                faster
                bg-gray-300
            "
            :id="id"
        >
            <div
                class="
                    border border-teal-500
                    modal-container
                    bg-white
                    w-11/12
                    md:max-w-md
                    mx-auto
                    rounded
                    shadow-lg
                    max-h-screen
                    z-50
                    overflow-y-auto
                "
            >
                <div class="modal-content py-4 relative" :id="id + 'content'">
                    <!--Title-->
                    <div class="pb-3">
                        <p
                            class="
                                text-2xl
                                font-bold
                                text-indigo-500 text-center
                            "
                            v-text="title"
                        ></p>
                    </div>
                    <div
                        class="x-modal-close cursor-pointer z-50"
                        @click="toggle(id, false)"
                    >
                        <svg
                            class="fill-current text-black"
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 18 18"
                        >
                            <path
                                d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                            ></path>
                        </svg>
                    </div>
                    <!--Body-->
                    <div
                        class="my-5 flex justify-center items-center pb-3"
                        :id="id + 'body'"
                    >
                        <slot name="body"></slot>
                    </div>
                    <!--Footer-->
                    <div class="flex justify-end pt-2">
                        <button
                            class="
                                focus:outline-none
                                px-4
                                bg-gray-400
                                p-3
                                rounded-lg
                                text-black
                                hover:bg-gray-300
                            "
                            @click="toggle(id, false)"
                        >
                            Cancel
                        </button>
                        <button
                            class="
                                focus:outline-none
                                px-4
                                bg-teal-500
                                p-3
                                ml-3
                                rounded-lg
                                text-white
                                hover:bg-teal-400
                            "
                        >
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: "modal",
        },
        title: {
            type: String,
            default: "Login to continue",
        },
        btnTxt: {
            type: String,
            default: "Login",
        },
        visible: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        toggle(id, show = true) {
            return handleModal(id, show);
        },
    },

    mounted() {
        let vm = this;
        document.body.addEventListener(
            "click",
            function (e) {
                // console.log(e.target.closest);
                if (!e.target.closest(`#${vm.id}content`)) {
                    vm.toggle(vm.id, false);
                }
            },
            true
        );
    },
};
</script>

<style>
.animated {
    -webkit-animation-duration: 1s;
    animation-duration: 1s;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
}

.animated.faster {
    -webkit-animation-duration: 500ms;
    animation-duration: 500ms;
}

.fadeIn {
    -webkit-animation-name: fadeIn;
    animation-name: fadeIn;
    display: flex !important;
}

.fadeout {
    -webkit-animation-name: fadeOut;
    animation-name: fadeOut;
    display: none !important;
    transition: display 2s ease-in;
}

.x-modal-close {
    position: absolute;
    top: 0px;
    right: 0px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
    }

    to {
        opacity: 0;
    }
}
</style>
