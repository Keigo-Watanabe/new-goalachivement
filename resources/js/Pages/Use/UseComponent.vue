<template>
  <app-layout>
    <div class="home-content">

      <!-- 使い方ページ -->
      <div class="use-container">

        <!-- 使い方ナビゲーションセクション -->
        <div class="use-nav-section">
          <div class="goal-show-back">
            <a class="back-goal-list" href="/home"><i class="fas fa-angle-left"></i>ホームへ戻る</a>
          </div>

          <div class="use-nav-container">
            <ul class="app-use-section-list">
              <li class="app-use-section-item">ホーム</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/1">目標設定の仕方</a></li>
                <li class="app-use-item"><a href="/use/2">目標のタスクを追加する方法</a></li>
                <li class="app-use-item"><a href="/use/3">目標詳細の見方</a></li>
                <li class="app-use-item"><a href="/use/4">目標内容を変更する</a></li>
                <li class="app-use-item"><a href="/use/5">目標を削除する</a></li>
                <li class="app-use-item"><a href="/use/6">目標タスク一覧の絞り込み</a></li>
                <li class="app-use-item"><a href="/use/7">目標タスク一覧のガントチャートとは？</a></li>
                <li class="app-use-item"><a href="/use/8">目標一覧の絞り込み</a></li>
              </ul>

              <li class="app-use-section-item">タスク</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/9">タスク一覧の絞り込み</a></li>
                <li class="app-use-item"><a href="/use/10">タスク一覧の並び替え</a></li>
                <li class="app-use-item"><a href="/use/11">タスク内容を変更する</a></li>
                <li class="app-use-item"><a href="/use/12">タスクを削除する</a></li>
                <li class="app-use-item"><a href="/use/13">タスク一覧のマトリクスとは？</a></li>
              </ul>

              <li class="app-use-section-item">カレンダー</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/14">予定追加の仕方</a></li>
                <li class="app-use-item"><a href="/use/15">予定を変更する</a></li>
                <li class="app-use-item"><a href="/use/16">予定を削除する</a></li>
              </ul>

            </ul>
          </div>
        </div>

        <!-- 使い方解説セクション -->
        <div class="use-description-section">
          <slot></slot>
        </div>
      </div>

    </div>
  </app-layout>
</template>

<script>
  import AppLayout from '@/Layouts/AppLayout.vue'

  export default {

    components: {
      AppLayout,
    }

  }
</script>
