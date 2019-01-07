<template>
    <div class="field">
        <base-label
            v-if="label"
            :is-small="isSmall"
            :is-medium="isMedium"
            :is-large="isLarge"
        >
            {{ label }}
        </base-label>
        <p
            class="control has-icons-right"
            :class="{
                'has-icons-left': icon,
                'is-loading': isLoading
            }"
        >
            <slot></slot>
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
    import sizable from '../../mixins/sizable'
    import fieldable from '../../mixins/fieldable'
    import BaseIcon from "../BaseIcon"
    import BaseLabel from "../BaseLabel";

    export default {
        name: "BaseField",
        mixins: [
            colorable,
            fieldable,
            sizable,
        ],
        components: {
            BaseLabel,
            BaseIcon,
        },
        computed: {
            typeIcon() {
                if (this.isSuccess) return 'check'
                if (this.isDanger) return 'exclamation-circle'
                return false
            },
        },
    }
</script>

<style scoped>
    .label {
        text-align: left;
    }
</style>