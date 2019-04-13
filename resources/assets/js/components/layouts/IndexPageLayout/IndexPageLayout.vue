<template>
    <div>
        <template v-if="$slots.title">
            <slot name="title"></slot>
        </template>
        <template v-else>
            <heading>
                {{ title }}
            </heading>
        </template>
        <div class="level has-margin-bottom-5">
            <div class="level-left">
                <slot name="search"></slot>
            </div>
            <div class="level-right">
                <slot name="add"></slot>
            </div>
        </div>
        <slot name="table"></slot>
    </div>
</template>

<script>
    import Heading from "../../atoms/Heading";

    export default {
        name: "IndexPageLayout",
        components: {
            Heading,
        },
        props: {
            title: {
                type: String,
                default: null,
            }
        }
    }
</script>

<style scoped>

</style>