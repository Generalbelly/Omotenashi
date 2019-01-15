<template>
    <div>
        <nav class="navbar is-spaced has-shadow" role="navigation" aria-label="main navigation">
            <div class="container">
                <div class="navbar-brand">
                    <span class="navbar-item">
                        <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
                    </span>
                    <a
                        role="button"
                        class="navbar-burger burger"
                        :class="{'is-active': burgerMenuActive}"
                        aria-label="menu"
                        aria-expanded="false"
                        @click="burgerMenuActive = !burgerMenuActive"
                    >
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                        <span aria-hidden="true"></span>
                    </a>
                </div>

                <div
                    class="navbar-menu"
                    :class="{'is-active': burgerMenuActive}"
                >
                    <div class="navbar-start has-text-centered-mobile">
                        <router-link class="navbar-item" :to="{ name : 'projects.index'}">
                            <b-icon icon="book" class="has-text-primary" size="is-small"></b-icon>
                            <span>Projects</span>
                        </router-link>
                        <router-link class="navbar-item" :to="{ name : 'projects.index'}">
                            <b-icon icon="cog" class="has-text-grey-light" size="is-small"></b-icon>
                            <span>Settings</span>
                        </router-link>
                        <router-link class="navbar-item" :to="{ name : 'tags.show', params: { id: 'jojojo' }}">
                            <b-icon icon="code" class="has-text-success" size="is-small"></b-icon>
                            <span>Your tag</span>
                        </router-link>
                    </div>

                    <div class="navbar-end has-text-centered-mobile">
                        <a class="navbar-item" href="/logout">
                            <b-icon icon="sign-out-alt" size="is-small"></b-icon>
                            <span>Log out</span>
                        </a>
                    </div>
                </div>
            </div>
        </nav>
        <main class="container has-padding-5">
            <router-view>
            </router-view>
        </main>
        <extension-install-banner v-if="showExtensionLink">
        </extension-install-banner>
        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                    &copy; 2018 Omotenashi
                </p>
            </div>
        </footer>
    </div>
</template>

<script>
    import { mapState, mapActions } from "vuex";
    import ProjectsPage from "./components/pages/ProjectsPage/ProjectsPage";
    import ExtensionInstallBanner from "./components/organisms/ExtensionInstallBanner/ExtensionInstallBanner";
    export default {
        name: "App",
        components: {
            ExtensionInstallBanner,
            ProjectsPage
        },
        data() {
            return {
                showExtensionLink: false,
                extensionId: process.env.CHROME_EXTENSION_ID,
                burgerMenuActive: false,
            }
        },
        created() {
            this.setUser(userEntity);
        },
        mounted() {
            this.checkIfExtensionInstalled()
        },
        methods: {
            ...mapActions([
                'setUser',
            ]),
            checkIfExtensionInstalled() {
                const self = this;
                chrome.runtime.sendMessage(this.extensionId, { message: "version" }, (response) => {
                    if (response && response.state === 'success') {
                        self.showExtensionLink = false
                    } else {
                        self.showExtensionLink = true
                    }
                })
            },
        }
    }
</script>

<style scoped>
    a.navbar-item > .icon {
        margin-left: -.25em;
        margin-right: .25em;
    }
</style>