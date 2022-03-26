<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標設定の仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>ホーム画面の「新しい目標を設定する」を押し、「目標」と「達成日」を入力して「設定」ボタンを押してください。</p>

        <ul class="use-description-list">
          <li class="use-description-item">ホーム画面の「新しい目標を設定する」ボタンをクリック。</li>
          <li class="use-description-item">目標設定画面で「目標」と「達成日」を入力。</li>
          <li class="use-description-item">「設定」ボタンをクリック。</li>
        </ul>

        <span class="alert-description">※「目標」と「達成日」は必須項目です。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop muted playsinline>
          <source src="/movies/use1.mov">
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
