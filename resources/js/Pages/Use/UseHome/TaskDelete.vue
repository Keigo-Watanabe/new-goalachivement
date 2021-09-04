<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>タスクを削除する方法がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧または目標のタスク一覧からタスクを押し、「削除」ボタンを押すことでタスクを削除することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">タスクをクリック。</li>
          <li class="use-description-item">「削除」をクリック。</li>
        </ul>

        <span class="alert-description">※削除されたタスクは復元することができません。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use12.mov">
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
