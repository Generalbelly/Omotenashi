<template>
    <span
        class="icon"
        @click="$emit('click')"
        :class="classes"
    >
        <font-awesome-icon
            :icon="icon"
        ></font-awesome-icon>
    </span>
</template>

<script>
    import colorable from '../../mixins/colorable';
    import sizable from '../../mixins/sizable';

    export default {
        name: 'BaseIcon',
        mixins: [
            colorable,
            sizable
        ],
        props: {
            icon: {
                type: String,
                default: null,
            },
        },
        computed: {
            classes() {
                return {
                    ...this.colorClasses,
                    ...this.sizeClasses,
                }
            }
        }
    }
</script>