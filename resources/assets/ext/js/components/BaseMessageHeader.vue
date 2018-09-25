<template>
    <div
        class="message-header"
    >
        <slot></slot>
        <button
            class="delete is-paddingless"
            aria-label="delete"
            @click.stop="$emit('closeClick')"
        ></button>
    </div>
</template>
<script>
    export default {
        name: 'BaseMessageHeader',
    }
</script>
