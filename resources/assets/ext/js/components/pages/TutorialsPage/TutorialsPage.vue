<template>
    <tutorials-template
        :project-entity="projectEntity"
        :tutorial-entities="tutorialEntities"
        :query="query"
        :pagination="pagination"
        :is-requesting="isRequesting"
        @select="onTutorialSelect"
        @click:search="onClickSearch"
        @change:query="onChangeQuery"
        @change:pagination="onChangePagination"
        @click:add-button="onClickAddButton"


        @closeClick="$emit('click:close')"
        @stepClick="selectStep"
        @deleteStepClick="deleteStep"
        @stepSaveClick="onStepSaveClick"
        @deleteTutorialConfirmClick="deleteTutorial"
        @click:retry="onClickRetry"
        :show-project-not-found-modal="projectNotFound"
    >
    </tutorials-template>
</template>
<script>
    import { debounce } from 'debounce'
    import { mapActions, mapGetters, mapState,} from 'vuex'
    import TutorialsTemplate from '../../templates/TutorialsTemplate'

    export default {
        components: {
            TutorialsTemplate
        },
        data() {
            return {
                urlDidChange: false,
                path: null,
                query: null,
                pagination: {
                    page: 0,
                    perPage: 20,
                    orderBy: ['created_at', 'desc'],
                    total: 0,
                },
            };
        },
        computed: {
            ...mapState('tutorial', [
                'projectEntity',
                'tutorialEntities',
                'selectedTutorialId',
                'selectedStepId',
                'requestState',
                'projectNotFound',
            ]),
            ...mapState([
                'extLog'
            ]),
            ...mapGetters('tutorial', [
                'selectedTutorial',
                'selectedStep',
                'isRequesting'
            ]),
        },
        created() {
            this.listTutorials()
        },
        methods: {
            ...mapActions('tutorial', [
                'listTutorials',
                'addTutorial',
                'updateTutorial',
                'deleteTutorial',
                'selectTutorial',
                'selectStep',
                'addStep',
                'updateStep',
                'deleteStep',
            ]),
            ...mapActions([
                'retrieveLog',
                'saveLog',
            ]),
            onClickSave(data) {
                const {
                    id = null,
                    steps = [],
                    parameters = [],
                    path = {},
                    name,
                    description,
                } = data
                if (id) {
                    this.updateTutorial({
                        data: {
                            id,
                            name,
                            description,
                            steps,
                            path,
                            parameters
                        },
                        id
                    })
                } else {
                    this.addTutorial({
                        data: {
                            name,
                            description,
                            steps,
                            path,
                            parameters,
                            project_id: this.projectEntity.id,
                        }
                    })
                }
            },
            onTutorialSelect(tutorialEntity) {
                console.log(tutorialEntity);
            },
            onChangePagination(pagination) {
                this.pagination = {
                    ...pagination,
                    orderBy: `${pagination.orderBy[0]} ${pagination.orderBy[1]}`,
                };
                this.listTutorials({
                    pagination: this.pagination,
                })
            },
            search: debounce(function(params){
                this.listTutorials(params);
            }, 250),
            onChangeQuery(query) {
                this.query = query;
                this.search({
                    ...this.pagination,
                    q: this.query,
                });
            },
            onClickSearch() {
                this.search({
                    ...this.pagination,
                    q: this.query,
                });
                // this.listProjects({
                //     ...this.pagination,
                //     q: this.query,
                // })
            },
            onClickAddButton() {
                // this.$router.push({
                //     name: 'projects.create',
                // })
            },
            onSelectTutorial(id) {
                this.selectTutorial({ id });
            },
            onStepSaveClick({ id, element, popover }) {
                if (id) {
                    this.updateStep({
                        data: {
                            element,
                            popover,
                        },
                        id,
                    })
                } else {
                    this.addStep({
                        data: {
                            element,
                            popover,
                        },
                    })
                }
            },
            onClickRetry() {
                this.list()
            }
        },
    }
</script>