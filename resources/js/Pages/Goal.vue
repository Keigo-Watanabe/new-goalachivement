<template>
    <app-layout>
      <div class="home-content">
        <!-- 目標追加ボタン -->
        <div class="add-goal">
          <button class="add-goal-btn" v-on:click="modalGoal">+ 新しい目標を設定する</button>
        </div>


        <!-- モーダルウィンドウ -->
        <transition name="fade">
          <div class="modal-window-bg" v-if="isModal">
            <div class="modal-window">
              <div class="modal-window-title">
                <span class="modal-title" v-if="mode == '設定'">目標設定</span>
                <span class="modal-title" v-if="mode == '編集'">目標変更</span>
                <button class="close-modal-btn" v-on:click="closeModal"><i class="fas fa-times"></i></button>
              </div>

              <!-- エラーメッセージ -->
              <div class="error-message" v-if="errors.length">
                <ul>
                  <li class="error-message-item" v-for="error in errors">{{ error }}</li>
                </ul>
              </div>

              <div class="modal-input">
                <i class="far fa-flag"></i>
                <input type="text" placeholder="目標を入力してください" v-model="form.title">
              </div>
              <div class="modal-input">
                <i class="far fa-calendar-alt"></i>
                <input type="date" v-model="form.date">
              </div>

              <div class="modal-btn">
                <button class="add-modal-btn" v-on:click="addGoal" v-if="mode == '設定'">設定</button>
                <button class="edit-modal-btn" v-if="mode == '編集'" v-on:click="editGoal(form.goal_id)">更新</button>
                <button class="delete-modal-btn" v-if="mode == '編集'" v-on:click="deleteGoal(form.goal_id)">削除</button>
              </div>
            </div>
          </div>
        </transition>


        <!-- 目標一覧 -->
        <div class="goal-list-title">
          <h1 class="goal-title">目標
            <span class="goal-title-sort" v-if="sortGoals == '達成済'">：達成済</span>
            <span class="goal-title-sort" v-if="sortGoals == '未達成'">：未達成</span>
          </h1>
          <button class="sort-btn" v-on:click="isDropdown = !isDropdown"><i class="fas fa-sort-amount-down-alt"></i>絞り込み</button>

          <!-- 並び替えドロップダウン -->
          <transition name="fade">
            <div class="sort-dropdown" v-if="isDropdown">
              <a v-on:click="sortNotDone">未達成</a>
              <a v-on:click="sortDone">達成済</a>
            </div>
          </transition>
        </div>

        <!-- 全ての目標一覧 -->
        <div class="goal-list" v-if="sortGoals == '全て'">
          <div class="goal-item" v-for="goal in goals" v-bind:key="goal.goal_id">
            <div class="goal-name" v-on:click="showGoal(goal.goal_id)">{{ goal.title }}</div>
            <div class="goal-date" v-on:click="showGoal(goal.goal_id)">達成日：{{ moment(goal.date).format('YYYY年M月D日') }}</div>
            <div class="goal-item-flex goal-task-setting">
              <span class="goal-task" v-on:click="showGoal(goal.goal_id)">進行中のタスク{{ taskProgress(goal.goal_id) }}件</span>
              <button class="goal-setting" v-on:click="editModal(goal)"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="goal-item-flex goal-progress" v-on:click="showGoal(goal.goal_id)">
              <span class="goal-progress-per">進行率{{ goalProgress(goal.goal_id) }}%</span>
              <div class="goal-status" v-if="achivement(goal.goal_id) == true"><span class="goal-status-achivement"><i class="fas fa-thumbs-up"></i>目標達成！</span></div>
              <div class="goal-status" v-else-if="achivement(goal.goal_id) == false"><span class="goal-status-not-done">未達成</span></div>
            </div>
          </div>
        </div>

        <!-- 達成済みの目標一覧 -->
        <div class="goal-list" v-if="sortGoals == '達成済'">
          <div class="no-goals" v-if="!goalDone.length">達成済みの目標はありません</div>

          <div class="goal-item" v-for="goal in goalDone" v-bind:key="goal.goal_id">
            <div class="goal-name" v-on:click="showGoal(goal.goal_id)">{{ goal.title }}</div>
            <div class="goal-date" v-on:click="showGoal(goal.goal_id)">達成日：{{ moment(goal.date).format('YYYY年M月D日') }}</div>
            <div class="goal-item-flex goal-task-setting">
              <span class="goal-task" v-on:click="showGoal(goal.goal_id)">進行中のタスク{{ taskProgress(goal.goal_id) }}件</span>
              <button class="goal-setting" v-on:click="editModal(goal)"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="goal-item-flex goal-progress" v-on:click="showGoal(goal.goal_id)">
              <span class="goal-progress-per">進行率{{ goalProgress(goal.goal_id) }}%</span>
              <div class="goal-status" v-if="achivement(goal.goal_id) == true"><span class="goal-status-achivement"><i class="fas fa-thumbs-up"></i>目標達成！</span></div>
              <div class="goal-status" v-else-if="achivement(goal.goal_id) == false"><span class="goal-status-not-done">未達成</span></div>
            </div>
          </div>
        </div>

        <!-- 未達成の目標一覧 -->
        <div class="goal-list" v-if="sortGoals == '未達成'">
          <div class="no-goals" v-if="!goalDone.length">未達成の目標はありません</div>

          <div class="goal-item" v-for="goal in goalDone" v-bind:key="goal.goal_id">
            <div class="goal-name" v-on:click="showGoal(goal.goal_id)">{{ goal.title }}</div>
            <div class="goal-date" v-on:click="showGoal(goal.goal_id)">達成日：{{ moment(goal.date).format('YYYY年M月D日') }}</div>
            <div class="goal-item-flex goal-task-setting">
              <span class="goal-task" v-on:click="showGoal(goal.goal_id)">進行中のタスク{{ taskProgress(goal.goal_id) }}件</span>
              <button class="goal-setting" v-on:click="editModal(goal)"><i class="fas fa-ellipsis-h"></i></button>
            </div>
            <div class="goal-item-flex goal-progress" v-on:click="showGoal(goal.goal_id)">
              <span class="goal-progress-per">進行率{{ goalProgress(goal.goal_id) }}%</span>
              <div class="goal-status" v-if="achivement(goal.goal_id) == true"><span class="goal-status-achivement"><i class="fas fa-thumbs-up"></i>目標達成！</span></div>
              <div class="goal-status" v-else-if="achivement(goal.goal_id) == false"><span class="goal-status-not-done">未達成</span></div>
            </div>
          </div>
        </div>

      </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue'
    import moment from 'moment'

    export default {
        components: {
            AppLayout,
        },
        props: ['goals', 'tasks', 'tasks_progress', 'tasks_complete'],
        data() {
          return {
            isDropdown: false,
            isModal: false,
            form: {
              title: '',
              date: '',
            },
            moment: moment,
            mode: '設定',
            sortGoals: '全て',
            goalDone: [],
            errors: [],
            goalUnique: false,
          }
        },
        methods: {
          checkForm() {
            this.errors = [];
            this.goalUnique = false;

            if (this.form.title == '') {
              this.errors.push('目標を入力してください');
            }

            for (let goal of this.goals) {
              if (this.form.title == goal.title) {
                this.errors.push(this.form.title + 'はすでに存在しています');
                this.goalUnique = true;
              }
            }

            if (this.form.date == '') {
              this.errors.push('達成日を入力してください');
            }

            if (this.form.title && this.goalUnique == false && this.form.date) {
              this.errors = [];
              return true;
            }
          },
          modalGoal() {
            this.mode = '設定';
            this.isModal = true;
            this.form.title = '';
            this.form.date = '';
          },
          closeModal() {
            this.isModal = false;
            this.errors = [];
            this.goalUnique = false;
          },
          addGoal() {
            if (this.checkForm()) {
              this.$inertia.post('/home', this.form)
              this.form.title = '';
              this.form.date = '';
              this.isModal = false;
            } else {
              return false;
            }
          },
          editModal(goal) {
            this.mode = '編集';
            this.isModal = true;
            this.form.goal_id = goal.goal_id;
            this.form.title = goal.title;
            this.form.date = goal.date;
          },
          editGoal(goal_id) {
            if (this.checkForm()) {
              this.$inertia.patch(`/home/${goal_id}`, this.form)
              this.form.goal_id = '';
              this.form.title = '';
              this.form.date = '';
              this.isModal = false;
            } else {
              return false;
            }
          },
          deleteGoal(goal_id) {
            if (!confirm('目標を削除します。よろしいですか？')) {
              return;
            }
            this.$inertia.delete(`/home/${goal_id}`)
            this.form.goal_id = '';
            this.form.title = '';
            this.form.date = '';
            this.isModal = false;
          },
          showGoal(goal_id) {
            this.$inertia.get(`/home/${goal_id}`)
          },
          taskProgress(goal_id) {
            let count = 0;

            for (let task of this.tasks_progress) {
              if (task.goal_id == goal_id) {
                count++;
              }
            }

            return count;
          },
          goalProgress(goal_id) {
            let taskNum = 0;

            for (let task of this.tasks) {
              if (task.goal_id == goal_id) {
                taskNum++;
              }
            }

            let taskComplete = 0;

            for (let complete of this.tasks_complete) {
              if (complete.goal_id == goal_id) {
                taskComplete++;
              }
            }

            let goal_progress = 100 / taskNum * taskComplete;

            if (taskNum == 0) {
              goal_progress = 0;
            }

            return Math.floor(goal_progress);
          },
          achivement(goal_id) {
            let taskNum = 0;

            for (let task of this.tasks) {
              if (task.goal_id == goal_id) {
                taskNum++;
              }
            }

            let taskComplete = 0;

            for (let complete of this.tasks_complete) {
              if (complete.goal_id == goal_id) {
                taskComplete++;
              }
            }

            if (taskNum == 0) {
              return false;
            } else if (taskNum == taskComplete) {
              return true;
            } else {
              return false;
            }
          },
          sortDone() {
            this.goalDone = [];

            for (let goal of this.goals) {
              let taskNum = 0;

              for (let task of this.tasks) {
                if (task.goal_id == goal.goal_id) {
                  taskNum++;
                }
              }

              let taskComplete = 0;

              for (let complete of this.tasks_complete) {
                if (complete.goal_id == goal.goal_id) {
                  taskComplete++;
                }
              }

              if (taskNum == taskComplete && taskNum != 0) {
                this.goalDone.push(goal);
              }
            }
            this.sortGoals = '達成済';
            this.isDropdown = false;
          },
          sortNotDone() {
            this.goalDone = [];

            for (let goal of this.goals) {
              let taskNum = 0;

              for (let task of this.tasks) {
                if (task.goal_id == goal.goal_id) {
                  taskNum++;
                }
              }

              let taskComplete = 0;

              for (let complete of this.tasks_complete) {
                if (complete.goal_id == goal.goal_id) {
                  taskComplete++;
                }
              }

              if (taskNum != taskComplete || taskNum == 0) {
                this.goalDone.push(goal);
              }
            }
            this.sortGoals = '未達成';
            this.isDropdown = false;
          }
        }
    }
</script>
