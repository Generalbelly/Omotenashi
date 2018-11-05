<template>
    <nav class="navbar level has-background-dark has-margin-bottom-0 has-padding-4 is-fixed-bottom">
        <div class="level-left">
            <h1 class="has-text-white is-size-4 has-text-weight-bold">Omotenashi</h1>
        </div>
        <div class="level-right">
            <p class="level-item">
                <BaseButton
                    is-success
                    @click="$emit('actionClick')"
                >
                    Tutorials
                </BaseButton>
            </p>
            <p class="level-item">
                <a class="button" href="#">
                    Feedback
                </a>
            </p>
        </div>
    </nav>
</template>
<script>
    import BaseButton from '../../../../../js/components/atoms/BaseButton'

    export default {
        name: 'Navbar',
        components: {
            BaseButton,
        }
    }
</script>
<style scoped>
    .navbar {
        top: unset;
        z-index: 10000000;
    }
    .navbar:after,
    .navbar:before {
        content: none;
    }
</style>