<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標タスク一覧のガントチャートとは何ですか？</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>ガントチャートとは、主にプロジェクト管理や作業管理を行う際に用いられる表で、横軸に「時間」、縦軸に「作業内容」を配置することで、視覚的にタスク管理がしやすくなります。</p>

        <p class="description-p">本サービスでは、目標で追加したタスクを縦軸に配置し、目標達成日までのタスク作業日程を横軸に配置しています。</p>
        <p class="description-p">棒グラフのようにタスク全てを視覚的に確認することができるので、ぜひご活用ください。</p>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use7.mov">
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
