<template>
    <BaseModal
        :modal-content-class="modalContentClass"
        :content-class="contentClass"
        :show-close="false"
    >
        <div id="editor" class="pell"></div>
        <div>
            HTML output:
            <div id="html-output" style="white-space:pre-wrap;"></div>
        </div>
        <button
            class="button is-fixed-bottom-right"
            @click="onDoneClick"
        >
            DONE
        </button>
    </BaseModal>
</template>
<script>
import pell from 'pell'
import BaseModal from '../BaseModal'

export default {
    mounted() {
    },
    beforeDestroy() {
        this.quill = null
    },
    data() {
        return {
            quill: null,
            modalContentClass: ['has-padding-6'],
            contentClass: ['has-background-white'],
            innerHTML: '',
        };
    },
    watch: {
        quillContents(value) {
            if (value) {
                this.quill.setContents(value)
            }
        }
    },
    methods: {
        onTextChange(delta, oldDelta, source) {
            let html = this.$refs.editor.children[0].innerHTML
            if (html === '<p><br></p>') html = ''
            this.innerHTML = html
            // this.$emit('htmlChange', html)
        },
        onDoneClick() {
            console.log(this.quill.getContents())
            this.$emit('doneClick', {
                html: this.innerHTML,
                quillContents: this.quill.getContents(),
            })
        }
    },
    components: {
        BaseModal,
    },
}
</script>
<style scoped></style>