<template>
    <div>
        <heading>
            {{ innerProject.id ?  project.name : 'New Project' }}
        </heading>
        <validation-observer ref="observer">
            <project-form
                slot-scope="{invalid}"
                :name.sync="innerProject.name"
                :domain.sync="innerProject.domain"
                @click:save="onClickSave"
                @click:back="onClickBack"
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

    export default {
        name: "ProjectTemplate",
        components: {
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
            }
        },
        watch: {
            project: {
                immediate: true,
                handler(value) {
                    if (value) {
                        this.innerProject = new ProjectEntity({...value});
                    }
                }
            }
        },
        methods: {
            onClickSave() {
                this.$refs.observer.validate()
                    .then(result => {
                        console.log(result);
                        if (result) this.$emit('save', this.innerProject);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            },
            onClickBack() {
                this.$emit('back', this.innerProject);
            }
        }
    }
</script>

<style scoped>

</style>