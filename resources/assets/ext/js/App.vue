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
        <project-not-found-modal
            v-show="projectNotFound"
        >
        </project-not-found-modal>
        <tutorial-page
            v-show="showTutorials"
            @click:close="onClickCloseTutorialPage"
        >
        </tutorial-page>
    </div>
</template>
<script>
    import TutorialPage from './components/pages/TutorialPage'
    import GreetingModal from './components/organisms/GreetingModal'
    import Navbar from "./components/organisms/Navbar"
    import ProjectNotFoundModal from "./components/organisms/ProjectNotFoundModal"
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
                showNav: true,
                showTutorials: false,
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
                    'https://docker.omotenashi.today',
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