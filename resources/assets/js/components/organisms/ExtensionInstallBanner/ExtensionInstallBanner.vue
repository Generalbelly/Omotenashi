<template>
    <section
        class="is-flex has-padding-y-4 has-padding-x-6 has-background-white"
    >
        <div class="is-size-5 has-margin-right-auto">
            Seems like you haven't installed our chrome extension yet. It is required to create tutorials.
        </div>
        <div>
            <a
                class="button is-accent-300"
                target="_blank"
            >
                Install the extension
            </a>
        </div>
    </section>
</template>

<script>
    export default {
        name: "ExtensionInstallBanner",
    }
</script>

<style scoped>

</style>