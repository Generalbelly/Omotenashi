<template>
    <level>
        <level-left>
            <slot name="left"></slot>
        </level-left>
        <level-right>
            <slot name="right"></slot>
        </level-right>
    </level>
</template>

<script>
    import Level from "../../atoms/Level";
    import LevelRight from "../../atoms/LevelRight";
    import LevelLeft from "../../atoms/LevelLeft";
    export default {
        name: 'LevelBlock',
        components: {
            Level,
            LevelLeft,
            LevelRight
        },
    };
</script>

<style>

</style>