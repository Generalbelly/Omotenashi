<template>
    <div>
        <breadcrumb :items="breadcrumb"></breadcrumb>
        <heading>{{ projectEntity.id ?  projectEntity.name : 'New Project' }}</heading>
        <validation-observer ref="observer">
            <project-form
                slot-scope="{invalid}"
                :id="innerProject.id"
                :name.sync="innerProject.name"
                :protocol.sync="innerProject.protocol"
                :domain.sync="innerProject.domain"
                :whitelisted_domain_entities.sync="innerProject.whitelisted_domain_entities"
                :oauth_entities="innerProject.oauth_entities"
                @click:ga-connect="$emit('click:ga-connect', $event)"
                @click:ga-delete="$emit('click:ga-delete', $event)"
            ></project-form>
        </validation-observer>
        <div class="form-actions">
            <delete-button
                @click="showDeleteDialog = true"
                class="has-margin-right-auto  is-text"
            ></delete-button>
            <div class="buttons">
                <cancel-button
                    class="is-neutral-100"
                    @click="onCancel"
                >
                </cancel-button>
                <save-button
                    class="is-primary"
                    @click="onSave"
                ></save-button>
            </div>
        </div>
        <!--<fade-transition>-->
            <!--<div v-show="showDeleteDialog" class="delete-confirmation">-->
                <!--<dialog type="is-danger">-->
                    <!--<div class="level">-->
                        <!--<div class="level-left">-->
                            <!--<p class="level-item">You are about to delete this project.</p>-->
                        <!--</div>-->
                        <!--<div class="level-right">-->
                            <!--<confirm-button-->
                                <!--@click="onDelete"-->
                                <!--class="level-item is-danger-300"-->
                            <!--&gt;-->
                            <!--</confirm-button>-->
                            <!--<cancel-button-->
                                <!--@click="showDeleteDialog = false"-->
                                <!--class="level-item is-text"-->
                            <!--&gt;-->
                            <!--</cancel-button>-->
                        <!--</div>-->
                    <!--</div>-->
                <!--</dialog>-->
            <!--</div>-->
        <!--</fade-transition>-->
        <b-loading
            is-full-page
            :active="isLoading"
        ></b-loading>
    </div>
</template>

<script>
    import { ValidationObserver } from 'vee-validate'
    import ProjectEntity from "../../atoms/Entities/ProjectEntity"
    import ProjectForm from "../../molecules/forms/ProjectForm"
    import Heading from "../../atoms/Heading"
    import SaveButton from "../../atoms/buttons/SaveButton";
    import BackButton from "../../atoms/buttons/BackButton";
    import DeleteButton from "../../atoms/buttons/DeleteButton";
    import ConfirmButton from "../../atoms/buttons/ConfirmButton";
    import CancelButton from "../../atoms/buttons/CancelButton";
    import Breadcrumb from "../../molecules/Breadcrumb/Breadcrumb";
    import FadeTransition from "../../atoms/transitions/FadeTransition";
    import Dialog from "../../../../ext/js/components/molecules/Dialog";

    export default {
        name: "ProjectTemplate",
        components: {
            Dialog,
            Breadcrumb,
            CancelButton,
            ConfirmButton,
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
                default: null,
            },
        },
        data() {
            return {
                innerProject: new ProjectEntity(),
                showDeleteDialog: false,
            }
        },
        watch: {
            projectEntity: {
                immediate: true,
                handler(value) {
                    if (value) {
                        console.log(value);
                        this.innerProject = new ProjectEntity({...value});
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
                        if (result) this.$emit('click:save', this.innerProject);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onCancel() {
                this.$emit('click:cancel', this.innerProject);
            },
            onDelete() {
                this.$emit('click:delete', this.innerProject);
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
    .delete-confirmation {
        margin-top: 2em;
    }
</style>