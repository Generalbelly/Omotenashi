<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ isCreate ? 'Create' : 'Edit' }} updatedTutorial</p>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input v-model="updatedTutorial.name" class="input" type="text" placeholder="First timers">
                    </div>
                </div>
                <div class="field">
                    <label class="label">Description (Optional)</label>
                    <div class="control">
                        <textarea v-model="updatedTutorial.description" class="textarea" placeholder="updatedTutorial for the first time customers."></textarea>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <button
                    class="button is-success"
                    @click="onSaveClick"
                >
                    {{ isCreate ? 'Create' : 'Save' }}
                </button>
                <button
                    class="button"
                    @click="onCancelClick"
                >Cancel</button>
            </footer>
        </div>
    </div>
</template>
<script>
import BaseModal from '../BaseModal';

export default {
    props: {
        tutorial: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            isCreate: true,
            updatedTutorial: {
                name: '',
                description: '',
            },
        };
    },
    methods: {
        onCancelClick() {
            this.$emit('cancelClick');
            this.clear()
        },
        onSaveClick() {
            this.$emit('saveClick', this.updatedTutorial)
            this.clear()
        },
        clear() {
            this.updatedTutorial = {
                name: '',
                description: '',
            };
        },
    },
    watch: {
        tutorial: {
            immediate: true,
            handler(value) {
                if (value) {
                    this.isCreate = false;
                    this.updatedTutorial = { ...value }
                } else {
                    this.clear();
                }
            },
        },
    },
    components: {
        BaseModal
    }
}

</script>
<style scoped></style>