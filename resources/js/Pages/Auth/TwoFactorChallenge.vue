<template>

    <div class="lp-container">

      <!-- ファーストビュー -->
      <div class="firstview">

        <!-- ヘッダー -->
        <header class="lp-header">
          <!-- ヘッダーロゴ -->
          <h1>
            <a class="header-logo" href="/">
              <div class="logo-img"><img src="/image/app-logo.png"></div>
              <span class="goal-achivement-jp">目標達成</span>
              <span class="goal-achivement-en">- GoalAchivement -</span>
            </a>
          </h1>

          <div class="can-login auth-can-login">
            <a href="/register" class="header-nav-btn register-btn">会員登録</a>
            <a href="/login" class="header-nav-btn login-btn">ログイン</a>
          </div>
        </header>

        <jet-authentication-card>

            <div class="mb-4 text-gray-600">
                <template v-if="! recovery">
                    認証アプリから提供される認証コードを入力して、アカウントへのアクセスを確認してください。
                </template>

                <template v-else>
                    緊急復旧コードのいずれかを入力して、アカウントへのアクセスを確認してください。
                </template>
            </div>

            <jet-validation-errors class="mb-4" />

            <form @submit.prevent="submit">
                <div v-if="! recovery">
                    <jet-label for="code" value="コード" />
                    <jet-input ref="code" id="code" type="text" inputmode="numeric" class="mt-1 block w-full" v-model="form.code" autofocus autocomplete="one-time-code" />
                </div>

                <div v-else>
                    <jet-label for="recovery_code" value="リカバリーコード" />
                    <jet-input ref="recovery_code" id="recovery_code" type="text" class="mt-1 block w-full" v-model="form.recovery_code" autocomplete="one-time-code" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="button" class="text-gray-600 hover:text-gray-900 underline cursor-pointer" @click.prevent="toggleRecovery">
                        <template v-if="! recovery">
                            リカバリーコードを使用する
                        </template>

                        <template v-else>
                            認証コードを使用する
                        </template>
                    </button>

                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        ログイン
                    </jet-button>
                </div>
            </form>
        </jet-authentication-card>
      </div>

    </div>
</template>

<script>
    import { Head } from '@inertiajs/inertia-vue3';
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default {
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetLabel,
            JetValidationErrors,
        },

        data() {
            return {
                recovery: false,
                form: this.$inertia.form({
                    code: '',
                    recovery_code: '',
                })
            }
        },

        methods: {
            toggleRecovery() {
                this.recovery ^= true

                this.$nextTick(() => {
                    if (this.recovery) {
                        this.$refs.recovery_code.focus()
                        this.form.code = '';
                    } else {
                        this.$refs.code.focus()
                        this.form.recovery_code = ''
                    }
                })
            },

            submit() {
                this.form.post(this.route('two-factor.login'))
            }
        }
    }
</script>
