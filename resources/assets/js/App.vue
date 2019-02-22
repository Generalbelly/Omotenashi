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
                    <div class="navbar-start">
                        <router-link
                            :class="navItemClass('/projects')"
                            :to="{ name : 'projects.index'}"
                        >
                            <b-icon icon="book" class="has-text-primary" size="is-small"></b-icon>
                            <span>Projects</span>
                        </router-link>
                        <router-link
                            :class="navItemClass('/tags')"
                            :to="{ name : 'tags.show', params: { id: userKey }}"
                        >
                            <code-icon size="is-small"></code-icon>
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
            <router-view></router-view>
        </main>

        <extension-install-banner class="banner has-background-white-ter" v-if="showExtensionLink"></extension-install-banner>

        <!--<footer class="footer">-->
            <!--<div class="content has-text-centered">-->
                <!--<p>-->
                    <!--&copy; 2018 Omotenashi-->
                <!--</p>-->
            <!--</div>-->
        <!--</footer>-->
    </div>
</template>

<script>
    import { UNAUTHORIZED_401, UNAUTHORIZED_419, INTERNAL_SERVER_ERROR } from "./utils/constants";
    import { mapState, mapActions, mapGetters } from "vuex";
    import ProjectsPage from "./components/pages/ProjectsPage/ProjectsPage";
    import ExtensionInstallBanner from "./components/organisms/ExtensionInstallBanner";
    import CodeIcon from "./components/atoms/icons/CodeIcon";

    export default {
        name: "App",
        components: {
            CodeIcon,
            ExtensionInstallBanner,
            ProjectsPage,
        },
        data() {
            return {
                showExtensionLink: false,
                extensionId: process.env.CHROME_EXTENSION_ID,
                burgerMenuActive: false,
            }
        },
        computed: {
            ...mapState([
                'errorCode',
            ]),
            ...mapGetters([
                'userKey',
            ])
        },
        watch: {
            errorCode: {
                handler(value) {
                    if (value) {
                        switch (value) {
                            case UNAUTHORIZED_401:
                            case UNAUTHORIZED_419:
                                if (window.location.href === `https://${process.env.APP_URL}` ||
                                    window.location.href === 'https://localhost'
                                ) {
                                    window.location.href = `/login?from=${window.location.href}`
                                }
                                break
                            case INTERNAL_SERVER_ERROR:
                                this.showSnackbar()
                                break
                            default:
                                this.showSnackbar()
                                break
                        }
                    }
                },
                immediate: true,
            }
        },
        created() {
            this.setUser(iam);
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
            showSnackbar() {
                this.$snackbar.open({
                    position: 'is-top',
                    type: 'is-warning',
                    message: 'Oops! Something went wrong.',
                    indefinite: true,
                })
            },
            navItemClass(path) {
                return {
                    'has-text-primary': this.$route.path.includes(path),
                    'has-text-grey-light': !this.$route.path.includes(path),
                    'navbar-item': true,
                }
            }
        }
    }
</script>

<style scoped>
    a.navbar-item > .icon {
        margin-left: -.25em;
        margin-right: .25em;
    }
    .banner {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
    }
</style>