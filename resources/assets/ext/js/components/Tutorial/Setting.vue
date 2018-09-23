<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head has-margin-0">
                <p class="modal-card-title">{{ isCreate ? 'Create' : 'Edit' }} Tutorial</p>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Name</label>
                    <div class="control">
                        <input
                            v-model="updatedTutorial.name"
                            class="input"
                            type="text"
                            placeholder="First timers"
                        >
                    </div>
                </div>
                <div class="field">
                    <label class="label">Description (Optional)</label>
                    <div class="control">
                        <textarea
                            v-model="updatedTutorial.description"
                            class="textarea"
                            placeholder="updatedTutorial for the first time customers."
                        >
                        </textarea>
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot has-margin-0">
                <BaseButton
                    :classes="['is-success']"
                    @click="onSaveClick"
                >
                    {{ isCreate ? 'Create' : 'Save' }}
                </BaseButton>
                <BaseButton
                    @click="onCancelClick"
                >
                    Cancel
                </BaseButton>
            </footer>
        </div>
    </div>
</template>
<script>
    import BaseButton from '../BaseButton'
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
            BaseButton,
        }
    }

</script>
<style scoped>
    .label {
        text-align: left;
    }
</style>