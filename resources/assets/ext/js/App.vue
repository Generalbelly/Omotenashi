<template>
    <div id="omotenashi">
        <Navbar
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
        created() {
            console.log(_ot_ext_token);
        },
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
            ...mapState(['extLog']),
        },
        created() {
            this.retrieveLog()
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
