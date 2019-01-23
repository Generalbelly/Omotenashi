<template>
    <div>
        <p class="has-padding-3">Copy and paste this code into the &lt;HEAD&gt; of a webpage you want to show a tutorial.</p>
        <textarea @click="$event.target.select()" readonly rows="3" cols="80" class="textarea"><script>(function(w,d,s,o,i){if(!w[o]){var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async = true;j.src = 'https://docker.omotenashi.today/omotenashi.js';j.onload=function(){w[o].init(i);};f.parentNode.insertBefore(j, f);}})(window,document,'script','Omotenashi','{{ userKey }}')</script></textarea>
    </div>
</template>

<script>
    export default {
        name: "TagTemplate",
        components: {
        },
        props: {
            userKey: {
                type: String,
                default: null,
            }
        }
    }
</script>

<style scoped>
    .textarea {
        font-family: courier new,courier;
        font-size: 12px;
        max-width: 800px;
        overflow: auto;
        resize: none;
        user-select: all;
    }
</style>