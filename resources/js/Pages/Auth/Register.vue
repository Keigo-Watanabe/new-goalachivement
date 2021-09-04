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
              <span>会員登録</span>
            </div>

            <jet-validation-errors/>

            <form @submit.prevent="submit">
                <div class="auth-form-item">
                    <jet-label for="name" value="ユーザー名" />
                    <jet-input id="name" type="text" v-model="form.name" required autofocus autocomplete="name" />
                </div>

                <div class="auth-form-item">
                    <jet-label for="email" value="メールアドレス" />
                    <jet-input id="email" type="email" v-model="form.email" required />
                </div>

                <div class="auth-form-item">
                    <jet-label for="password" value="パスワード" />
                    <jet-input id="password" type="password" v-model="form.password" required autocomplete="new-password" />
                </div>

                <div class="auth-form-item">
                    <jet-label for="password_confirmation" value="パスワードの確認" />
                    <jet-input id="password_confirmation" type="password" v-model="form.password_confirmation" required autocomplete="new-password" />
                </div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature">
                    <jet-label for="terms">
                        <div class="flex items-center">
                            <jet-checkbox name="terms" id="terms" v-model:checked="form.terms" />

                            <div class="ml-2">
                                I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                            </div>
                        </div>
                    </jet-label>
                </div>

                <div>
                    <Link :href="route('login')" class="auth-link-btn">
                        既に登録済みですか？
                    </Link>

                    <jet-button :disabled="form.processing">
                        会員登録
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

        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
