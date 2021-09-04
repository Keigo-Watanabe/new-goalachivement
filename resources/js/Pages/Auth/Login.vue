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
              <span>ログイン</span>
            </div>

            <jet-validation-errors/>

            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div class="auth-form-item">
                    <jet-label for="email" value="メールアドレス" />
                    <jet-input id="email" type="email" v-model="form.email" required autofocus />
                </div>

                <div class="auth-form-item">
                    <jet-label for="password" value="パスワード" />
                    <jet-input id="password" type="password" v-model="form.password" required autocomplete="current-password" />
                </div>

                <div class="auth-form-item">
                    <label class="auth-remember-me">
                        <jet-checkbox name="remember" v-model:checked="form.remember" />
                        <span>ログイン状態を保持する</span>
                    </label>
                </div>

                <div>
                    <Link v-if="canResetPassword" :href="route('password.request')" class="auth-link-btn">
                        パスワードをお忘れですか？
                    </Link>

                    <jet-button :disabled="form.processing">
                        ログイン
                    </jet-button>
                </div>
            </form>
        </jet-authentication-card>

      </div>

    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Head,
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors,
            Link,
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
