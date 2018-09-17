<template xmlns="http://www.w3.org/1999/html">
    <nav class="panel has-background-white">
        <p class="panel-heading level has-margin-bottom-0">
            <span>Tutorial</span>
            <button
                class="button is-small has-background-grey has-text-white tutorial-add-button"
                @click="$emit('addTutorialClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </span>
                <span>Add</span>
            </button>
        </p>
        <div class="panel-block level">
            <div class="select">
                <select
                    @change="onTutorialChange($event.target.value)"
                    v-model="selectedTutorialId"
                >
                    <option
                        v-for="tutorial in tutorials"
                        :key="tutorial.id"
                        :value="tutorial.id"
                    >
                        {{ tutorial.name }}
                    </option>
                </select>
            </div>
            <div class="field is-grouped has-margin-left-auto">
                <div class="control">
                    <button
                        class="button is-small"
                        @click.stop.prevent="$emit('editTutorialClick')"
                    >
                            <span class="icon">
                                <font-awesome-icon icon="pen"></font-awesome-icon>
                            </span>
                        <span>Edit</span>
                    </button>
                </div>
                <div class="control">
                    <button
                        v-show="tutorials.length > 1"
                        class="button is-small"
                        @click="$emit('deleteTutorialClick')"
                    >
                            <span class="icon">
                                <font-awesome-icon icon="trash"></font-awesome-icon>
                            </span>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-if="selectedTutorial">
            <a
                class="panel-block has-padding-top-4 has-padding-bottom-4"
                :key="step.id"
                v-for="(step, stepIndex) in selectedTutorial.steps"
                :class="{ 'is-active': step.id === selectedStep.id }"
                @click.stop.prevent="$emit('stepClick', step)"
            >
                <span class="panel-icon">
                     <font-awesome-icon icon="circle"></font-awesome-icon>
                </span>
                    Step {{ stepIndex+1 }}
                    <span
                        class="panel-icon block has-margin-left-auto has-cursor-pointer"
                        @click.stop.prevent="$emit('deleteStepClick', step)"
                    >
                     <font-awesome-icon icon="trash"></font-awesome-icon>
                </span>
            </a>
        </div>
        <div
            v-else
            class="panel-block"
        >
            <p class="has-padding-top-4 has-padding-bottom-4">
                No step added yet.
            </p>
        </div>
        <div class="panel-block">
            <button
                class="button is-link is-outlined is-fullwidth"
                @click="$emit('addStepClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </span>
                <span>Add Step</span>
            </button>
        </div>
        <div class="panel-block">
            <button
                class="button is-primary is-outlined is-fullwidth"
                @click.stop.prevent="$emit('previewClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="play"></font-awesome-icon>
                </span>
                <span>Preview</span>
            </button>
        </div>
        <div class="panel-block">
            <span
                class="has-cursor-pointer icon is-flex has-margin-right-auto"
                @click="$emit('switchSideClick')"
            >
                <font-awesome-icon icon="exchange-alt"></font-awesome-icon>
            </span>
            <span
                class="has-cursor-pointer icon"
                @click="$emit('homeClick')"
            >
                <font-awesome-icon icon="home"></font-awesome-icon>
            </span>
        </div>
    </nav>
</template>
<script>
export default {
    props: {
        tutorials: {
            type: Array,
            default() {
                return []
            },
        },
        selectedTutorial: {
            type: Object,
            default: null,
        },
        selectedStep: {
            type: Object,
            default: null,
        },
    },
    data() {
        return {
            selectedTutorialId: null
        }
    },
    watch: {
        selectedTutorial: {
            immediate: true,
            handler (value) {
                if (value) {
                    this.selectedTutorialId = value.id
                }
            }
        }
    },
    methods: {
        onTutorialChange(tutorialId) {
            this.$emit('tutorialChange', tutorialId)
        }
    }
}
</script>
<style scoped>
    .tutorial-add-button {
        max-width: 80px !important;
    }
</style>