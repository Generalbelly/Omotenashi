<template>
    <div id="omotenashi">
        <Navbar
            class="navbar"
            v-show="!tutorialFeature.isActivated"
            @actionClick="tutorialFeature.isActivated = true"
        ></Navbar>
        <GreetingModal
            v-show="extLog.userIsFirstTime"
            @startClick="onStartClick"
        ></GreetingModal>
        <TutorialPage
            v-show="tutorialFeature.isActivated"
            @closeClick="tutorialFeature.isActivated = false"
        >
        </TutorialPage>
    </div>
</template>
<script>
    import TutorialPage from './components/pages/TutorialPage'
    import GreetingModal from './components/organisms/GreetingModal'
    import Navbar from "./components/organisms/Navbar"

    import {
        mapActions,
        mapState
    } from 'vuex'

    export default {
        components: {
            Navbar,
            TutorialPage,
            GreetingModal,
        },
        data() {
            return {
                tutorialFeature: {
                    isActivated: false,
                },
            }
        },
        computed: {
            ...mapState([
                'extLog'
            ]),
        },
        created() {
            this.retrieveLog()
            console.log(this.extLog);
        },
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog'
            ]),
            onStartClick() {
                if (this.extLog.userIsFirstTime) {
                    this.saveLog({ userIsFirstTime: false })
                }
            }
        },
    }
</script>

<style>
    #omotenashi > .navbar {
        top: unset;
        z-index: 10000000 !important;
    }
    #omotenashi > .navbar:after,
    #omotenashi > .navbar:before {
        content: none;
    }
</style>