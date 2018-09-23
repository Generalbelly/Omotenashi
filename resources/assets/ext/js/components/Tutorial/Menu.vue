<template>
    <nav class="panel has-background-white">
        <p class="panel-heading level has-margin-bottom-0">
            <span class="is-size-4 has-text-weight-semibold">Tutorial</span>
            <BaseButton
                :classes="['has-background-grey', 'has-text-white', 'tutorial-add-button']"
                @click="$emit('addTutorialClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </span>
                <span>Add</span>
            </BaseButton>
        </p>
        <p class="panel-block level has-margin-bottom-0">
            <span class="select">
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
            </span>
            <span class="field is-grouped has-margin-left-auto">
                <p class="control">
                    <BaseButton
                        @click="$emit('editTutorialClick')"
                    >
                        <span class="icon">
                            <font-awesome-icon icon="pen"></font-awesome-icon>
                        </span>
                        <span>Edit</span>
                    </BaseButton>
                </p>
                <p class="control">
                    <BaseButton
                        v-show="tutorials.length > 1"
                        @click="$emit('deleteTutorialClick')"
                    >
                        <span class="icon">
                            <font-awesome-icon icon="trash"></font-awesome-icon>
                        </span>
                        <span>Delete</span>
                    </BaseButton>
                </p>
            </span>
        </p>
        <template v-if="selectedTutorial">
            <a
                class="panel-block has-padding-top-4 has-padding-bottom-4"
                :key="step.id"
                v-for="(step, stepIndex) in selectedTutorial.steps"
                :class="{ 'is-active':isActiveStep(step) }"
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
        </template>
        <div class="panel-block">
            <BaseButton
                :classes="['is-link', 'is-outlined', 'is-fullwidth']"
                @click="$emit('addStepClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="plus"></font-awesome-icon>
                </span>
                <span>Add Step</span>
            </BaseButton>
        </div>
        <div class="panel-block">
            <BaseButton
                :classes="['is-primary', 'is-outlined', 'is-fullwidth']"
                @click="$emit('previewClick')"
            >
                <span class="icon">
                    <font-awesome-icon icon="play"></font-awesome-icon>
                </span>
                <span>Preview</span>
            </BaseButton>
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
    import BaseButton from '../BaseButton'
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
            },
            isActiveStep(step) {
                return this.selectedStep && step.id === this.selectedStep.id
            }
        },
        components: {
            BaseButton,
        }
    }
</script>
<style scoped>
    .tutorial-add-button {
        max-width: 80px !important;
    }
    .panel-heading,
    .panel-block {
        padding: 1em !important;
    }
</style>