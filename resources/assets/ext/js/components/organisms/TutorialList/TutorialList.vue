<template>
    <base-panel class="has-background-white list">
        <base-panel-header class="has-margin-bottom-0">
            <base-header
                :level="2"
            >Tutorials</base-header>
            <base-button
                is-primary
                is-outlined
                has-text-white
                class="tutorial-add-button"
                @click="$emit('addTutorialClick')"
                icon="plus"
            >
                Add
            </base-button>
        </base-panel-header>
        <base-panel-block class="level has-margin-bottom-0">
            <template v-if="isLoading">
                <div class="list__loading-screen">
                    <base-progress-circular is-small>
                    </base-progress-circular>
                </div>
            </template>
            <template v-else-if="tutorialEntities.length > 0">
                <div class="selected-tutorial">
                    <select-field
                        is-fullwidth
                        class="is-marginless"
                        :value="selectedTutorial ? selectedTutorial.id : null"
                        @input="$emit('tutorialChange', $event)"
                        :items="tutorialEntities"
                        item-value="id"
                        item-text="name"
                        no-item-selected-text="Select a tutorial"
                    ></select-field>
                    <span>
                        <base-icon
                            icon="pen"
                            @click="$emit('editTutorialClick')"
                        ></base-icon>
                    </span>
                    <span>
                        <base-icon
                            @click="$emit('deleteTutorialClick')"
                            icon="trash"
                        ></base-icon>
                    </span>
                </div>
            </template>
            <template v-else>
                You haven't added any tutorials yet.
            </template>
        </base-panel-block>
        <template v-if="selectedTutorial && !isLoading">
            <base-panel-block
                element="a"
                class="has-padding-top-4 has-padding-bottom-4"
                :class="{ 'is-active':isActiveStep(step) }"
                :key="step.id"
                v-for="(step, stepIndex) in selectedTutorial.steps"
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
            </base-panel-block>
            <base-panel-block style="flex-direction: column;">
                <base-button
                    is-primary
                    is-fullwidth
                    @click="$emit('addStepClick')"
                    icon="plus"
                    class="has-margin-bottom-5"
                >
                    Add Step
                </base-button>
                <base-button
                    is-fullwidth
                    @click="$emit('previewClick')"
                    icon="play"
                >
                    Preview
                </base-button>
            </base-panel-block>
        </template>
        <base-panel-block>
            <base-icon
                class="has-cursor-pointer has-margin-left-auto"
                icon="exchange-alt"
                @click="onSwitchSideClick"
            >
            </base-icon>
        </base-panel-block>
        <base-icon
            class="list__close-button has-cursor-pointer"
            :class="{ 'list__close-button--is-on-left': !isOnRight }"
            icon="times"
            @click="$emit('closeClick')"
            has-background-gray
        >
        </base-icon>
    </base-panel>
</template>
<script>
    import BaseButton from '../../atoms/BaseButton'
    import BaseIcon from '../../atoms/BaseIcon'
    import BaseProgressCircular from '../../atoms/BaseProgressCircular'
    import BaseHeader from "../../atoms/BaseHeader";
    import SelectField from "../../molecules/fields/SelectField";
    import BasePanel from "../../atoms/BasePanel/BasePanel";
    import BasePanelBlock from "../../atoms/BasePanelBlock";
    import BasePanelHeader from "../../atoms/BasePanelHeader";
    import BaseContent from "../../atoms/BaseContent/BaseContent";
    import BaseTile from "../../atoms/BaseTile/BaseTile";

    export default {
        name: 'TutorialList',
        components: {
            BaseTile,
            BaseContent,
            BasePanelHeader,
            BasePanelBlock,
            BasePanel,
            SelectField,
            BaseHeader,
            BaseIcon,
            BaseButton,
            BaseProgressCircular
        },
        props: {
            isLoading: {
                type: Boolean,
                default: false,
            },
            tutorialEntities: {
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
    .list {
        width: 400px;
    }
    .list__loading-screen {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
    }
    .list__close-button {
        position: absolute;
        left: -16px;
        top: -16px;
        right: unset;
        padding: 16px;
        background-color: #2f2f2f;
        color: white;
        border-radius: 16px;
    }
    .list__close-button--is-on-left {
        left: unset;
        right: -16px;
    }
    .selected-tutorial {
        display: grid;
        width: 100%;
        grid-template-columns: 1fr auto auto;
        grid-gap: 10px;
        align-items: center;
    }
</style>