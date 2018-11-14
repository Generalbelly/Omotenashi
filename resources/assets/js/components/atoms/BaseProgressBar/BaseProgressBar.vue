<template>
    <progress
        v-if="value"
        class="progress"
        :class="progressBarClasses"
        max="100"
        :value="value"
    >
    </progress>
    <progress
        v-else
        class="progress"
        :class="progressBarClasses"
        max="100"
    >
    </progress>
</template>

<script>
    import colorable from '../../mixins/colorable';
    import sizable from '../../mixins/sizable';

    export default {
        name: 'BaseProgressBar',
        mixins: [
            colorable,
            sizable
        ],
        props: {
            value: {
                type: Number,
                default: null,
            }
        },
        computed: {
            progressBarClasses() {
                return {
                    ...this.sizeClasses,
                    ...this.colorClasses,
                }
            }
        }
    }
</script>
