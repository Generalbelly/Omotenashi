<template>
    <div>
        <textarea readonly rows="9" cols="80" class="textarea">
            <script>(function(w,d,s,o,i){if(!w[o]){var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async = true;j.src = 'https://docker.omotenashi.today/omotenashi.js';j.onload=function(){w[o].init(i);};f.parentNode.insertBefore(j, f);}})(window,document,'script','Omotenashi','bac33d35-7067-42f8-a6fb-e54e68c9e21e')</script>
        </textarea>
    </div>
</template>

<script>
    export default {
        name: "TagTemplate",
        components: {
        },
        props: {
        },
        data() {
            return {}
        }
    }
</script>

<style scoped>
    .modal-card-foot {
        flex-direction: column;
    }
    .modal-card-foot > .level {
        width: 100%;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    .textarea {
        font-family: courier new,courier;
        font-size: 12px;
        max-width: 800px;
        overflow: auto;
        resize: none;
    }
</style>