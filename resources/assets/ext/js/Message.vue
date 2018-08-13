<template>
    <article
        class="message"
        :class="additionalMessageClass"
    >
        <div class="message-header">
            <p>{{ header }}</p>
            <button
                class="delete is-paddingless"
                aria-label="delete"
                @click="$emit('closeClick')"
            ></button>
        </div>
        <div class="message-body">
            {{ body }}
        </div>
    </article>
</template>
<script>
export default {
    props: {
        header: {
            type: String,
            default: '',
        },
        body: {
            type: String,
            default: '',
        },
        additionalClass: {
            type: Array,
            default: null,
        },
    },
    computed: {
        additionalMessageClass() {
            if (this.additionalClass.length) {
                return this.additionalClass.reduce((a, c) => {
                    return {
                        ...a,
                        [c]: true,
                    }
                }, {});
            }
            return {};
        }
    }
}
</script>