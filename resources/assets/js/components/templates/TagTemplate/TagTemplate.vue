<template>
    <div>
        <p class="has-padding-3">Copy and paste this code into the &lt;HEAD&gt; of a webpage you want to show a tutorial.</p>
        <textarea id="tag" @click="$event.target.select()" readonly rows="3" cols="80" class="textarea"><script>(function(w,d,s,o,i){if(!w[o]){var f=d.getElementsByTagName(s)[0],j=d.createElement(s);j.async = true;j.src = {{ url }};j.onload=function(){w[o].init(i);};f.parentNode.insertBefore(j, f);}})(window,document,'script','Omotenashi','{{ userKey }}')</script></textarea>
        <b-tooltip
            type="is-black"
            :active="copiedInClipboard"
            label="Copied!"
            position="is-bottom"
            animated
        >
            <button
                id="copy-in-clipboard"
                class="button has-margin-top-4"
                data-clipboard-target="#tag"
                @mouseenter="copiedInClipboard = false"
            >
                Copy to clipboard
            </button>
        </b-tooltip>
    </div>
</template>

<script>
    import ClipboardJS from 'clipboard'

    export default {
        name: "TagTemplate",
        components: {
        },
        props: {
            userKey: {
                type: String,
                default: null,
            }
        },
        data() {
            return {
                copiedInClipboard: false,
                url: process.env.SCRIPT_URL,
            }
        },
        created() {
            const clipboard = new ClipboardJS('#copy-in-clipboard')
            clipboard.on('success', this.onCopySuccess)
        },
        methods: {
            onCopySuccess() {
                this.copiedInClipboard = true
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