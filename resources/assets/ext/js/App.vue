<template>
    <div id="omotenashi" :class="{ 'font-size-fixer': needsFontSizeFixer }">
        <navbar
            v-show="showNav"
            @click:tutorials-button="onClickTutorialsButton"
            @click:logo="onClickLogo"
        ></navbar>
        <greeting-modal
            v-show="extLog.userIsFirstTime"
            @click:start="onClickStart"
        ></greeting-modal>
        <tutorial-page
            v-show="showTutorials"
            @click:close="onClickCloseTutorialPage"
            ref="tutorialPage"
        >
        </tutorial-page>
    </div>
</template>
<script>
    import TutorialPage from './components/pages/TutorialsPage'
    import GreetingModal from './components/organisms/GreetingModal'
    import Navbar from "./components/organisms/Navbar"
    import ProjectNotFoundModal from "./components/organisms/ProjectNotFoundModal"
    import {
        mapActions,
        mapState
    } from 'vuex'

    export default {
        name: 'App',
        components: {
            ProjectNotFoundModal,
            Navbar,
            TutorialPage,
            GreetingModal,
        },
        data() {
            return {
                showNav: true,
                showTutorials: false,
                needsFontSizeFixer: false,
            }
        },
        computed: {
            ...mapState([
                'extLog',
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
            onClickStart() {
                if (this.extLog.userIsFirstTime) {
                    this.saveLog({ userIsFirstTime: false })
                }
            },
            isFontSizeInPixel(fontSize) {
                return !!/px$/.exec(fontSize)
            },
            getRootElementFontSize() {
                return window.getComputedStyle(document.documentElement).getPropertyValue('font-size')
            },
            onClickLogo() {
                window.open(
                    process.env.APP_URL,
                    '_blank'
                );
            },
            onClickTutorialsButton() {
                this.showNav = false
                this.showTutorials = true
            },
            onClickCloseTutorialPage() {
                this.showTutorials = false
                this.showNav = true
            },
        },
    }
</script>

<style>
    #omotenashi {
        z-index: 2147483648 !important;
        position: relative;
    }
    #omotenashi > .navbar {
        top: unset;
    }
    #omotenashi > .navbar:after,
    #omotenashi > .navbar:before {
        content: none;
    }
    #omotenashi.font-size-fixer * {
        font-size: 16px;
    }
</style>