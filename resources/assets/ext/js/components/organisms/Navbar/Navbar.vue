<template>
    <nav class="navbar level has-background-dark has-margin-bottom-0 has-padding-5 is-fixed-bottom">
        <div class="level-left">
            <base-header
                :level="1"
                class="has-text-white has-cursor-pointer"
                @click.native="$emit('click:logo')"
            >
                Omotenashi
            </base-header>
        </div>
        <div class="level-right">
            <p class="level-item">
                <base-button
                    is-primary
                    @click="$emit('click:tutorials-button')"
                >
                    Tutorials
                </base-button>
            </p>
        </div>
    </nav>
</template>
<script>
    import BaseButton from '../../atoms/BaseButton'
    import BaseHeader from "../../atoms/BaseHeader"

    export default {
        name: 'Navbar',
        components: {
            BaseHeader,
            BaseButton,
        },
    }
</script>