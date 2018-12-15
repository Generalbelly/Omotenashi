<template>
    <div
        class="is-loading"
        :class="computedClass"
    ></div>
</template>

<script>
    import colorable from '../../../mixins/colorable';
    import sizable from '../../../mixins/sizable';

    export default {
        name: 'BaseProgressCircular',
        mixins: [
            colorable,
            sizable
        ],
        computed: {
            computedClass() {
                return {
                    ...this.sizeClasses,
                };
            },
        }
    }
</script>

<style scoped>

</style>