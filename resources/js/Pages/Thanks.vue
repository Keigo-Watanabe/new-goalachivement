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

      <div class="thanks-container">
        <div class="thanks-title">
          <h2>お問い合わせいただきありがとうございます。</h2>
          <span>お問い合わせが送信されました。</span>
        </div>

        <div class="thanks-content">
          <a href="/">ホームに戻る</a>
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
  }
</script>
