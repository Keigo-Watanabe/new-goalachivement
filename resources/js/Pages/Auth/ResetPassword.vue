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

            <div class="auth-form-title">
              <span>パスワードの再発行</span>
            </div>

            <jet-validation-errors/>

            <form @submit.prevent="submit">
                <div>
                    <jet-label for="email" value="メールアドレス" />
                    <jet-input id="email" type="email" v-model="form.email" required autofocus />
                </div>

                <div>
                    <jet-label for="password" value="パスワード" />
                    <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
                </div>

                <div>
                    <jet-label for="password_confirmation" value="パスワードの確認" />
                    <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
                </div>

                <div>
                    <jet-button :disabled="form.processing">
                        パスワードのリセット
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
            JetValidationErrors
        },

        props: {
            email: String,
            token: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    token: this.token,
                    email: this.email,
                    password: '',
                    password_confirmation: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.update'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
