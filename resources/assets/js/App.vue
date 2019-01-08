<template>
    <div>
        <header class="level container">
            <div class="level-left">
                <div class="level-item">Logo</div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <router-link :to="{ name : 'projects.index'}">
                        Projects
                    </router-link>
                </div>
                <div class="level-item">
                    <a>Settings</a>
                </div>
                <div class="level-item">
                    <a>Log out</a>
                </div>
            </div>
        </header>
        <main class="container">
            <router-view>
            </router-view>
        </main>
        <section
            v-if="showExtensionLink"
            class="hero"
        >
            <div class="hero-body has-text-centered is-size-4">
                Have you installed our chrome extension yet?<br>
                It is required to create tutorials.
                <div class="has-margin-5">
                    <a
                        class="button is-complementary"
                        href=""
                        target="_blank"
                    >
                        Install the extension
                    </a>
                </div>
            </div>
        </section>
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
    import ProjectsPage from "./components/pages/ProjectsPage/ProjectsPage";
    export default {
        name: "App",
        components: {
            ProjectsPage
        },
        data() {
            return {
                showExtensionLink: false,
                extensionId: 'jliejbgijlgcajpkjamdclilnnccpebg',
            }
        },
        mounted() {
            this.checkIfExtensionInstalled()
        },
        methods: {
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
</style>