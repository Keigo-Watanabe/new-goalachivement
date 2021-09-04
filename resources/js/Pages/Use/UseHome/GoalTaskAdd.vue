<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標のタスクを追加する方法を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスクを追加したい目標を押し、「新しいタスクを追加する」を押してください。そして、「タスク名」とタスクの「開始日」「完了日」を入力して「追加」を押すことで追加することできます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">目標をクリック。</li>
          <li class="use-description-item">「新しいタスクを追加する」をクリック。</li>
          <li class="use-description-item">「タスク名」とタスクの「開始日」と「完了日」を入力し、「追加」をクリック。</li>
        </ul>

        <span class="alert-description">※「タスク名」と「開始日」「完了日」は必須項目です。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use2.mov">
        </video>

        <p>必要に応じてタスクの「カテゴリー」や「優先度」を追加することができます。</p>
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
