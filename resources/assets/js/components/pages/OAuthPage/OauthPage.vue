<template>
    <tag-template
        :user-key="userKey"
    >
    </tag-template>
</template>

<script>
    import { mapGetters } from 'vuex'
    import TagTemplate from "../../templates/TagTemplate"

    export default {
        name: "OauthPage",
        components: {
            TagTemplate
        },
        computed: {
            ...mapGetters([
                'userKey',
            ])
        }
    }
</script>

<style scoped>
</style>