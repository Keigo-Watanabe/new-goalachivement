<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標一覧の絞り込みの仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>目標一覧の「絞り込み」から、「未達成」または「達成済」を選択することで、達成した目標と達成していない目標を分けて確認することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">目標一覧の「絞り込み」をクリック。</li>
          <li class="use-description-item">「未達成」または「達成済」をクリック。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use8.mov">
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
