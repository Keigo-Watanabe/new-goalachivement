<template>
    <jet-form-section @submitted="updatePassword">
        <template #title>
            パスワードの更新
        </template>

        <template #description>
            アカウントの安全性を保つために、長いランダムなパスワードを使用していることを確認してください。
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_password" value="現在のパスワード" />
                <jet-input id="current_password" type="password" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                <jet-input-error :message="form.errors.current_password"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="新しいパスワード" />
                <jet-input id="password" type="password" v-model="form.password" ref="password" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password"/>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password_confirmation" value="パスワードの確認" />
                <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" autocomplete="new-password" />
                <jet-input-error :message="form.errors.password_confirmation"/>
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful">
                保存しました。
            </jet-action-message>

            <jet-button :disabled="form.processing" class="profile-form-btn">
                保存する
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetLabel from '@/Jetstream/Label.vue'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => this.form.reset(),
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            },
        },
    }
</script>
