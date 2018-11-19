<template>
    <div class="container">
        <header class="level">
            <div class="level-left">
                <div class="level-item">Logo</div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    <a>Projects</a>
                </div>
                <div class="level-item">
                    <a>Settings</a>
                </div>
                <div class="level-item">
                    <a>Log out</a>
                </div>
            </div>
        </header>
        <main>
            <projects-page></projects-page>
        </main>
        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                    &copy; 2018 Nobuyoshi Shimmen
                </p>
            </div>
        </footer>
    </div>
</template>

<script>
    import ProjectsPage from "./components/pages/ProjectsPage/ProjectsPage";
    export default {
        name: "App",
        components: {ProjectsPage},
    }
</script>

<style scoped>

</style>