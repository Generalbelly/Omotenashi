<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div
            class="modal-content"
            :class="addtionalModalClass"
        >
            <div
                class="content"
                :class="addtionalContentClass"
            >
                <slot></slot>
            </div>
        </div>
        <button
            v-if="showClose"
            class="modal-close is-large is-paddingless"
            aria-label="close"
            @click="$emit('closeClick')"
        ></button>
    </div>
</template>
<script>
export default {
    props: {
        showClose: {
            type: Boolean,
            default: true,
        },
        modalContentClass: {
            type: Array,
            default() {
                return [];
            }
        },
        contentClass: {
            type: Array,
            default() {
                return [];
            }
        }
    },
    data() {
        return {};
    },
    methods: {
        convertArrayToObject(array, value=true) {
            if (!Array.isArray(array)) return false;
            return array.reduce((a, c) => {
                return {
                    ...a,
                    [c]: value,
                }
            }, {});
        },
    },
    computed: {
        addtionalModalClass() {
            return this.convertArrayToObject(this.modalContentClass);
        },
        addtionalContentClass() {
            return this.convertArrayToObject(this.contentClass);
        }
    }
};
</script>