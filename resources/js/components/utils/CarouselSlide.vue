<template>
    <div class="w-full font-sans bg-white slider-wrapper" :id="prefix + id" :style="style">
        <div class="relative w-full h-full bg-white shadow-2xl">
            <div class="relative w-full h-full slides-inner" role="listbox" tabindex="0">
                <slot />
            </div>

            <button class="absolute left-0 px-3 py-1 text-white bg-yellow-400 go left" style="top: 40%"
                @click.prevent="showSlides(index - 1)" title="previous">
                <i class="fas fa-chevron-left"></i>
                <span class="sr-only">Previous</span>
            </button>
            <button class="absolute right-0 px-3 py-1 text-white bg-yellow-400 go right" style="top: 40%"
                @click.prevent="showSlides(index + 1)" title="next">
                <i class="fas fa-chevron-right"></i>
                <span class="sr-only">Next</span>
            </button>
            <ol class="absolute flex justify-center w-full indicator-box">
                <li class="inline-block cursor-pointer slider-position" v-for="item in totalSlides" :key="item"
                    :data-slide-to="item" @click="showSlides(item, true)"></li>
            </ol>
        </div>
    </div>
</template>

<script>
    import {
        onMounted,
        toRefs,
        ref
    } from "vue";
    export default {
        props: {
            id: {
                type: String,
                required: true,
            },
            prefix: {
                type: String,
                default: "slider-",
            },
            auto: {
                type: Number,
            },
            clickStopAuto: {
                type: Boolean,
                default: false,
            },
            style: {
                type: String,
                default: 'height: 60vh;'
            }
        },
        setup(props, context) {
            let id = props.prefix + props.id;
            const wrapper = ref("");
            const index = ref(0);
            const totalSlides = ref(0);
            const swipeInterval = ref(0);

            if (props.auto !== undefined) {
                if (props.auto) {
                    swipeInterval.value = props.auto;
                } else {
                    swipeInterval.value = 5000;
                }
            }

            const getTotalSlides = () => {
                let totalSlideNodes =
                    document.querySelectorAll(".slider-item").length;
                let ar = [];
                for (let i = 0; i < totalSlideNodes; i++) {
                    ar.push(i);
                }
                return ar;
            };

            onMounted(() => {
                totalSlides.value = getTotalSlides();
                wrapper.value = document.getElementById(id);

                setTimeout(() => {
                    showSlides(0, false);
                    if (props.auto !== undefined) {
                        autoSlide();
                    }
                    return;
                }, 500);
            });

            const showSlides = (n, click = true) => {
                var i;
                var animation;

                if (n >= index.value) {
                    animation = "from-right";
                } else {
                    animation = "from-left";
                }

                index.value = n;
                var slides = wrapper.value.querySelectorAll(".slider-item");
                var dots = wrapper.value.querySelectorAll(".slider-position");

                if (n + 1 > slides.length) {
                    // this goes to the first slide
                    index.value = 0;
                }

                if (n < 0) {
                    // this goes to the last slide
                    index.value = slides.length - 1;
                }

                for (i = 0; i < slides.length; i++) {
                    slides[i].classList.remove("active");
                    slides[i].classList.remove("from-left");
                    slides[i].classList.remove("from-right");
                }

                for (i = 0; i < dots.length; i++) {
                    dots[i].classList.remove("active");
                }

                slides[index.value].classList.add("active");
                slides[index.value].classList.add(animation);
                dots[index.value].classList.add("active");

                if (click && swipeInterval.value) {
                    if (click && props.clickStopAuto) {
                        clearInterval(autoSliding);
                        return;
                    }
                    autoSlide();
                }
            };

            var autoSliding;
            const autoSlide = () => {
                clearInterval(autoSliding);
                autoSliding = setInterval(() => {
                    showSlides(index.value + 1, false);
                }, swipeInterval.value);
            };

            return {
                showSlides,
                totalSlides,
                index,
            };
        },
    };

</script>

<style lang="scss">
    .slider-wrapper {
        .go {
            transition: all 0.3s linear;
            transform: scale(0);

            &.left {
                margin-left: -60px;
            }

            &.right {
                margin-right: -60px;
            }
        }

        .indicator-box {
            bottom: 15%;
        }

        .slider-position {
            height: 5px;
            width: 50px;
            margin: 0 2px;
            background-color: rgb(27, 32, 19);

            &.active {
                background-color: #fff;
            }

            &:hover {
                background-color: aqua;
            }
        }

        &:hover {
            .go {
                opacity: 0.3;
                transform: scale(1, 1);
                font-size: 25px;
                width: 60px;
                height: 60px;
                line-height: 38px;

                &:hover {
                    opacity: 1;
                }

                &.left {
                    margin-left: 0;
                }

                &.right {
                    margin-right: 0;
                }
            }

            // .slider-position {
            //     display: flex;
            // }
        }

        .slider-item {
            display: none;
            height: 0%;
            position: relative;

            &.active {
                display: block;
                height: 100%;
                width: 100%;
            }

            img {
                height: 100%;
                width: 100%;
                position: absolute;
                top: 0;
                left: 0;
            }

            &.active {

                // animation: from-right 1s linear;
                &.from-right {
                    animation: from-right 0.1s ease-in;
                }

                &.from-left {
                    animation: from-left 0.1s ease-in;
                }
            }

            &::before {
                content: "";
                position: absolute;
                height: 100%;
                width: 100%;
                top: 0px;
                left: 0px;
                display: block;
                background: rgba(0, 0, 0, 0.5);
            }

            // background image
            overflow: auto;
            position: relative;
            background-position: center;
            background-size: cover;
        }

        .slider-caption {
            position: absolute;
            width: 100%;
            height: 80%;
            bottom: 20%;
            left: 0;
        }

    }

    @media only screen and (min-width: 768px) {
        .slider-wrapper {
            height: calc(100vh - 70px);

            &:hover {
                .go {
                    transform: scale(1, 1);
                }
            }
        }
    }

    @keyframes show-slider {
        from {
            /* transform: scale3d(0, 0, 0); */
        }

        to {
            /* transform: scale3d(1, 1, 1); */
        }
    }

    @keyframes from-left {
        from {
            left: -100%;
        }

        to {
            left: 0;
        }
    }

    @keyframes from-right {
        from {
            right: -100%;
        }

        to {
            right: 0;
        }
    }

</style>
