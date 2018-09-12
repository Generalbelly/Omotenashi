<template>
    <nav class="navbar level has-background-dark has-margin-bottom-0 has-padding-4 is-fixed-bottom">
        <div class="level-left">
            <h1 class="has-text-white is-size-4">Omotenashi</h1>
        </div>
        <div class="level-right">
            <p class="level-item">
                <button
                    class="button is-success"
                    @click.stop.prevent="$emit('actionClick')"
                >
                    {{ actionBtnTitle }}
                </button>
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
    export default {
        name: 'Navbar',
        props: {
            actionBtnTitle: {
                type: String,
                default: 'Get started',
            },
        },
    }
</script>
<style scoped>
    .navbar {
        top: unset;
        z-index: 10000000;
    }
</style>