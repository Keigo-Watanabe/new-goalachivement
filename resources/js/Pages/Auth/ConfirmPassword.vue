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
      </div>

      <jet-authentication-card>

          <div class="auth-forgot-password-message">
              This is a secure area of the application. Please confirm your password before continuing.
          </div>

          <jet-validation-errors/>

          <form @submit.prevent="submit">
              <div>
                  <jet-label for="password" value="パスワード" />
                  <jet-input id="password" type="password" v-model="form.password" required autocomplete="current-password" autofocus />
              </div>

              <div class="">
                  <jet-button :disabled="form.processing">
                      確認
                  </jet-button>
              </div>
          </form>
      </jet-authentication-card>
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

        data() {
            return {
                form: this.$inertia.form({
                    password: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.confirm'), {
                    onFinish: () => this.form.reset(),
                })
            }
        }
    }
</script>
