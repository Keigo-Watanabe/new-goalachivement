<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>タスクの内容を変更したいのですが、やり方がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧または目標のタスク一覧のタスクを押すことで、内容を変更することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">タスクをクリック。</li>
          <li class="use-description-item">変更したい項目を編集して「変更」をクリック。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use11.mov">
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
