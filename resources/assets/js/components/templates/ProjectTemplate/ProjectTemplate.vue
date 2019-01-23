<template>
    <div>
        <breadcrumb :items="breadcrumb"></breadcrumb>
        <heading>{{ innerProject.id ?  innerProject.name : 'New Project' }}</heading>
        <validation-observer ref="observer">
            <project-form
                slot-scope="{invalid}"
                :id="innerProject.id"
                :name.sync="innerProject.name"
                :protocol.sync="innerProject.protocol"
                :domain.sync="innerProject.domain"
                :whitelisted_domain_entities.sync="innerProject.whitelisted_domain_entities"
                @click:save="onSave"
                @click:cancel="onCancel"
                @click:delete="onDelete"
                @click:ga-connect="$emit('click:ga-connect', $event)"
            ></project-form>
        </validation-observer>
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

    export default {
        name: "ProjectTemplate",
        components: {
            Breadcrumb,
            CancelButton,
            ConfirmButton,
            DeleteButton,
            BackButton,
            SaveButton,
            Heading,
            ProjectForm,
            ValidationObserver,
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
                showDeleteButton: false,
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
    .modal-card-foot {
        flex-direction: column;
    }
    .modal-card-foot > .level {
        width: 100%;
    }
</style>