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

        <!-- ヘッダーナビゲーション -->
        <div id="header-nav" class="header-nav">
          <ul class="header-nav-list">
            <li class="header-nav-item"><a href="/#feature-section">具体的な使い方</a></li>
            <li class="header-nav-item"><a href="/contact">お問い合わせ</a></li>
          </ul>

          <div class="can-login">
            <a href="/register" class="header-nav-btn register-btn">会員登録</a>
            <a href="/login" class="header-nav-btn login-btn">ログイン</a>
          </div>
        </div>

        <!-- レスポンシブナビゲーション -->
        <div class="responsive-header-nav" v-on:click="addNav">
          <span class="bar bar1"></span>
          <span class="bar bar2"></span>
          <span class="bar bar3"></span>
        </div>
      </header>


      <!-- お問い合わせフォーム -->
      <div class="contact-form-container">
        <div class="contact-form-content">

          <div class="contact-form-title">
            <span>お問い合わせ</span>
          </div>

          <form class="contact-form" action="https://docs.google.com/forms/u/0/d/e/1FAIpQLScnFRx_u0mocj-Ea93Ff8uhrI-k3HZjGFHVqlmRV3FIhj-D_w/formResponse" method="post" target="hidden_iframe" onsubmit="submitted=true;">

            <div class="contact-form-item">
              <label class="contact-form-label">氏名</label>
              <input type="text" class="contact-form-input" name="entry.1472469240" maxlength="50" required>
            </div>

            <div class="contact-form-item">
              <label class="contact-form-label">メールアドレス</label>
              <input type="email" class="contact-form-input" name="entry.954343322" maxlength="100" required>
            </div>

            <div class="contact-form-item">
              <label class="contact-form-label">件名</label>
              <input type="text" class="contact-form-input" name="entry.1316688407" maxlength="50">
            </div>

            <div class="contact-form-item">
              <label class="contact-form-label">お問い合わせ内容</label>
              <textarea class="contact-form-textarea" name="entry.1670279904" maxlength="500" required></textarea>
            </div>

            <div class="contact-form-button">
              <button type="submit" class="submit-btn" v-on:click="sendForm">送信</button>
            </div>

          </form>

          <iframe name="hidden_iframe" id="hidden_iframe" style="display: none;" v-if="submitted"></iframe>
        </div>
      </div>

    </div>

  </div>

</template>

<script>
  import { Head, Link } from '@inertiajs/inertia-vue3';

  export default {

    components: {
      Head,
      Link,
    },

    data() {
      return {
        submitted: false,
      }
    },

    methods: {
      addNav() {
        const headerNav = document.getElementById('header-nav');

        headerNav.classList.toggle('header-nav-show');
      },

      sendForm() {
        window.location = '/thanks';
        this.submitted = true;
      },
    },
  }
</script>
