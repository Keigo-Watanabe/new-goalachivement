<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標内容を変更する方法がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>目標一覧の中の「･･･」マークを押すと、目標を編集することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">目標の「･･･」マークをクリック。</li>
          <li class="use-description-item">「目標名」または「達成日」を編集し、「変更」をクリック。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use4.mov">
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
