<template>
    <label
        class="label"
        :class="sizableProps"
    >
        <slot></slot>
    </label>
</template>

<script>
    import sizable from '../../../../ext/js/components/mixins/sizable';

    export default {
        name: 'BaseLabel',
        mixins: [
            sizable,
        ],
    }
</script>
