<template>
    <div>
        <breadcrumb :items="breadcrumb"></breadcrumb>
        <heading>{{ projectEntity.id ?  projectEntity.name : 'New Project' }}</heading>
        <validation-observer ref="observer">
            <project-form
                slot-scope="{invalid}"
                :id="innerProjectEntity.id"
                :name.sync="innerProjectEntity.name"
                :protocol.sync="innerProjectEntity.protocol"
                :domain.sync="innerProjectEntity.domain"
                :tutorial_settings.sync="innerProjectEntity.tutorial_settings"
                :oauth_entities="innerProjectEntity.oauth_entities"
                :google_analytics_property_entities.sync="innerProjectEntity.google_analytics_property_entities"
                :google-analytics-accounts="innerProjectEntity.googleAnalyticsAccounts"
                @click:ga-connect="$emit('click:ga-connect', $event)"
                @click:ga-delete="$emit('click:ga-delete', $event)"
                @click:ga-property-edit="$emit('click:ga-property-edit', $event)"
            ></project-form>
        </validation-observer>
        <div class="form-actions">
            <delete-button
                :disabled="!innerProjectEntity.id"
                @click="showDeleteDialog = true"
                class="has-margin-right-auto  is-text"
            ></delete-button>
            <grouped-buttons-layout is-right>
                <back-button
                    @click="onCancel"
                ></back-button>
                <save-button
                    @click="onSave"
                ></save-button>
            </grouped-buttons-layout>
        </div>
        <b-loading
            is-full-page
            :active="isLoading"
        ></b-loading>
    </div>
</template>

<script>
    import { ValidationObserver } from 'vee-validate'
    import ProjectEntity from "../../atoms/Entities/ProjectEntity"
    import ProjectForm from "../../organisms/forms/ProjectForm"
    import Heading from "../../atoms/Heading"
    import SaveButton from "../../atoms/buttons/SaveButton";
    import BackButton from "../../atoms/buttons/BackButton";
    import DeleteButton from "../../atoms/buttons/DeleteButton";
    import Breadcrumb from "../../molecules/Breadcrumb/Breadcrumb";
    import FadeTransition from "../../atoms/transitions/FadeTransition";
    import Dialog from "../../../../ext/js/components/molecules/Dialog";
    import GroupedButtonsLayout from "../../layouts/GroupedButtonsLayout";

    export default {
        name: "ProjectTemplate",
        components: {
            GroupedButtonsLayout,
            Dialog,
            Breadcrumb,
            DeleteButton,
            BackButton,
            SaveButton,
            Heading,
            ProjectForm,
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
            projectEntity: {
                type: Object,
                default() {
                    return new ProjectEntity()
                },
            },
        },
        data() {
            return {
                innerProjectEntity: new ProjectEntity(),
                showDeleteDialog: false,
            }
        },
        watch: {
            projectEntity: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.innerProjectEntity = new ProjectEntity({...value});
                    }
                }
            },
            showDeleteDialog(value) {
                if (value) {
                    this.$dialog.confirm({
                        title: `Delete ${this.projectEntity.name}`,
                        message: 'You are about to delete this project.',
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
                        if (result) this.$emit('click:save', this.innerProjectEntity);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onCancel() {
                this.$emit('click:cancel', this.innerProjectEntity);
            },
            onDelete() {
                this.$emit('click:delete', this.innerProjectEntity);
            }
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