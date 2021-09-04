<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>タスク一覧の絞り込みの仕方を教えてください。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧で、自身で追加したカテゴリー別や優先度別、ステータス別から項目を選択することで、その項目ごとにタスクを絞り込むことができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">カテゴリー別では、自身で追加したカテゴリーごとに絞り込むことができます。</li>
          <li class="use-description-item">優先度別では、「重要」「緊急」のどちらかを選択することで、タスクを優先度別に確認することができます。</li>
          <li class="use-description-item">ステータス別では、タスクの「未着手」「進行中」「完了済」の進行状況でタスクを絞り込むことができます。</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use9.mov">
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
