<template>
    <div>
        <b-loading
            is-full-page
            :active="isLoading"
        ></b-loading>
        <template v-if="tutorialEntity">
            <breadcrumb :items="breadcrumb"></breadcrumb>
            <heading>{{ tutorialEntity.id ?  tutorialEntity.name : 'New Tutorial' }}</heading>
            <validation-observer ref="observer">
<!--                <tutorial-form-->
<!--                    slot-scope="{invalid}"-->
<!--                    :id="innerTutorialEntity.id"-->
<!--                    :name="innerTutorialEntity.name"-->
<!--                    :path="innerTutorialEntity.path"-->
<!--                    :description="innerTutorialEntity.description"-->
<!--                    :parameters="innerTutorialEntity.parameters"-->
<!--                    @update:name="onTutorialUpdate('name', $event)"-->
<!--                    @update:description="onTutorialUpdate('description', $event)"-->
<!--                    @update:steps="onTutorialUpdate('steps', $event)"-->
<!--                    @update:parameters="onTutorialUpdate('parameters', $event)"-->
<!--                    @update:path="onTutorialUpdate('path', $event)"-->
<!--                >-->
<!--                </tutorial-form>-->
            </validation-observer>
            <grouped-buttons-layout is-right>
                <back-button
                    @click="onCancel"
                ></back-button>
                <save-button
                    @click="onSave"
                ></save-button>
            </grouped-buttons-layout>
        </template>
    </div>
</template>

<script>
    import { ValidationObserver } from 'vee-validate'
    import TutorialEntity from "../../atoms/Entities/TutorialEntity"
    import TutorialForm from "../../organisms/forms/TutorialForm"
    import Heading from "../../atoms/Heading"
    import SaveButton from "../../atoms/buttons/SaveButton";
    import BackButton from "../../atoms/buttons/BackButton";
    import DeleteButton from "../../atoms/buttons/DeleteButton";
    import Breadcrumb from "../../molecules/Breadcrumb/Breadcrumb";
    import FadeTransition from "../../atoms/transitions/FadeTransition";
    import Dialog from "../../../../ext/js/components/molecules/Dialog";
    import GroupedButtonsLayout from "../../layouts/GroupedButtonsLayout";

    export default {
        name: "TutorialTemplate",
        components: {
            GroupedButtonsLayout,
            Dialog,
            Breadcrumb,
            DeleteButton,
            BackButton,
            SaveButton,
            Heading,
            TutorialForm,
            ValidationObserver,
            FadeTransition,
        },
        props: {
            breadcrumb: {
                type: Array,
                default() {
                    return [];
                }
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
            tutorialEntity: {
                type: Object,
                default() {
                    return new TutorialEntity()
                },
            },
        },
        data() {
            return {
                innerTutorialEntity: new TutorialEntity(),
                showDeleteDialog: false,
            }
        },
        watch: {
            tutorialEntity: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.innerTutorialEntity = new TutorialEntity({...value});
                    }
                }
            },
            showDeleteDialog(value) {
                if (value) {
                    this.$dialog.confirm({
                        title: `Delete ${this.tutorialEntity.name}`,
                        message: 'You are about to delete this tutorial.',
                        onConfirm: this.onDelete,
                        onCancel: () => { this.showDeleteDialog = false },
                        type: 'is-danger',
                    })
                }
            }
        },
        methods: {
            onSave() {
                this.$refs.observer.validate()
                    .then(result => {
                        if (result) this.$emit('click:save', this.innerTutorialEntity);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onCancel() {
                this.$emit('click:cancel', this.innerTutorialEntity);
            },
            onDelete() {
                this.$emit('click:delete', this.innerTutorialEntity);
            },
            onTutorialUpdate(key, value) {
                this.innerTutorialEntity = new TutorialEntity({
                    ...this.innerTutorialEntity,
                    [key]: value,
                })
            },
        }
    }
</script>

<style scoped>
    .form-actions {
        margin-top: 3em;
        display: flex;
        flex-direction: row;
    }
</style>