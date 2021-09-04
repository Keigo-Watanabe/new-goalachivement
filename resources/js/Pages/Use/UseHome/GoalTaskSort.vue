<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標タスク一覧の絞り込みの仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧右上にある「絞り込み」を押して、「カテゴリー」や「重要」「緊急」を選択してください。</p>

        <ul class="use-description-list">
          <li class="use-description-item">「絞り込み」をクリック。</li>
          <li class="use-description-item">絞り込みたい項目をクリックすることでタスクの一覧を絞り込むことができます。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use6.mov">
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
