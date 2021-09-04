<template>
    <div v-show="message">
        <p class="input-error-message">
            {{ message }}
        </p>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
