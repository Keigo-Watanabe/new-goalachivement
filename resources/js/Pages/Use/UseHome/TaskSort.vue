<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>タスク一覧の並び替えの仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧にある「並び替え」の「降順」「昇順」を選択することで、タスクを並び替えることができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">「降順」を選択すると、完了日が遠い順（遅い順）にタスク一覧が並び替えられます。</li>
          <li class="use-description-item">「昇順」を選択すると、完了日が近い順（早い順）にタスク一覧が並び替えられます。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use10.mov">
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
