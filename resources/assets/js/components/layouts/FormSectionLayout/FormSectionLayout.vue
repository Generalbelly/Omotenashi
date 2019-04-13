<template>
    <columns>
        <column
            v-if="shouldHaveMultipleColumns"
            class="is-two-fifths"
        >
            <sub-heading
                v-if="$slots.title"
                class="has-text-weight-bold has-margin-bottom-4"
            >
                <slot name="title"></slot>
            </sub-heading>
            <p v-if="$slots.description">
                <slot name="description"></slot>
            </p>
        </column>
        <column>
            <slot name="form"></slot>
        </column>
    </columns>
</template>

<script>
    import SubHeading from "../../atoms/SubHeading/SubHeading";
    import Columns from "../../atoms/Columns/Columns";
    import Column from "../../atoms/Column/Column";

    export default {
        name: "FormSectionLayout",
        components: {
            Column,
            Columns,
            SubHeading,
        },
        computed: {
            shouldHaveMultipleColumns() {
                return this.$slots.title || this.$slots.description
            }
        }
    }
</script>

<style scoped>
    .columns {
        margin-bottom: 2em;
    }
    .column > .field {
        margin-bottom: 3em;
    }
</style>