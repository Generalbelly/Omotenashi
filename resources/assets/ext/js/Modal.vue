<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content has-background-white">
            <div class="content has-text-left has-padding-4">
                <div v-html="content"></div>
                <div>
                    <button
                        class="button is-success"
                        @click="$emit('startClick')"
                    >
                        {{ actionButtonText }}
                    </button>
                    <!--<button -->
                        <!--class="button is-success"-->
                        <!--@click="$emit('startClick')"-->
                    <!--&gt;-->
                        <!--{{ actionButtonText }}-->
                    <!--</button>-->
                </div>
            </div>
        </div>
        <button
            class="modal-close is-large is-paddingless"
            aria-label="close"
            @click="$emit('closeClick')"
        ></button>
    </div>
</template>
<script>
export default {
    props: {
        actionButtonText: {
            type: String,
            default: '',
        },
        content: {
            type: String,
            default: '',
        },
    },
    data() {
        return {};
    },
};
</script>