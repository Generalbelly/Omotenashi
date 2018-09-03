<template>
    <BaseModal
        :modal-content-class="modalContentClass"
        :content-class="contentClass"
        :show-close="false"
    >
        <div
            id="editor"
            ref="editor"
        >
            <!--<span v-html="html"></span>-->
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
import Quill from 'quill/dist/quill.min';
import BaseModal from '../BaseModal';

export default {
    props: {
        quillContents: {
            type: Object,
            default: null,
        }
    },
    mounted() {
        this.quill = new Quill('#editor', {
            theme: 'snow'
        });
        this.quill.on('text-change', this.onTextChange)
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