<template>
    <div id="omotenashi">
        <Navbar
            v-show="!tutorialFeature.isActivated"
            :action-btn-title="extLog.userIsFirstTime ? 'Get started': 'Tutorials'"
            @actionClick="tutorialFeature.isActivated = true"
        ></Navbar>
        <GreetingModal
            v-show="extLog.userIsFirstTime"
            @startClick="onStartClick"
        ></GreetingModal>
        <Tutorial
            v-show="tutorialFeature.isActivated"
            @homeClick="tutorialFeature.isActivated = false"
        >
        </Tutorial>
    </div>
</template>
<script>

    import Tutorial from './features/Tutorial'
    import GreetingModal from './components/App/GreetingModal'
    import Navbar from "./components/App/Navbar"
    import {
        mapActions,
        mapState
    } from 'vuex'

    export default {
        created() {
            this.retrieveLog()
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
        methods: {
            ...mapActions([
                'retrieveLog',
                'saveLog'
            ]),
            onStartClick() {
                if (this.extLog.userIsFirstTime) {
                    this.saveLog({userIsFirstTime: false})
                }
            }
        },
        components: {
            Navbar,
            Tutorial,
            GreetingModal,
        }
    }
</script>
