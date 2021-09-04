<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>予定を削除する方法がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>削除したい予定を押し、「削除」を押すことで予定を削除することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">削除したい予定をクリック。</li>
          <li class="use-description-item">「削除」をクリック。</li>
        </ul>

        <span class="alert-description">※削除した予定は復元することができません。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use16.mov">
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
