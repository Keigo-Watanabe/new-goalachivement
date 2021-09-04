<template>
    <div v-if="hasErrors">
        <div class="auth-error-message">入力に誤りがあります。</div>

        <ul class="auth-error-list">
            <li v-for="(error, key) in errors" :key="key" class="auth-error-item">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
