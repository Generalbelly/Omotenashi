<template>
    <div id="omotenashi" :class="{ 'font-size-fixer': needsFontSizeFixer }">
        <Navbar
            class="navbar"
            v-show="!tutorialFeature.isActivated"
            @actionClick="tutorialFeature.isActivated = true"
        ></Navbar>
        <GreetingModal
            v-show="extLog.userIsFirstTime"
            @startClick="onStartClick"
        ></GreetingModal>
        <ProjectNotFoundModal
            v-show="projectNotFound"
        >
        </ProjectNotFoundModal>
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
    import ProjectNotFoundModal from "./components/organisms/ProjectNotFoundModal";
    import {
        mapActions,
        mapState
    } from 'vuex'

    export default {
        components: {
            ProjectNotFoundModal,
            Navbar,
            TutorialPage,
            GreetingModal,
        },
        data() {
            return {
                tutorialFeature: {
                    isActivated: false,
                },
                needsFontSizeFixer: false,
            }
        },
        computed: {
            ...mapState([
                'extLog',
                'projectNotFound',
            ]),
        },
        created() {
            this.retrieveLog()
        },
        mounted() {
            const fontSize = this.getRootElementFontSize()
            if (this.isFontSizeInPixel(fontSize)) {
                const size = fontSize.replace('px', '')
                if (size < 16) {
                    this.needsFontSizeFixer = true
                }
            }
        },
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog',
            ]),
            onStartClick() {
                if (this.extLog.userIsFirstTime) {
                    this.saveLog({ userIsFirstTime: false })
                }
            },
            isFontSizeInPixel(fontSize) {
                return !!/px$/.exec(fontSize)
            },
            isFontSizeInPercentage(fontSize) {
                return !!/%$/.exec(fontSize)
            },
            getRootElementFontSize() {
                return window.getComputedStyle(document.documentElement).getPropertyValue('font-size')
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
    #omotenashi.font-size-fixer * {
        font-size: 16px;
    }
</style>