<template>
    <b-modal
        :active="true"
        has-modal-card
        @close="onBack"
    >
        <div class="modal-card">
            <header class="modal-card-head">
                <heading>
                    {{ innerProject.id ?  innerProject.name : 'New Project' }}
                </heading>
            </header>
            <section class="modal-card-body">
                <validation-observer ref="observer">
                    <project-form
                        slot-scope="{invalid}"
                        :name.sync="innerProject.name"
                        :domain.sync="innerProject.domain"
                    ></project-form>
                </validation-observer>
            </section>
            <footer class="modal-card-foot">
                <div class="level has-margin-bottom-0">
                    <div class="level-left">
                        <save-button
                            class="level-item"
                            @click="onSave"
                        ></save-button>
                        <back-button
                            class="level-item"
                            @click="onBack"
                        >
                        </back-button>
                    </div>
                    <div class="level-right">
                        <b-icon
                            v-if="innerProject.id"
                            class="level-item"
                            pack="fas"
                            icon="trash"
                            @click.native="showDeleteButton = true"
                        >
                        </b-icon>
                    </div>
                </div>
                <transition name="fade">
                    <div v-show="showDeleteButton" class="level has-margin-top-4">
                        <div class="level-left">
                            <b-message type="is-danger">
                                You are about to delete "{{ innerProject.name }}".
                            </b-message>
                        </div>
                        <div class="level-right">
                            <delete-button
                                @click="onDelete"
                            >
                            </delete-button>
                            <cancel-button
                                @click="showDeleteButton = false"
                            >
                            </cancel-button>
                        </div>
                    </div>
                </transition>
            </footer>
            <b-loading
                is-full-page
                :active="isLoading"
            ></b-loading>
        </div>
    </b-modal>
</template>

<script>
    import { ValidationObserver } from 'vee-validate'
    import ProjectEntity from "../../atoms/Entities/ProjectEntity"
    import ProjectForm from "../../molecules/forms/ProjectForm"
    import Heading from "../../atoms/Heading"
    import SaveButton from "../../atoms/buttons/SaveButton";
    import BackButton from "../../atoms/buttons/BackButton";
    import DeleteButton from "../../atoms/buttons/DeleteButton/DeleteButton";
    import ConfirmButton from "../../atoms/buttons/ConfirmButton/ConfirmButton";
    import CancelButton from "../../atoms/buttons/CancelButton/CancelButton";

    export default {
        name: "ProjectTemplate",
        components: {
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
            isLoading: {
                type: Boolean,
                default: false,
            },
            project: {
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
            project: {
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
                        console.log(result);
                        if (result) this.$emit('save', this.innerProject);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onBack() {
                this.$emit('back', this.innerProject);
            },
            onDelete() {
                this.$emit('delete', this.innerProject);
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
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>