<template>
    <div class="home-container">

        <jet-banner />

        <!-- ヘッダー -->
        <div class="header">
          <!-- ヘッダーロゴ -->
          <a class="header-logo" href="/home">
            <div class="logo-img"><img src="/image/app-logo.png"></div>
            <span class="goal-achivement-jp">目標達成</span>
            <span class="goal-achivement-en">- GoalAchivement -</span>
          </a>

          <!-- ヘッダー設定 -->
          <div class="header-setting">
            <div class="setting-icon" v-on:click="openSetting"><i class="fas fa-cog"></i></div>
            <div class="user-icon" v-on:click="isDropdown = !isDropdown"><i class="fas fa-user-circle"></i></div>
            <!-- プロフィールドロップダウン -->
            <transition name="fade">
              <div class="profile-dropdown" v-if="isDropdown">
                <a class="profile-btn" href="/user/profile">プロフィール</a>
                <a class="logout-btn" v-on:click="logout">ログアウト</a>
              </div>
            </transition>
          </div>
        </div>

        <!-- アプリの使い方一覧 -->
        <div class="app-use-container-bg" v-bind:class="{ slide: isSetting }">
          <div class="app-use-container">
            <!-- 使い方タイトル -->
            <div class="app-use-title-content">
              <div class="app-use-title">
                <span>目標達成 - GoalAchivement - の使い方</span>
              </div>
              <div class="app-use-close-btn">
                <i class="fas fa-times" v-on:click="closeSetting"></i>
              </div>
            </div>

            <ul class="app-use-section-list">
              <li class="app-use-section-item">ホーム</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/1">目標設定の仕方</a></li>
                <li class="app-use-item"><a href="/use/2">目標のタスクを追加する方法</a></li>
                <li class="app-use-item"><a href="/use/3">目標詳細の見方</a></li>
                <li class="app-use-item"><a href="/use/4">目標内容を変更する</a></li>
                <li class="app-use-item"><a href="/use/5">目標を削除する</a></li>
                <li class="app-use-item"><a href="/use/6">目標タスク一覧の絞り込み</a></li>
                <li class="app-use-item"><a href="/use/7">目標タスク一覧のガントチャートとは？</a></li>
                <li class="app-use-item"><a href="/use/8">目標一覧の絞り込み</a></li>
              </ul>

              <li class="app-use-section-item">タスク</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/9">タスク一覧の絞り込み</a></li>
                <li class="app-use-item"><a href="/use/10">タスク一覧の並び替え</a></li>
                <li class="app-use-item"><a href="/use/11">タスク内容を変更する</a></li>
                <li class="app-use-item"><a href="/use/12">タスクを削除する</a></li>
                <li class="app-use-item"><a href="/use/13">タスク一覧のマトリクスとは？</a></li>
              </ul>

              <li class="app-use-section-item">カレンダー</li>
              <ul class="app-use-list">
                <li class="app-use-item"><a href="/use/14">予定追加の仕方</a></li>
                <li class="app-use-item"><a href="/use/15">予定を変更する</a></li>
                <li class="app-use-item"><a href="/use/16">予定を削除する</a></li>
              </ul>

            </ul>

          </div>
        </div>

        <!-- ホームナビゲーション -->
        <div class="home-nav">
          <ul class="nav-list">
            <li v-bind:class="{ 'router-link-active': url == 'home' }"><a href="/home"><i class="fas fa-home"></i>ホーム</a></li>
            <li v-bind:class="{ 'router-link-active': url == 'task' }"><a href="/task"><i class="fas fa-tasks"></i>タスク</a></li>
            <li v-bind:class="{ 'router-link-active': url == 'calendar' }"><a href="/calendar"><i class="far fa-calendar-alt"></i>カレンダー</a></li>
          </ul>
        </div>

        <!-- Page Content -->
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
    import JetBanner from '@/Jetstream/Banner.vue'
    import JetDropdown from '@/Jetstream/Dropdown.vue'
    import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            title: String,
        },

        components: {
            Head,
            JetApplicationMark,
            JetBanner,
            JetDropdown,
            JetDropdownLink,
            JetNavLink,
            JetResponsiveNavLink,
            Link,
        },

        data() {
            return {
                showingNavigationDropdown: false,
                isDropdown: false,
                url: '',
                isSetting: false,
            }
        },

        created() {
            if (window.location.toString().includes('home')) {
                this.url = 'home';
            }
            if (window.location.toString().includes('task') || window.location.toString().includes('matrix')) {
                this.url = 'task';
            }
            if (window.location.toString().includes('calendar')) {
                this.url = 'calendar';
            }
        },

        methods: {
            switchToTeam(team) {
                this.$inertia.put(route('current-team.update'), {
                    'team_id': team.id
                }, {
                    preserveState: false
                })
            },

            logout() {
                this.$inertia.post(route('logout'));
            },

            openSetting() {
              this.isSetting = true;
            },

            closeSetting() {
              this.isSetting = false;
            }
        }
    }
</script>
