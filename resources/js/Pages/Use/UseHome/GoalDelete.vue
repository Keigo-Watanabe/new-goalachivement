<template>
  <use-component>
    <div class="use-description-inner">

      <div class="use-description-question">
        <p><i class="fas fa-question-circle"></i>目標を削除したいのですが、やり方がわかりません。</p>
      </div>

      <div class="use-description-answer">
        <p class="answer-p"><i class="fas fa-lightbulb"></i>目標一覧の中の「･･･」マークを押して、「削除」ボタンを押すことで目標を削除することができます。</p>

        <ul class="use-description-list">
          <li class="use-description-item">目標の「･･･」マークをクリック。</li>
          <li class="use-description-item">「削除」ボタンをクリック。</li>
        </ul>

        <span class="alert-description">※削除された目標は復元することができません。また、目標を削除すると、その目標のタスクもすべて削除されます。</span>
      </div>

      <div class="use-movie-container">
        <video class="use-movie" autoplay loop>
          <source src="/movies/use5.mov">
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
