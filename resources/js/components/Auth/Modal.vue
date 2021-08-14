<template>
    <div
        class="fixed inset-0 z-50 flex justify-center w-screen h-screen overflow-hidden text-center bg-gray-300  fadeout main-modal"
        :id="id"
    >
        <div
            class="relative flex justify-center border border-teal-500 shadow-lg  bg-yellow-50 modal-container"
            :id="id + 'container'"
        >
            <button
                class="z-50 cursor-pointer x-modal-close"
                @click="toggle(id, false)"
            >
                <svg
                    class="text-black fill-current"
                    xmlns="http://www.w3.org/2000/svg"
                    width="18"
                    height="18"
                    viewBox="0 0 18 18"
                >
                    <path
                        d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                    ></path>
                </svg>
            </button>
            <div class="relative py-4 modal-content" :id="id + 'content'">
                <div class="pb-3" v-if="title">
                    <p
                        class="text-2xl font-bold text-center text-indigo-500"
                        v-text="title"
                    ></p>
                </div>
                <div
                    class="flex items-center justify-center pb-3 my-5"
                    :id="id + 'body'"
                >
                    <slot name="body"></slot>
                </div>

                <div class="flex justify-end pt-2">
                    <button
                        class="p-3 px-4 text-black bg-gray-400 rounded-lg  focus:outline-none hover:bg-gray-300"
                        @click="toggle(id, false)"
                    >
                        Close
                    </button>
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
                if (!e.target.closest(`#${vm.id}container`)) {
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
    animation: fadeIn 1s linear ease-in-out;
    display: flex !important;
}

.zoom {
    animation: zoom 1s linear ease-in;
}

.fadeout {
    animation: fadeOut 0.5s linear ease-in;
    display: none !important;
}

.x-modal-close {
    position: absolute;
    top: 0px;
    right: 0px;
}
.modal-container {
    width: 100%;
    margin: 30px;
    max-height: 90%;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 5px;
}

@media (min-width: 768px) {
    .modal-container {
        margin: 100px;
        padding: 10px;
    }
}

@media (min-width: 991px) {
    .modal-container {
        width: auto;
        max-width: 70%;
        margin: 100px;
        padding: 20px;
    }
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
@keyframes zoom {
    from {
        transform: scale(0);
    }
    to {
        transform: scale(1);
    }
}
</style>
