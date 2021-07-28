<template>
    <div class="block w-full mb-3">
        <label
            v-if="label"
            class="form-label block mb-1 font-semibold text-gray-700"
            :for="inputId"
            >{{ label }}
        </label>

        <div class="relative w-full h-12">
            <input
                :id="inputId"
                ref="input"
                v-bind="$attrs"
                :value="modelValue"
                class="
                    px-2
                    py-2
                    leading-normal
                    block
                    w-full
                    text-gray-800
                    bg-white
                    font-sans
                    rounded-lg
                    text-left
                    appearance-none
                    outline-none
                    input-element
                "
                :class="[
                    {
                        'border-red-400': errors.length,
                        'pl-12': withIcon,
                    },
                    classes,
                ]"
                :type="type"
                @input="$emit('update:modelValue', $event.target.value)"
                @keydown="$emit('keydown', $event)"
                @blur="$emit('blur', $event)"
                @keyup="$emit('keyup', $event)"
            />
            <!-- :value="modelValue" -->
            <div v-if="errors.length" class="text-red-600 mt-1 text-sm w-full">
                {{ errors[0] }}
            </div>

            <svg
                class="absolute text-red-600 fill-current"
                style="top: 12px; right: 12px"
                v-if="errors.length"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
            >
                <path
                    d="M11.953,2C6.465,2,2,6.486,2,12s4.486,10,10,10s10-4.486,10-10S17.493,2,11.953,2z M13,17h-2v-2h2V17z M13,13h-2V7h2V13z"
                />
            </svg>

            <span
                class="
                    absolute
                    px-2
                    my-auto
                    bg-gray-400
                    shadow-sm
                    border-2
                    cursor-pointer
                    hover:bg-blue-600 hover:text-white
                    border-green-300
                    rounded-md
                "
                :title="$attrs.placeholder"
                style="
                    line-height: 2.4;
                    left: 1px;
                    height: 85%;
                    top: 2%;
                    width: 40px;
                "
                v-if="withIcon"
            >
                <slot name="icon"></slot>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "UInput",

    inheritAttrs: false,

    props: {
        type: {
            type: String,
            default: "text",
        },
        value: String,
        label: String,
        errors: {
            type: Array,
            default: () => [],
        },
        withIcon: {
            type: Boolean,
            default: false,
        },
        bordered: {
            type: Boolean,
            default: true,
        },
        modelValue: {
            type: String,
        },
    },

    methods: {
        focus() {
            this.$refs.input.focus();
        },
        select() {
            this.$refs.input.select();
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end);
        },
    },

    computed: {
        classes() {
            return {
                "border-2 focus:border-blue-600 focus:border-blue-600":
                    this.bordered === true,
                "border bg-gray-200 focus:bg-white": this.bordered === false,
            };
        },
        inputId() {
            if (this.$attrs.id) {
                return this.$attrs.id;
            }
        },
    },
    mounted() {
        console.log(this.$attrs.id);
    },
};
</script>

<style lang="scss" scoped>
.input-element:disabled {
    background-color: #aca9a98c;
    color: #353131;
    cursor: not-allowed;
}
</style>
