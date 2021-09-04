<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>タスク一覧のマトリクスとは何ですか？</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>タスク一覧のマトリクスとは、「重要度」と「緊急度」の2つの軸を使い、タスクの優先順位を把握する表です。本サービスの重要度と緊急度のマトリクスでは、縦軸に重要度、横軸に緊急度の軸を形成しています。</p>

        <img class="use-image" src="/image/task_matrix.png">

        <p class="description-p">マトリクス表では、主に4つの項目があります。</p>

        <ul class="use-description-list">
          <li class="use-description-item">タスクの重要度が高い、かつ緊急度も高い項目の「A」。</li>
          <li class="use-description-item">タスクの重要度が高いが、緊急度は低い項目の「B」。</li>
          <li class="use-description-item">タスクの重要度は低いが、緊急度が高い項目の「C」。</li>
          <li class="use-description-item">タスクの重要度が低く、かつ緊急度も低い項目の「D」。</li>
        </ul>

        <p class="description-p">このようにタスクの「重要度」と「緊急度」を考え、4つの項目に振り分けることによって、どのタスクを優先的に行うべきなのか確認することができます。</p>
        <p class="description-p">本サービスでは、タスクにそれぞれ「重要」「緊急」のタグを追加できるようになっており、「重要」を追加すれば重要度が高いタスク、「緊急」を追加すれば緊急度が高いタスクと認識されます。</p>
        <p class="description-p">そのため、マトリクス表では、以下のようにタスクが振り分けられます。</p>

        <ul class="use-matrix-list">
          <li class="use-matrix-item">「重要」「緊急」</li>
          <li class="use-matrix-item">「重要」</li>
          <li class="use-matrix-item">「緊急」</li>
          <li class="use-matrix-item">なし</li>
        </ul>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use13.mov">
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
