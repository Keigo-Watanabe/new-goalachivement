<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標詳細の見方がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>目標詳細画面では、主に目標達成までの進行状況やタスク一覧を把握することができます。</p>

        <span class="use-description-title">目標詳細部分</span>
        <p class="description-p">目標名や達成日、達成までの日数を確認しましょう。</p>
        <p class="description-p">また、タスクを完了させるとタスクの数に合わせて進捗率がアップします。</p>
        <p class="description-p">進捗率が100%になるようタスクをこなしていきましょう。</p>

        <span class="use-description-title">タスク一覧部分</span>
        <p class="description-p">目標達成までに必要なタスクの一覧を確認しましょう。</p>
        <p class="description-p">絞り込み機能を使えば、カテゴリー別や優先度別にタスクを把握することができます。</p>
        <p class="description-p">絞り込みについての詳細は、<a class="description-link" href="/use/6">目標タスク一覧の絞り込み</a>をご覧ください。</p>
        <p class="description-p">また、タスクの一覧はガントチャートで確認することもできます。</p>
        <p class="description-p">ガントチャートについては、<a class="description-link" href="/use/7">目標タスク一覧のガントチャートとは？</a>をご覧ください。</p>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use3.mov">
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
