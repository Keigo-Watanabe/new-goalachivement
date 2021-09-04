<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>カレンダーの予定追加の仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>カレンダーで予定を追加したい日にちを選択し、「予定を追加する」を押すと予定を追加することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">カレンダー上で予定を追加したい日にちを選択。</li>
          <li class="use-description-item">「予定を追加する」ボタンをクリック。</li>
          <li class="use-description-item">「予定」と「開始時間」「終了時間」などを入力し、追加をクリック。</li>
        </ul>

        <span class="alert-description">※「予定」と「開始時間」は必須項目です。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use14.mov">
        </video>
      </div>

    </div>
  </use-component>
</template>

<script>
  import UseComponent from '@/Pages/Use/UseComponent.vue'

  export default {

    components: {
      UseComponent,
    },

  }
</script>
