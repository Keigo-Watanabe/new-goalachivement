<template>
  <app-layout>
    <div class="home-content">
      <!-- 目標詳細ページ -->
      <div class="goal-show-container">
        <!-- 目標詳細セクション -->
        <div class="goal-detail-section">
          <div class="goal-show-back">
            <a class="back-goal-list" href="/home"><i class="fas fa-angle-left"></i>目標一覧へ戻る</a>
          </div>

          <div class="goal-show-detail">
            <div class="goal-show-name">{{ goal.title }}</div>
            <div class="goal-show-date">達成日：{{ moment(goal.date).format('YYYY年M月D日') }}</div>
            <div class="goal-show-day">残り<span class="goal-show-day-num">{{ goal_remaining_days }}</span>日</div>

            <div class="goal-show-progress">
              <div class="goal-progress-label">
                <span>0%</span>
                <span>100%</span>
              </div>
              <div class="goal-progress-bar">
                <span class="goal-progress-bar-inner" v-bind:style="{ width: progress + '%' }"></span>
              </div>
              <div class="goal-progress-status">現在の進捗率{{ Math.floor(progress) }}%</div>
            </div>

            <div class="goal-show-task">
              <ul class="goal-show-task-list">
                <li>
                  <span class="goal-task-list-label">全てのタスク</span>
                  <span class="goal-task-item-num">{{ all_tasks.length }}件</span>
                </li>
                <li>
                  <span class="goal-task-list-label">進行中のタスク</span>
                  <span class="goal-task-item-num">{{ tasks_progress.length }}件</span>
                </li>
                <li>
                  <span class="goal-task-list-label">完了済のタスク</span>
                  <span class="goal-task-item-num">{{ tasks_complete.length }}件</span>
                </li>
              </ul>
            </div>

            <!-- タスク追加ボタン -->
            <div class="add-goal-task">
              <button class="add-task-btn" v-on:click="modalTask(goal.goal_id)">+ 新しいタスクを追加する</button>
            </div>
          </div>
        </div>

        <!-- モーダルウィンドウ -->
        <transition name="fade">
          <div class="modal-window-bg" v-if="isModal">
            <div class="modal-window">
              <div class="modal-window-title">
                <span class="modal-title" v-if="mode == '追加'">タスク追加</span>
                <span class="modal-title" v-if="mode == '編集'">タスク編集</span>
                <button class="close-modal-btn" v-on:click="closeModal"><i class="fas fa-times"></i></button>
              </div>

              <!-- エラーメッセージ -->
              <div class="error-message" v-if="errors.length != 0">
                <ul>
                  <li class="error-message-item" v-for="error in errors">{{ error }}</li>
                </ul>
              </div>

              <div class="modal-input">
                <i class="fas fa-tasks"></i>
                <input type="text" placeholder="タスクを入力してください" v-model="form.title">
              </div>
              <div class="modal-input">
                <i class="far fa-calendar-alt"></i>
                <span class="input-date">開始日</span>
                <input type="date" v-model="form.start_date">
              </div>
              <div class="modal-input">
                <i class="far fa-calendar-alt"></i>
                <span class="input-date">完了日</span>
                <input type="date" v-model="form.end_date">
              </div>
              <div class="modal-input">
                <i class="fas fa-tags" v-on:click="modalTag"></i>
                <div class="tag-content">
                  <div v-for="category in categories" v-bind:key="category.category_id">
                    <span class="task-tag-label" v-if="category.category_id == form.category_id" v-bind:style="{ backgroundColor: category.color }">{{ category.category }}<i class="fas fa-times-circle" v-on:click="cancelCategory"></i></span>
                  </div>
                  <span class="task-tag-label priority-label" v-if="form.priority">{{ form.priority }}<i class="fas fa-times-circle" v-on:click="cancelPriority"></i></span>
                  <span class="task-tag-label severity-label" v-if="form.severity">{{ form.severity }}<i class="fas fa-times-circle" v-on:click="cancelSeverity"></i></span>
                </div>
              </div>

              <div class="modal-btn">
                <button class="add-modal-btn" v-on:click="addTask" v-if="mode == '追加'">追加</button>
                <button class="edit-modal-btn" v-on:click="editTask(form.task_id)" v-if="mode == '編集'">変更</button>
                <button class="delete-modal-btn" v-on:click="deleteTask(form.task_id)" v-if="mode == '編集'">削除</button>
              </div>
            </div>
          </div>
        </transition>

        <!-- タグモーダルウィンドウ -->
        <transition name="fade">
          <div class="modal-window-bg" v-if="isTagModal">
            <div class="modal-window">
              <div class="modal-window-title">
                <span class="modal-title">タグの設定</span>
                <button class="close-modal-btn" v-on:click="closeTagModal"><i class="fas fa-times"></i></button>
              </div>

              <div class="add-tag-content">
                <!-- カテゴリー -->
                <span class="tag-label">カテゴリー</span>
                <ul class="category-list">
                  <li class="category-item" v-for="category in categories" v-bind:key="category.category_id" v-bind:style="{ backgroundColor: category.color }">
                    <div class="category-item-inner" v-on:click="selectCategory(category.category_id)">
                      <i class="fas fa-check-circle" v-if="category.category_id == tags.category"></i>
                      {{ category.category }}
                    </div>
                    <i class="fas fa-pen" v-on:click="openCategoryEdit(category)"></i>
                  </li>
                  <button class="category-item-show" v-if="category.category" v-bind:style="{ backgroundColor: category.color }">{{ category.category }}</button>
                </ul>

                <!-- カテゴリー編集フォーム -->
                <transition name="fade">
                  <div class="edit-category-form" v-if="isCategoryEdit">

                    <!-- エラーメッセージ -->
                    <div class="error-message" v-if="categoryErrors.length">
                      <ul>
                        <li class="error-message-item" v-for="error in categoryErrors">{{ error }}</li>
                      </ul>
                    </div>

                    <input type="text" v-model="editCategory.category">
                    <span class="tag-label">カラー設定</span>
                    <ul class="color-picker">
                      <li class="color-item" v-for="color in colors" v-bind:style="{ backgroundColor: color }" v-on:click="editColor(color)"></li>
                    </ul>
                    <div class="category-form-btn">
                      <button class="category-cancel-btn" v-on:click="closeCategoryEdit">キャンセル</button>
                      <button class="category-delete-btn" v-on:click="deleteCategory(editCategory.category_id)">削除</button>
                      <button class="category-add-btn" v-on:click="updateCategory(editCategory.category_id)">変更</button>
                    </div>

                  </div>
                </transition>

                <button class="add-category-btn" v-on:click="openCategory">+ 新しいカテゴリーを追加</button>

                <!-- カテゴリー追加フォーム -->
                <transition name="fade">
                  <div class="add-category-form" v-if="isCategory">

                    <!-- エラーメッセージ -->
                    <div class="error-message" v-if="categoryErrors.length">
                      <ul>
                        <li class="error-message-item" v-for="error in categoryErrors">{{ error }}</li>
                      </ul>
                    </div>

                    <input type="text" placeholder="カテゴリー名を入力してください" v-model="category.category">
                    <span class="tag-label">カラー設定</span>
                    <ul class="color-picker">
                      <li class="color-item" v-for="color in colors" v-bind:style="{ backgroundColor: color }" v-on:click="selectColor(color)"></li>
                    </ul>
                    <div class="category-form-btn">
                      <button class="category-cancel-btn" v-on:click="closeCategory">キャンセル</button>
                      <button class="category-add-btn" v-on:click="addCategory">追加</button>
                    </div>
                  </div>
                </transition>

                <!-- 優先度 -->
                <div class="priority-select-content">
                  <span class="tag-label">優先度</span>
                  <div class="priority-select">
                    <button id="priority-btn" class="priority-btn" v-on:click="addPriority">
                      <i class="fas fa-check-circle" v-if="this.tags.priority == '重要'"></i>
                      重要
                    </button>
                    <button id="severity-btn" class="severity-btn" v-on:click="addSeverity">
                      <i class="fas fa-check-circle" v-if="this.tags.severity == '緊急'"></i>
                      緊急
                    </button>
                  </div>
                </div>
              </div>

              <!-- ボタン -->
              <div class="modal-btn">
                <button class="cancel-modal-btn" v-on:click="closeTagModal">キャンセル</button>
                <button class="add-modal-btn" v-on:click="addTags">保存</button>
              </div>
            </div>
          </div>
        </transition>

        <!-- 目標タスク一覧セクション -->
        <div class="goal-task-list-section">
          <div class="goal-task-list-section-inner">
            <div class="goal-task-list-nav">
              <h1 class="goal-task-list-title">
                タスク一覧
                <span class="goal-task-sort-title" v-if="sort_mode != ''">：{{ sort_mode }}</span>
              </h1>

              <div class="goal-task-select">
                <button class="gantchart-btn" v-on:click="goalChart(goal.goal_id)"><i class="fas fa-align-left"></i>ガントチャート</button>
                <button class="sort-btn" v-on:click="isDropdown = !isDropdown"><i class="fas fa-sort-amount-down-alt"></i>絞り込み</button>

                <!-- 並び替えドロップダウン -->
                <transition name="fade">
                  <div class="task-sort-dropdown" v-if="isDropdown">
                    <a class="category-dropdown-btn" v-on:click="categoryDropdown = !categoryDropdown">
                      カテゴリー
                      <i class="fas fa-angle-down" v-if="categoryDropdown == false"></i>
                      <i class="fas fa-angle-up" v-if="categoryDropdown == true"></i>
                    </a>
                    <transition name="fade">
                      <div class="category-dropdown">
                        <ul class="category-dropdown-list" v-if="categoryDropdown">
                          <li class="category-dropdown-item" v-for="category in categories" v-bind:key="category.category_id" v-on:click="sortCategory(goal.goal_id, category.category_id)"><i class="fas fa-circle" v-bind:style="{ color: category.color }"></i>{{ category.category }}</li>
                        </ul>
                      </div>
                    </transition>
                    <a v-on:click="sortPriority(goal.goal_id)">重要</a>
                    <a v-on:click="sortSeverity(goal.goal_id)">緊急</a>
                  </div>
                </transition>
              </div>
            </div>

            <div class="goal-task-list-content">
              <div class="goal-task-list-head">
                <span class="check-space"><!-- タスクチェックゾーン --></span>
                <span class="task-name-space">タスク名</span>
                <span class="task-category-space">カテゴリー</span>
                <span class="task-priority-space">優先度</span>
                <span class="task-start-space">開始日</span>
                <span class="task-end-space">完了日</span>
                <span class="task-status-space">ステータス</span>
              </div>

              <!-- タスクリスト -->
              <ul class="goal-task-list">
                <li class="goal-task-list-item" v-for="task in tasks" v-bind:key="task.task_id">
                  <span class="check-space">
                    <i class="fas fa-check-circle is-not-complete" v-on:click="complete(task)" v-if="task.complete == 0"></i>
                    <i class="fas fa-check-circle is-complete" v-on:click="complete(task)" v-if="task.complete == 1"></i>
                  </span>
                  <div class="task-item-box" v-on:click="editModal(task)">
                    <span class="task-name-space">{{ task.title }}</span>
                    <div class="task-tag-space">
                      <div class="task-category-space task-item-category-space">
                        <div v-for="category in categories" v-bind:key="category.category_id">
                          <span class="task-category" v-if="task.category_id == category.category_id" v-bind:style="{ backgroundColor: category.color }">{{ category.category }}</span>
                        </div>
                      </div>
                      <div class="task-priority-space task-item-priority-space">
                        <span class="task-priority" v-if="task.priority">{{ task.priority }}</span>
                        <span class="task-severity" v-if="task.severity">{{ task.severity }}</span>
                      </div>
                    </div>
                    <div class="task-progress-space">
                      <span class="task-start-space task-item-start-space">{{ moment(task.start_date).format('YYYY/M/D') }}</span>
                      <span class="task-date-responsive">〜</span>
                      <span class="task-end-space task-item-end-space">{{ moment(task.end_date).format('YYYY/M/D') }}</span>
                      <div class="task-status-space task-item-status-space">
                        <span class="task-done" v-if="task.complete == 1">完了済</span>
                        <span class="task-not-done" v-else-if="now < task.start_date">未着手</span>
                        <span class="task-doing" v-else-if="now >= task.start_date">進行中</span>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>

              <div class="no-tasks" v-if="!tasks.length">タスクはありません</div>
            </div>
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
    props: [
      'goal',
      'tasks',
      'all_tasks',
      'categories',
      'now',
      'tasks_progress',
      'tasks_complete',
      'goal_remaining_days',
      'sort_mode'
    ],
    data() {
      return {
        moment: moment,
        form: {
          goal_id: null,
          title: '',
          category_id: null,
          start_date: '',
          end_date: '',
          priority: '',
          severity: '',
        },
        isModal: false,
        colors: [
          '#fca042',
          '#fb7b45',
          '#ef4431',
          '#b6338d',
          '#612385',
          '#0f3399',
          '#006bbe',
          '#00a19a',
          '#00963c',
          '#75bc36'
        ],
        isTagModal: false,
        isCategory: false,
        category: {
          category: '',
          color: '',
        },
        editCategory: {
          category_id: '',
          category: '',
          color: '',
        },
        isPriority: false,
        isSeverity: false,
        tags: {},
        mode: '追加',
        isDropdown: false,
        categoryDropdown: false,
        errors: [],
        categoryErrors: [],
        taskUnique: false,
        categoryUnique: false,
        isCategoryEdit: false,
      }
    },
    computed: {
      progress() {
        if (!this.all_tasks.length) {
          return 0;
        } else {
          return 100 / this.all_tasks.length * this.tasks_complete.length;
        }
      }
    },
    methods: {

      resetForm() {
        this.form.goal_id = null;
        this.form.title = '';
        this.form.category_id = null;
        this.form.start_date = '';
        this.form.end_date = '';
        this.form.priority = '';
        this.form.severity = '';
      },

      checkForm(task_id) {
        this.errors = [];
        this.taskUnique = false;

        if (this.form.title == '') {
          this.errors.push('タスクを入力してください');
        }

        for (let task of this.all_tasks) {
          if (task.task_id == task_id) {
            if (this.form.title == task.title) {
              //OK
            }
          } else if (this.form.title == task.title) {
            this.errors.push(this.form.title + 'はすでに存在しています');
            this.taskUnique = true;
          }
        }

        if (this.form.start_date == '') {
          this.errors.push('開始日を入力してください');
        }

        if (this.form.end_date == '') {
          this.errors.push('完了日を入力してください');
        }

        if (this.form.title && this.taskUnique == false && this.form.start_date && this.form.end_date) {
          this.errors = [];
          return true;
        }
      },

      checkCategory() {
        this.categoryErrors = [];
        this.categoryUnique = false;

        if (this.category.category == '') {
          this.categoryErrors.push('カテゴリーを入力してください');
        }

        for (let category of this.categories) {
          if (this.category.category == category.category) {
            this.categoryErrors.push(this.category.category + 'はすでに存在しています');
            this.categoryUnique = true;
          }
        }

        if (this.category.color == '') {
          this.categoryErrors.push('カラーを選択してください');
        }

        if (this.category.category && this.categoryUnique == false && this.category.color) {
          this.categoryErrors = [];
          return true;
        }
      },

      modalTask(goal_id) {
        this.mode = '追加';
        this.isModal = true;
        this.form.goal_id = goal_id;
      },

      closeModal() {
        this.isModal = false;
        this.resetForm();
        this.errors = [];
        this.taskUnique = false;
      },

      addTask() {
        if (this.checkForm()) {
          this.$inertia.post('/task', this.form)
          this.isModal = false;
          this.resetForm();
        } else {
          return false;
        }
      },

      modalTag() {
        this.isTagModal = true;
        this.tags.category = this.form.category_id;
        this.tags.priority = this.form.priority;
        this.tags.severity = this.form.severity;
      },

      closeTagModal() {
        this.isTagModal = false;
        if (this.form.category_id == 0) {
          this.tags.category = null;
        }
        if (this.form.priority == '') {
          this.tags.priority = null;
        }
        if (this.form.severity == '') {
          this.tags.severity = null;
        }

        this.categoryErrors = [];
        this.categoryUnique = false;
      },

      openCategory() {
        this.isCategory = true;
        this.isCategoryEdit = false;
      },

      closeCategory() {
        this.isCategory = false;
        this.categoryErrors = [];
        this.categoryUnique = false;
      },

      selectColor(color) {
        this.category.color = color;
      },

      addCategory() {
        if (this.checkCategory()) {
          this.$inertia.post('/category', this.category)
          this.category.category = '';
          this.category.color = '';
          this.isCategory = false;
        } else {
          return false;
        }
      },

      openCategoryEdit(category) {
        this.isCategoryEdit = true;
        this.isCategory = false;
        this.editCategory.category_id = category.category_id;
        this.editCategory.category = category.category;
        this.editCategory.color = category.color;
      },

      closeCategoryEdit() {
        this.isCategoryEdit = false;
        this.editCategory.category_id = '';
        this.editCategory.category = '';
        this.editCategory.color = '';
      },

      editColor(color) {
        this.editCategory.color = color;
      },

      checkCategoryEdit() {
        this.categoryErrors = [];
        this.categoryUnique = false;

        if (this.editCategory.category == '') {
          this.categoryErrors.push('カテゴリーを入力してください');
        }

        if (this.editCategory.color == '') {
          this.categoryErrors.push('カラーを選択してください');
        }

        if (this.editCategory.category && this.categoryUnique == false && this.editCategory.color) {
          this.categoryErrors = [];
          return true;
        }
      },

      updateCategory(category_id) {
        if (this.checkCategoryEdit()) {
          this.$inertia.patch(`/category/${category_id}`, this.editCategory)
          this.editCategory.category_id = '';
          this.editCategory.category = '';
          this.editCategory.color = '';
          this.isCategoryEdit = false;
        } else {
          return false;
        }
      },

      deleteCategory(category_id) {
        if (!confirm('カテゴリーを削除します。よろしいですか？')) {
          return;
        }
        this.$inertia.delete(`/category/${category_id}`)
        this.editCategory.category_id = '';
        this.editCategory.category = '';
        this.editCategory.color = '';
        this.isCategoryEdit = false;
      },

      selectCategory(category_id) {
        this.tags.category = category_id;
      },

      addPriority() {
        this.isPriority = !this.isPriority;
        if (this.isPriority == true) {
          this.tags.priority = '重要';
        } else {
          this.tags.priority = '';
        }
      },

      addSeverity() {
        this.isSeverity = !this.isSeverity;
        if (this.isSeverity == true) {
          this.tags.severity = '緊急';
        } else {
          this.tags.severity = '';
        }
      },

      addTags() {
        this.form.category_id = this.tags.category;
        this.form.priority = this.tags.priority;
        this.form.severity = this.tags.severity;
        this.isTagModal = false;
        this.tags.category = null;
        this.tags.priority = null;
        this.tags.severity = null;
      },

      cancelCategory() {
        this.form.category_id = null;
      },

      cancelPriority() {
        this.form.priority = null;
      },

      cancelSeverity() {
        this.form.severity = null;
      },

      editModal(task) {
        this.mode = '編集';
        this.isModal = true;
        this.form.task_id = task.task_id;
        this.form.title = task.title;
        this.form.category_id = task.category_id;
        this.form.start_date = task.start_date;
        this.form.end_date = task.end_date;
        this.form.priority = task.priority;
        this.form.severity = task.severity;
      },

      complete(task) {
        if (task.complete == 0) {
          task.complete = 1;
          this.$inertia.put(`/complete/${task.task_id}`, task)
        } else if (task.complete == 1) {
          task.complete = 0;
          this.$inertia.put(`/complete/${task.task_id}`, task)
        }
      },

      editTask(task_id) {
        if (this.checkForm(task_id)) {
          this.$inertia.patch(`/task/${task_id}`, this.form)
          this.resetForm();
          this.isModal = false;
        } else {
          return false;
        }
      },

      deleteTask(task_id) {
        if (!confirm('タスクを削除します。よろしいですか？')) {
          return;
        }
        this.$inertia.delete(`/task/${task_id}`)
        this.resetForm();
        this.isModal = false;
      },

      sortPriority(goal_id) {
        this.$inertia.get(`/home/${goal_id}`, { sort: '重要' })
        this.isDropdown = false;
      },

      sortSeverity(goal_id) {
        this.$inertia.get(`/home/${goal_id}`, { sort: '緊急' })
        this.isDropdown = false;
      },

      sortCategory(goal_id, category_id) {
        this.$inertia.get(`/home/${goal_id}`, { sort: category_id })
        this.isDropdown = false;
      },

      goalChart(goal_id) {
        this.$inertia.get(`/home/${goal_id}/chart`)
      }
    }
  }
</script>
