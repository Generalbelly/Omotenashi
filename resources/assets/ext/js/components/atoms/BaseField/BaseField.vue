<template>
    <div class="field">
        <label class="label">
            {{ label }}
        </label>
        <p
            class="control has-icons-right"
            :class="{
                'has-icons-left': icon,
                'is-loading': isLoading
            }"
        >
            <slot
                :readonly="readonly"
                :disabled="disabled"
                :is-loading="isLoading"
                :placeholder="placeholder"
                :class="inputClass"
            ></slot>
            <base-icon
                v-if="icon"
                :icon="icon"
                class="is-left"
                is-small
            ></base-icon>
            <base-icon
                v-if="typeIcon"
                :icon="typeIcon"
                class="is-right"
                :class="{
                    'has-text-success': isSuccess,
                    'has-text-danger': isDanger,
                }"
                is-small
            ></base-icon>
        </p>
        <template v-for="message in messages">
            <p
                class="help has-text-left"
                :class="{
                    'has-text-danger': isDanger,
                }"
            >
                {{ message }}
            </p>
        </template>
    </div>
</template>

<script>
    import colorable from '../../mixins/colorable'
    import stylable from '../../mixins/stylable'
    import statable from '../../mixins/statable'
    import fieldable from '../../mixins/fieldable'
    import BaseIcon from "../BaseIcon/BaseIcon"

    export default {
        name: "BaseField",
        mixins: [
            colorable,
            fieldable,
            stylable,
            statable
        ],
        components: {
            BaseIcon,
        },
        computed: {
            typeIcon() {
                if (this.isSuccess) return 'check'
                if (this.isDanger) return 'exclamation-circle'
                return false
            },
            inputClass() {
                return {
                    ...this.colorClasses,
                    ...this.sizeClasses,
                    ...this.styleClasses,
                    ...this.stateClasses,
                }
            }
        },
    }
</script>

<style scoped>
    .label {
        text-align: left;
    }
</style>