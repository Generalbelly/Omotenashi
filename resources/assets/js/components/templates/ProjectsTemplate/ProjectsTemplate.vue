<template>
    <div>
        <index-page-layout title="Projects">
            <search-field
                slot="search"
                :value="query"
                @input="$emit('change:query', $event)"
                @click:search="$emit('click:search')"
            ></search-field>
            <add-button
                slot="add"
                @click="$emit('click:add')"
            ></add-button>
            <project-table
                slot="table"
                :pagination="pagination"
                :project-entities="projectEntities"
                :is-loading="isLoading"
                :total="total"
                @change:pagination="$emit('change:pagination', $event)"
                @click:edit="$emit('click:edit', $event)"
                @details-open="$emit('details-open', $event)"
                @click:create-first-tutorial="onClickCreateFirstTutorial"
                @click:create-first-project="$emit('click:create-first-project')"
            >
            </project-table>
        </index-page-layout>
        <modal :active.sync="showExtensionReminder">
            Have you installed {{ appName }} chrome extension to create tutorials?
            <a
                slot="primary-action-button"
                class="button is-primary"
                href=""
                target="_blank"
            >
                Go to the installation page
            </a>
            <button
                slot="secondary-action-button"
                class="button is-neutral-100"
                @click="$emit('click:create-first-tutorial', selectedProjectEntity)"
            >
                Create your first tutorial for {{ selectedProjectEntity.name }}.
            </button>
        </modal>
    </div>
</template>

<script>
    import SearchField from "../../atoms/fields/SearchField/SearchField";
    import AddButton from "../../atoms/buttons/AddButton/AddButton";
    import Heading from "../../atoms/Heading/Heading";
    import IndexPageLayout from "../../layouts/IndexPageLayout/IndexPageLayout";
    import ProjectTable from "../../organisms/ProjectTable/ProjectTable";
    import Modal from "../../molecules/Modal";
    import Checkbox from "../../atoms/fields/Checkbox/Checkbox";
    import ProjectEntity from "../../atoms/Entities/ProjectEntity";

    export default {
        name: "ProjectsTemplate",
        components: {
            Checkbox,
            Modal,
            ProjectTable,
            IndexPageLayout,
            Heading,
            AddButton,
            SearchField,
        },
        props: {
            query: {
                type: String,
                default: null,
            },
            pagination: {
                type: Object,
                default() {
                    return {}
                }
            },
            projectEntities: {
                type: Array,
                default() {
                    return [];
                },
            },
            total: {
                type: Number,
                default: 0,
            },
            isLoading: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                showExtensionReminder: false,
                appName: process.env.APP_NAME,
                selectedProjectEntity: new ProjectEntity(),
            }
        },
        methods: {
            onClickCreateFirstTutorial(projectEntity) {
                this.showExtensionReminder = true
                this.selectedProjectEntity = projectEntity
            }
        }
    }
</script>

<style scoped>

</style>