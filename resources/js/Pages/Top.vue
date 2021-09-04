<template>

    <div class="lp-container">

        <!-- ファーストビュー -->
        <div class="firstview">

          <!-- ヘッダー -->
          <header class="lp-header">
            <!-- ヘッダーロゴ -->
            <h1>
              <a class="header-logo" href="/">
                <div class="logo-img"><img src="/image/app-logo.png"></div>
                <span class="goal-achivement-jp">目標達成</span>
                <span class="goal-achivement-en">- GoalAchivement -</span>
              </a>
            </h1>

            <!-- ヘッダーナビゲーション -->
            <div id="header-nav" class="header-nav">
              <ul class="header-nav-list">
                <li class="header-nav-item"><a href="#feature-section" v-on:click="smoothScroll">具体的な使い方</a></li>
                <li class="header-nav-item"><a href="/contact">お問い合わせ</a></li>
              </ul>

              <div v-if="canLogin" class="can-login">
                  <Link v-if="canRegister" :href="route('register')" class="header-nav-btn register-btn">
                      会員登録
                  </Link>

                  <Link :href="route('login')" class="header-nav-btn login-btn">
                      ログイン
                  </Link>
              </div>
            </div>

            <!-- レスポンシブナビゲーション -->
            <div class="responsive-header-nav" v-on:click="addNav">
              <span class="bar bar1"></span>
              <span class="bar bar2"></span>
              <span class="bar bar3"></span>
            </div>
          </header>

          <!-- ファーストビューメイン -->
          <div class="firstview-content">
            <div id="firstview-phrase" class="firstview-phrase">
              <h2><span class="nowrap break-word">目標達成までの道のりを</span><span class="nowrap break-word">可視化する。</span></h2>
              <span class="phrase-sub nowrap break-word">効率的に目標を達成するサービス</span>
              <div class="firstview-image-sp">
                <img src="/image/device.png" alt="ファーストビューメイン画像">
              </div>
              <a href="/register">はじめる</a>
            </div>

            <div id="firstview-image" class="firstview-image-pc">
              <img src="/image/device.png" alt="ファーストビューメイン画像">
            </div>
          </div>

        </div>


        <!-- 課題明示 -->
        <div class="problems-container">
          <div class="problems-inner">
            <h2 class="text-slide">目標を達成したい！<span class="text-slide-cover"></span></h2>
            <span class="problems-phrase text-slide">でも、、、<span class="text-slide-cover"></span></span>

            <ul class="problems-list">
              <li class="problems-item fade-in-el">
                <div class="problems-image">
                  <img src="/image/problem1.png" alt="課題アイコン1">
                </div>
                <div class="problems-item-description">
                  <p class="problems-sentence">
                    <span class="nowrap break-word">目標達成のために</span>
                    <span class="nowrap break-word">何をすればいいのか</span>
                    <span class="nowrap break-word">わからない。</span>
                  </p>
                </div>
              </li>
              <li class="problems-item fade-in-el">
                <div class="problems-image">
                  <img src="/image/problem2.png" alt="課題アイコン2">
                </div>
                <div class="problems-item-description">
                  <p class="problems-sentence">
                    <span class="nowrap break-word">目標達成までの道のりや</span>
                    <span class="nowrap break-word">今の自分の位置を</span>
                    <span class="nowrap break-word">把握できていない。</span>
                  </p>
                </div>
              </li>
              <li class="problems-item fade-in-el">
                <div class="problems-image">
                  <img src="/image/problem3.png" alt="課題アイコン3">
                </div>
                <div class="problems-item-description">
                  <p class="problems-sentence">
                    <span class="nowrap break-word">目標に向かって</span>
                    <span class="nowrap break-word">なかなか継続できない。</span>
                  </p>
                </div>
              </li>
            </ul>

            <span class="problems-phrase text-slide">そんなお悩みありませんか？<span class="text-slide-cover"></span></span>

            <div class="problems-description">
              <p class="problems-description-p fade-in-el">人々は皆、それぞれ目標や夢を持っています。</p>
              <p class="problems-description-p fade-in-el">「将来は会社を経営する社長になりたい」「ダイエットに成功して良い体を手に入れたい」「次の試合で結果を残したい」「資格を取りたい」など、その目標や夢は様々です。</p>
              <p class="problems-description-p fade-in-el">しかし、目標を達成するために何をすればいいのか、自分は今どの位置にいて、どの方向に進めばいいのかわからないと悩む人は少なくありません。</p>
            </div>

            <div class="problems-solution-lead">
              <p class="problems-solution-lead-p fade-in-el">そのような悩みを抱えているなら･･･</p>
            </div>
          </div>
        </div>


        <!-- 課題解決 -->
        <div class="solution-container">

          <div class="solution-title">
            <div id="solution-angle-content" class="solution-angle-content">
              <div class="solution-angle-bar"></div>
              <div class="solution-angle"></div>
              <div id="solution-angle-cover" class="solution-angle-cover"></div>
            </div>
            <h2 class="solution-title-h2 scroll-popup">
              <img src="/image/app-logo.png" alt="課題解決ロゴ">
              <div class="solution-h2">
                <span class="nowrap"><span class="solution-goal-achivement">目標達成</span>を使って</span>
                <span class="nowrap">解決しましょう！</span>
              </div>
            </h2>
          </div>

          <!-- 課題解決メイン -->
          <div class="solution-content">
            <div class="solution-inner">

              <ul class="solution-list">
                <li class="solution-item scroll-popup">
                  <div class="solution-image">
                    <img src="/image/solution1.png" alt="課題解決アイコン1">
                  </div>

                  <div class="solution-answer solution-answer-right">
                    <div class="solution-num-box">
                      <span class="solution-word">解決策</span>
                      <span class="solution-num">1</span>
                    </div>

                    <h3>目標を達成したい日を決めて、それまでに必要なタスクを洗い出す！</h3>

                    <div class="solution-description">
                      <p>いつまでに目標を達成したいのか決め、それまでに必要なタスクを思いつく限り洗い出します。</p>
                      <p>そうすることで、頭を整理することができ、目標達成に何が必要なのか把握することができます。</p>
                    </div>
                  </div>
                </li>

                <div class="lines">
                  <div class="lines-cover lines-cover-odd"><div class="lines-angle lines-angle-odd"></div></div>
                  <div class="line line-top line1"></div>
                  <div class="line line-middle line2"></div>
                  <div class="line line-bottom line3"></div>
                </div>

                <li class="solution-item scroll-popup">
                  <div class="solution-answer solution-answer-left">
                    <div class="solution-num-box">
                      <span class="solution-word">解決策</span>
                      <span class="solution-num">2</span>
                    </div>

                    <h3>それぞれのタスクを行う期間を決め、さらに優先度をつけることでより効率的にタスクを進められる！</h3>

                    <div class="solution-description">
                      <p>洗い出したタスクには開始から完了までの期間を決めます。</p>
                      <p>そして、タスクに優先度をつけることで、タスクごとに今すぐやるべきことなのか、目標達成のために重要なのかそうでないのかを区別することができます。</p>
                    </div>
                  </div>

                  <div class="solution-image">
                    <img src="/image/solution2.png" alt="課題解決アイコン2">
                  </div>
                </li>

                <div class="lines">
                  <div class="lines-cover lines-cover-even"><div class="lines-angle lines-angle-even"></div></div>
                  <div class="line line-top line4"></div>
                  <div class="line line-middle line5"></div>
                  <div class="line line-bottom line6"></div>
                </div>

                <li class="solution-item scroll-popup">
                  <div class="solution-image">
                    <img src="/image/solution3.png" alt="課題解決アイコン3">
                  </div>

                  <div class="solution-answer solution-answer-right">
                    <div class="solution-num-box">
                      <span class="solution-word">解決策</span>
                      <span class="solution-num">3</span>
                    </div>

                    <h3>タスクを1つずつ完了し、目標達成までの進行状況を常に把握することで継続できる！</h3>

                    <div class="solution-description">
                      <p>タスクを完了すれば、だんだん進行率がアップし、目標達成まで近づいている実感やモチベーションが湧いてきます。</p>
                      <p>進行状況をしっかりと把握することで、タスクを継続して行うことができます。</p>
                    </div>
                  </div>
                </li>
              </ul>

            </div>
          </div>
        </div>


        <!-- 具体的な使い方 -->
        <div id="feature-section" class="feature-container">
          <div class="feature-title">
            <h2>具体的な使い方</h2>
          </div>

          <!-- 具体的な使い方メイン -->
          <div class="feature-content">
            <ul class="feature-list">
              <li class="feature-item fade-in-el">
                <div class="feature-image-pc">
                  <img src="/image/use-pic1.jpg">
                </div>

                <div class="feature-item-content">
                  <h3>
                    <span class="feature-item-num">1</span>
                    <span>目標を設定したら必要なタスクを追加する（目標は複数設定可能！）</span>
                  </h3>

                  <div class="feature-image-sp">
                    <img src="/image/use-pic1.jpg">
                  </div>

                  <div class="feature-item-description">
                    <p>達成したい目標を設定できれば、必要なタスクを追加していきます。</p>
                    <p>タスクを追加する際は、「タスク名」と「開始日」「完了日」を入力します。</p>
                    <p>また、必要であればカテゴリーや優先度をつけるための重要や緊急を追加することもできます。</p>
                  </div>
                </div>
              </li>

              <li class="feature-item fade-in-el">
                <div class="feature-image-pc">
                  <img src="/image/use-pic2.jpg">
                </div>

                <div class="feature-item-content">
                  <h3>
                    <span class="feature-item-num">2</span>
                    <span><sup class="sm-num">※1</sup>ガントチャートを使用すれば、視覚的にタスクを管理できる</span>
                  </h3>

                  <div class="feature-image-sp">
                    <img src="/image/use-pic2.jpg">
                  </div>

                  <div class="feature-item-description">
                    <p>目標に追加したタスクはガントチャートで確認することができます。</p>
                    <p>縦軸にタスク、横軸に達成までの期間とそれぞれのタスクの期間が配置されています。</p>
                    <p>棒グラフのようになっているので、視覚的にタスクを管理することができます。</p>
                    <span class="explanation">※1 ガントチャートとは、主にプロジェクト管理や作業管理を行う際に用いられる表です。</span>
                  </div>
                </div>
              </li>

              <li class="feature-item fade-in-el">
                <div class="feature-image-pc">
                  <img src="/image/use-pic3.jpg">
                </div>

                <div class="feature-item-content">
                  <h3>
                    <span class="feature-item-num">3</span>
                    <span>タスク一覧では、それぞれの項目で絞り込んで確認できる</span>
                  </h3>

                  <div class="feature-image-sp">
                    <img src="/image/use-pic3.jpg">
                  </div>

                  <div class="feature-item-description">
                    <p>タスク追加時に設定したカテゴリーやステータス別に絞り込んでタスク一覧を確認することができます。</p>
                    <p>それぞれの項目に分けてタスクを絞り込むことで、共通するタスクや進行状況などをより把握しやすくなるでしょう。</p>
                  </div>
                </div>
              </li>

              <li class="feature-item fade-in-el">
                <div class="feature-image-pc">
                  <img src="/image/use-pic4.jpg">
                </div>

                <div class="feature-item-content">
                  <h3>
                    <span class="feature-item-num">4</span>
                    <span>重要度と緊急度の<sup class="sm-num">※2</sup>マトリクスを使えば、タスクの優先順位がひと目でわかる</span>
                  </h3>

                  <div class="feature-image-sp">
                    <img src="/image/use-pic4.jpg">
                  </div>

                  <div class="feature-item-description">
                    <p>タスク追加時に重要度が高いものには「重要」、緊急度が高いものには「緊急」をそれぞれ設定することで、優先順位を付けやすくなります。</p>
                    <p>マトリクスでは、「重要かつ緊急」「重要だが緊急でない」「緊急だが重要でない」「重要でも緊急でもない」の4つの項目に分けられます。</p>
                    <span class="explanation">※2 重要度と緊急度のマトリクスとは、「重要度」と「緊急度」の2つの軸を使い、タスクの優先順位を把握する表です。</span>
                  </div>
                </div>
              </li>

              <li class="feature-item fade-in-el">
                <div class="feature-image-pc">
                  <img src="/image/use-pic5.jpg">
                </div>

                <div class="feature-item-content">
                  <h3>
                    <span class="feature-item-num">5</span>
                    <span>カレンダー機能もあるので、日常の予定もまとめて管理できる</span>
                  </h3>

                  <div class="feature-image-sp">
                    <img src="/image/use-pic5.jpg">
                  </div>

                  <div class="feature-item-description">
                    <p>カレンダー機能もついているので、日常のちょっとした予定から大事な予定まで管理することもできます。</p>
                    <p>また、共通する予定はカテゴリー化しておけば、カレンダー上ででの管理がしやすくなります。</p>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>


        <!-- 目標を達成しよう -->
        <div class="start-using-app-container">
          <div class="start-using-app-title">
            <h2>さあ、目標を達成しよう！</h2>
          </div>

          <div class="start-using-app-content">
            <img src="/image/icon1.png" alt="はじめようアイコン1" class="popup-icon scroll-popup">
            <div class="start-using-app-btn">
              <a href="/register">はじめる</a>
            </div>
            <img src="/image/icon2.png" alt="はじめようアイコン2" class="popup-icon scroll-popup">
          </div>
        </div>


        <!-- フッター -->
        <footer class="footer">
          <a class="header-logo footer-logo" href="/">
            <div class="logo-img"><img src="/image/app-logo.png"></div>
            <span class="goal-achivement-jp">目標達成</span>
            <span class="goal-achivement-en">- GoalAchivement -</span>
          </a>

          <span class="copyright">©︎2021 GoalAchivement.</span>
        </footer>

    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        components: {
            Head,
            Link,
        },

        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
        },

        methods: {
          addNav() {
            const headerNav = document.getElementById('header-nav');

            headerNav.classList.toggle('header-nav-show');
          },

          smoothScroll() {
            $(function(){
              $('a[href^="#"]').click(function() {
                let href = $(this).attr("href");
                let target = $(href == "#" || href == "" ? 'html' : href);
                let position = target.offset().top;

                $('body, html').animate({
                  scrollTop: position
                }, 500, 'swing');
                return false;
              });
            });

            const headerNav = document.getElementById('header-nav');

            headerNav.classList.remove('header-nav-show');
          }
        },

        mounted() {
          /*
          ファーストビューアニメーション
          */
          const firstviewPhrase = document.getElementById('firstview-phrase');

          setTimeout(function() {
            firstviewPhrase.classList.add('popup-zoom');
          }, 500);

          setTimeout(function() {
            firstviewPhrase.classList.add('popup-zoom-out');
          }, 700);

          const firstviewImage = document.getElementById('firstview-image');

          setTimeout(function() {
            firstviewImage.classList.add('firstview-image-fade-in');
          }, 1000);



          /*
          スクロールアニメーション
          */
          window.addEventListener('scroll', function() {

            const scroll = window.pageYOffset || document.documentElement.scrollTop;
            const windowHeight = window.innerHeight;

            /*
            テキストアニメーション
            */
            let textSlideCover = document.querySelectorAll('.text-slide-cover');

            if (textSlideCover) {
              for (let i = 0; i < textSlideCover.length; i++) {
                const rect = textSlideCover[i].getBoundingClientRect().top;
                const offset = scroll + rect;

                if (offset - scroll < windowHeight / 1.5) {
                  textSlideCover[i].style.width = 0;
                }
              }
            }


            /*
            フェードインアニメーション
            */
            let fadeInEl = document.querySelectorAll('.fade-in-el');

            if (fadeInEl) {
              for(let i = 0; i < fadeInEl.length; i++) {
                const rect = fadeInEl[i].getBoundingClientRect().top;
                const offset = scroll + rect;

                if (offset - scroll < windowHeight / 1.5) {
                  fadeInEl[i].classList.add('fade-in-enter');
                }
              }
            }


            /*
            矢印アニメーション
            */
            const solutionAngleContent = document.getElementById('solution-angle-content');

            if (solutionAngleContent) {
              const angleRect = solutionAngleContent.getBoundingClientRect().top;
              const angleOffset = scroll + angleRect;

              if (angleOffset - scroll < windowHeight / 1.5) {
                const solutionAngleCover = document.getElementById('solution-angle-cover');

                solutionAngleCover.classList.add('solution-angle-cover-leave');
              }
            }


            /*
            ポップアップアニメーション
            */
            let scrollPopup = document.querySelectorAll('.scroll-popup');

            if (scrollPopup) {
              for (let i = 0; i < scrollPopup.length; i++) {
                const popupRect = scrollPopup[i].getBoundingClientRect().top;
                const popupOffset = scroll + popupRect;

                if (popupOffset - scroll < windowHeight / 1.5) {
                  scrollPopup[i].classList.add('popup-zoom');

                  setTimeout(function() {
                    scrollPopup[i].classList.add('popup-zoom-out');
                  }, 200);
                }
              }
            }


            /*
            動く矢印アニメーション
            */
            let lines = document.querySelectorAll('.lines');

            if (lines) {
              for (let i = 0; i < lines.length; i++) {
                const lineRect = lines[i].getBoundingClientRect().top;
                const lineOffset = scroll + lineRect;

                if (lineOffset - scroll < windowHeight / 1.5) {
                  lines[i].classList.add('line-enter-top');

                  if (window.innerWidth < 768) {
                    setTimeout(function() {
                      lines[i].classList.add('line-enter-bottom');
                    }, 300);
                  } else {
                    setTimeout(function() {
                      lines[i].classList.add('line-enter-middle');
                    }, 300);

                    setTimeout(function() {
                      lines[i].classList.add('line-enter-bottom');
                    }, 600);
                  }
                }
              }
            }
          });
        }
    }
</script>
