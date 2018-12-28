<template>
    <nav class="panel has-background-white menu">
        <p class="panel-heading level has-margin-bottom-0">
            <span class="is-size-4 has-text-weight-semibold">Tutorial</span>
            <BaseButton
                is-primary
                has-text-white
                class="tutorial-add-button"
                @click="$emit('addTutorialClick')"
            >
                <BaseIcon icon="plus"></BaseIcon>
                <span>Add</span>
            </BaseButton>
        </p>
        <div
            class="panel-block level has-margin-bottom-0"
        >
            <template v-if="isLoading">
                <div class="menu__loading-screen">
                    <BaseProgressCircular is-small>
                    </BaseProgressCircular>
                </div>
            </template>
            <template v-else-if="tutorials.length > 0">
                <BaseSelectField
                    class="has-margin-right-3"
                    :value="selectedTutorial ? selectedTutorial.id : null"
                    @change="e => $emit('tutorialChange', e)"
                    :items="tutorials"
                    item-value="id"
                    item-text="name"
                ></BaseSelectField>
                <div class="field is-grouped has-margin-left-auto">
                    <span
                        class="control"
                    >
                        <BaseButton @click="$emit('editTutorialClick')">
                            <BaseIcon icon="pen"></BaseIcon>
                            <span>Edit</span>
                        </BaseButton>
                    </span>
                        <span class="control">
                        <BaseButton @click="$emit('deleteTutorialClick')">
                            <BaseIcon icon="trash"></BaseIcon>
                            <span>Delete</span>
                        </BaseButton>
                    </span>
                </div>
            </template>
            <template v-else>
                You haven't added any tutorials yet.
            </template>
        </div>
        <template v-if="selectedTutorial && !isLoading">
            <a
                class="panel-block has-padding-top-4 has-padding-bottom-4"
                :key="step.id"
                v-for="(step, stepIndex) in selectedTutorial.steps"
                :class="{ 'is-active':isActiveStep(step) }"
                @click.stop="$emit('stepClick', step.id)"
            >
                <span class="panel-icon">
                    <font-awesome-icon icon="circle"></font-awesome-icon>
                </span>
                    Step {{ stepIndex+1 }}
                <span
                    class="panel-icon block has-margin-left-auto has-cursor-pointer"
                    @click.stop="$emit('deleteStepClick', step.id)"
                >
                    <font-awesome-icon icon="trash"></font-awesome-icon>
                </span>
            </a>
            <div class="panel-block">
                <BaseButton
                    is-link
                    is-outlined
                    is-fullwidth
                    @click="$emit('addStepClick')"
                >
                    <BaseIcon icon="plus"></BaseIcon>
                    <span>Add Step</span>
                </BaseButton>
            </div>
            <div class="panel-block">
                <BaseButton
                    is-primary
                    is-outlined
                    is-fullwidth
                    @click="$emit('previewClick')"
                >
                    <BaseIcon icon="play"></BaseIcon>
                    <span>Preview</span>
                </BaseButton>
            </div>
        </template>
        <div class="panel-block">
            <BaseIcon
                class="has-cursor-pointer has-margin-left-auto"
                icon="exchange-alt"
                @click="onSwitchSideClick"
            >
            </BaseIcon>
        </div>
        <BaseIcon
            class="menu__close-button has-cursor-pointer"
            :class="{ 'menu__close-button--is-on-left': !isOnRight }"
            icon="times"
            @click="$emit('closeClick')"
            has-background-gray
        >
        </BaseIcon>
    </nav>
</template>
<script>
    import BaseButton from '../../atoms/BaseButton'
    import BaseSelectField from '../../atoms/BaseSelectField'
    import BaseIcon from '../../atoms/BaseIcon'
    import BaseProgressCircular from '../../atoms/BaseProgressCircular'

    export default {
        components: {
            BaseIcon,
            BaseButton,
            BaseSelectField,
            BaseProgressCircular
        },
        props: {
            isLoading: {
                type: Boolean,
                default: false,
            },
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
                isOnRight: true,
            }
        },
        methods: {
            onSwitchSideClick() {
                this.isOnRight = !this.isOnRight
                this.$emit('switchSideClick')
            },
            isActiveStep(step) {
                if (!this.selectedStep) return false
                return step.id === this.selectedStep.id
            }
        }
    }
</script>
<style scoped>
    .tutorial-add-button {
        max-width: 80px !important;
    }
    .panel-heading,
    .panel-block {
        padding: 18px 20px !important;
    }
    .menu {
        width: 400px;
    }
    .menu__loading-screen {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }
    .menu__close-button {
        position: absolute;
        left: -16px;
        top: -16px;
        right: unset;
        padding: 16px;
        background-color: #2f2f2f;
        color: white;
        border-radius: 16px;
    }
    .menu__close-button--is-on-left {
        left: unset;
        right: -16px;
    }
</style>