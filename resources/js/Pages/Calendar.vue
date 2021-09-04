<template>
  <app-layout>
    <div class="home-content">

      <!-- カレンダーページ -->
      <div class="calendar-container">

        <!-- カレンダーセクション -->
        <div class="calendar-section">
          <div class="calendar">
            <div class="calendar-title">
              <button v-on:click="prevMonth()"><i class="fas fa-angle-left"></i>前月</button>
              <span class="this-month">{{ moment.format('YYYY年M月') }}</span>
              <button v-on:click="nextMonth()">来月<i class="fas fa-angle-right"></i></button>
            </div>

            <table class="calendar-table">
              <thead>
                <tr class="week calendar-week">
                  <td><span class="sunday">日</span></td>
                  <td>月</td>
                  <td>火</td>
                  <td>水</td>
                  <td>木</td>
                  <td>金</td>
                  <td><span class="saturday">土</span></td>
                </tr>
              </thead>
              <tbody>
                <tr class="week week-days" v-for="week in calendars">
                  <td v-for="day in week">
                    <a v-if="moment.format('M') == day.month" v-on:click="selectDay(day)" v-bind:class="{ today: checkToday(day.yearMonthDate) }" v-bind:style="{ backgroundColor: thisDay(day.yearMonthDate) }">
                      <span v-if="day.day == 0" class="day-num sunday" v-bind:class="{ holiday: isHoliday(calendars, day) }">{{ day.date }}</span>
                      <span v-else-if="day.day == 6" class="day-num saturday" v-bind:class="{ holiday: isHoliday(calendars, day) }">{{ day.date }}</span>
                      <span v-else class="day-num weekday" v-bind:class="{ holiday: isHoliday(calendars, day) }">{{ day.date }}</span>

                      <div class="schedule-icon">
                        <span v-for="schedule in schedules" v-bind:key="schedule.schedule_id">
                          <i class="fas fa-circle" v-if="formatDate(schedule.start_time).format('YYYY-MM-DD') == day.yearMonthDate" v-bind:style="{ color: categoryColor(schedule.schedule_category_id) }"></i>
                        </span>
                      </div>
                    </a>
                    <span v-else></span>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>

        <!-- 予定一覧セクション -->
        <div class="schedule-list-section">
          <div class="schedule-list-title">
            <h1 class="schedule-date"><span v-if="nowDate == moment.format('YYYY年M月D日')">今日：</span>{{ nowDate }}</h1>
          </div>

          <div class="schedule-list-container">
            <div class="schedule-list-nav">
              <span class="schedule-list-nav-schedule">予定</span>
              <span class="schedule-list-nav-category">カテゴリー</span>
              <span class="schedule-list-nav-time">時間</span>
            </div>

            <ul class="schedule-list">
              <li class="schedule-item" v-for="schedule in schedulesList" v-bind:key="schedule.schedule_id" v-on:click="editModal(schedule)">
                <div class="schedule-item-schedule-space">
                  <span class="schedule-item-schedule">{{ schedule.title }}</span>
                </div>

                <div class="schedule-item-category-time-space">
                  <div class="schedule-item-category-box">
                    <div v-for="category in schedule_categories">
                      <span class="schedule-item-category" v-if="schedule.schedule_category_id == category.schedule_category_id" v-bind:style="{ backgroundColor: category.color }">{{ category.category }}</span>
                    </div>
                  </div>
                  <span class="schedule-item-time">{{ formatDate(schedule.start_time).format('H:mm') }} 〜 <span v-if="schedule.end_time">{{ formatDate(schedule.end_time).format('H:mm') }}</span></span>
                </div>
              </li>
            </ul>

            <div class="no-schedule" v-if="!schedulesList.length">予定はありません</div>

            <div class="add-schedule">
              <button class="add-schedule-btn" v-on:click="openModal">+ 予定を追加する</button>
            </div>


            <!-- モーダルウィンドウ -->
            <transition name="fade">
              <div class="modal-window-bg" v-if="isModal">
                <div class="modal-window">
                  <div class="modal-window-title">
                    <span class="modal-title" v-if="mode == '追加'">予定追加</span>
                    <span class="modal-title" v-if="mode == '編集'">予定変更</span>
                    <button class="close-modal-btn" v-on:click="closeModal"><i class="fas fa-times"></i></button>
                  </div>

                  <!-- エラーメッセージ -->
                  <div class="error-message" v-if="errors.length">
                    <ul>
                      <li class="error-message-item" v-for="error in errors">{{ error }}</li>
                    </ul>
                  </div>

                  <div class="modal-input">
                    <i class="fas fa-clipboard-list"></i>
                    <input type="text" placeholder="予定を入力してください" v-model="form.title">
                  </div>

                  <div class="modal-input">
                    <i class="far fa-clock"></i>
                    <span class="input-date">開始時間</span>
                    <input type="time" v-model="form.datetime_start">
                  </div>

                  <div class="modal-input">
                    <i class="far fa-clock"></i>
                    <span class="input-date">終了時間</span>
                    <input type="time" v-model="form.datetime_end">
                  </div>

                  <div class="modal-input">
                    <i class="fas fa-tags" v-on:click="openTagModal"></i>
                    <div class="tag-content">
                      <div v-for="category in schedule_categories" v-bind:key="category.schedule_category_id">
                        <span class="task-tag-label" v-if="category.schedule_category_id == form.schedule_category_id" v-bind:style="{ backgroundColor: category.color }">{{ category.category }}<i class="fas fa-times-circle" v-on:click="cancelCategory"></i></span>
                      </div>
                    </div>
                  </div>

                  <div class="modal-btn">
                    <button class="add-modal-btn" v-on:click="addSchedule" v-if="mode == '追加'">追加</button>
                    <button class="edit-modal-btn" v-on:click="editSchedule(form.schedule_id)" v-if="mode == '編集'">変更</button>
                    <button class="delete-modal-btn" v-if="mode == '編集'" v-on:click="deleteSchedule(form.schedule_id)">削除</button>
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
                      <li class="category-item" v-for="category in schedule_categories" v-bind:key="category.schedule_category_id" v-bind:style="{ backgroundColor: category.color }">
                        <div class="category-item-inner" v-on:click="selectCategory(category.schedule_category_id)">
                          <i class="fas fa-check-circle" v-if="category.schedule_category_id == tag.schedule_category_id"></i>
                          {{ category.category }}
                        </div>
                        <i class="fas fa-pen" v-on:click="openCategoryEdit(category)"></i>
                      </li>
                      <button class="category-item-show" v-if="schedule_category.category" v-bind:style="{ backgroundColor: schedule_category.color }">{{ schedule_category.category }}</button>
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
                          <button class="category-delete-btn" v-on:click="deleteCategory(editCategory.schedule_category_id)">削除</button>
                          <button class="category-add-btn" v-on:click="updateCategory(editCategory.schedule_category_id)">変更</button>
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

                        <input type="text" placeholder="カテゴリー名を入力してください" v-model="schedule_category.category">
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
                  </div>

                  <!-- ボタン -->
                  <div class="modal-btn">
                    <button class="cancel-modal-btn" v-on:click="closeTagModal">キャンセル</button>
                    <button class="add-modal-btn" v-on:click="addTag">保存</button>
                  </div>

                </div>
              </div>
            </transition>

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

    props: ['schedules', 'schedule_categories'],

    data() {
      return {
        formatDate: moment,
        moment: moment(),
        nowDate: moment(this.moment).format('YYYY年M月D日'),
        date: moment(this.moment).format('YYYY-MM-D'),
        isModal: false,
        isTagModal: false,
        form: {
          schedule_id: '',
          title: '',
          schedule_category_id: '',
          date: '',
          datetime_start: '',
          datetime_end: '',
        },
        errors: [],
        categoryErrors: [],
        isCategory: false,
        schedule_category: {
          category: '',
          color: ''
        },
        editCategory: {
          schedule_category_id: '',
          category: '',
          color: '',
        },
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
        categoryUnique: false,
        tag: {
          schedule_category_id: '',
        },
        holidays: [
          '1-1',
          '2-11',
          '2-23',
          '3-20',
          '4-29',
          '5-3',
          '5-4',
          '5-5',
          '8-11',
          '9-23',
          '11-3',
          '11-23',
        ],
        mode: '追加',
        isCategoryEdit: false,
      }
    },

    computed: {
      calendars() {
        return this.calendar();
      },

      schedulesList() {
        const result = this.schedules.filter(schedule => moment(schedule.start_time).format('YYYY-MM-D') == this.date);
        return result;
      },

      schedulesIcon() {
        const result = this.schedules.filter(schedule => moment(schedule.start_time).format('YYYY-MM-D') == this.date);
        return result;
      },
    },

    methods: {

      getStartOfMonth() {
        let date = moment(this.moment);
        date.startOf('month');
        let dayNum = date.day();
        return date.subtract(dayNum, 'days');
      },

      getEndOfMonth() {
        let date = moment(this.moment);
        date.endOf('month');
        let dayNum = date.day();
        return date.add(6 - dayNum, 'days');
      },

      calendar() {
        let startOfMonth = this.getStartOfMonth();
        let endOfMonth = this.getEndOfMonth();
        let weekNum = Math.ceil(endOfMonth.diff(startOfMonth, 'days') / 7);

        let calendars = [];
        for (let week = 0; week < weekNum; week++) {
          let weekRow = [];
          for (let day = 0; day < 7; day++) {
            weekRow.push({
              date: startOfMonth.get('date'),
              yearMonthDate: startOfMonth.format('YYYY-MM-DD'),
              month: startOfMonth.format('M'),
              day: startOfMonth.format('d')
            });
            startOfMonth.add(1, 'days');
          }
          calendars.push(weekRow);
        }
        return calendars;
      },

      prevMonth() {
        this.moment = moment(this.moment).subtract(1, 'month');
      },

      nextMonth() {
        this.moment = moment(this.moment).add(1, 'month');
      },

      selectDay(day) {
        this.nowDate = this.moment.format('YYYY年M月') + day.date + '日';
        this.date = this.moment.format('YYYY-MM') + '-' + day.date;
      },

      checkToday(yearMonthDate) {
        if (this.formatDate().format('YYYY-MM-DD') == yearMonthDate) {
          return true;
        } else {
          return false;
        }
      },

      thisDay(yearMonthDate) {
        if (this.formatDate(yearMonthDate).format('YYYY年M月D日') == this.nowDate) {
          return '#ffe8dd';
        }
      },

      isHoliday(calendars, day) {
        //固定の祝日
        for (let holiday of this.holidays) {
          if (holiday == day.month + '-' + day.date) {
            return true;
          }
        }

        //成人の日
        let adultDay = [];
        for (let week of calendars) {
          for (let weekday of week) {
            if (weekday.month == 1 && weekday.day == 1) {
              adultDay.push(weekday);
            }
          }
        }
        if (adultDay.length > 1 && adultDay[1].yearMonthDate == day.yearMonthDate) {
          return true;
        }

        //海の日
        let marineDay = [];
        for (let week of calendars) {
          for (let weekday of week) {
            if (weekday.month == 7 && weekday.day == 1) {
              marineDay.push(weekday);
            }
          }
        }
        if (marineDay.length > 1 && marineDay[2].yearMonthDate == day.yearMonthDate) {
          return true;
        }

        //敬老の日
        let respectAgedDay = [];
        for (let week of calendars) {
          for (let weekday of week) {
            if (weekday.month == 9 && weekday.day == 1) {
              respectAgedDay.push(weekday);
            }
          }
        }
        if (respectAgedDay.length > 1 && respectAgedDay[2].yearMonthDate == day.yearMonthDate) {
          return true;
        }

        //スポーツの日
        let sportsDay = [];
        for (let week of calendars) {
          for (let weekday of week) {
            if (weekday.month == 10 && weekday.day == 1) {
              sportsDay.push(weekday);
            }
          }
        }
        if (sportsDay.length > 1 && sportsDay[1].yearMonthDate == day.yearMonthDate) {
          return true;
        }
      },

      categoryColor(schedule_category_id) {
        let color = '';

        for (let category of this.schedule_categories) {
          if (category.schedule_category_id == schedule_category_id) {
            color = category.color;
          } else if (schedule_category_id == 0) {
            color = '#cecece';
          }
        }

        return color;
      },

      openModal() {
        this.isModal = true;
        this.mode = '追加';
        this.form.date = this.date;
      },

      openTagModal() {
        this.isTagModal = true;
        this.tag.schedule_category_id = this.form.schedule_category_id;
      },

      openCategory() {
        this.isCategory = true;
        this.isCategoryEdit = false;
      },

      closeModal() {
        this.isModal = false;
        this.errors = [];
        this.resetForm();
      },

      closeTagModal() {
        this.isTagModal = false;
        this.categoryErrors = [];
        this.isCategory = false;

        if (this.form.schedule_category_id == '') {
          this.tag.schedule_category_id = '';
        }
      },

      closeCategory() {
        this.isCategory = false;
      },

      checkForm() {
        this.errors = [];

        if (this.form.title == '') {
          this.errors.push('予定を入力してください');
        }

        if (this.form.datetime_start == '') {
          this.errors.push('開始時間を入力してください');
        }

        if (this.form.title && this.form.datetime_start) {
          this.errors = [];
          return true;
        }
      },

      checkCategory() {
        this.categoryErrors = [];
        this.categoryUnique = false;

        if (this.schedule_category.category == '') {
          this.categoryErrors.push('カテゴリーを入力してください');
        }

        for (let category of this.schedule_categories) {
          if (this.schedule_category.category == category.category) {
            this.categoryErrors.push(this.schedule_category.category + 'はすでに存在しています');
            this.categoryUnique = true;
          }
        }

        if (this.schedule_category.color == '') {
          this.categoryErrors.push('カラーを選択してください');
        }

        if (this.schedule_category.category && this.categoryUnique == false && this.schedule_category.color) {
          this.categoryErrors = [];
          return true;
        }
      },

      resetForm() {
        this.form.schedule_id = '';
        this.form.title = '';
        this.form.schedule_category_id = '';
        this.form.date = '';
        this.form.datetime_start = '';
        this.form.datetime_end = '';
      },

      resetCategory() {
        this.schedule_category.category = '';
        this.schedule_category.color = '';
      },

      openCategoryEdit(category) {
        this.isCategoryEdit = true;
        this.isCategory = false;
        this.editCategory.schedule_category_id = category.schedule_category_id;
        this.editCategory.category = category.category;
        this.editCategory.color = category.color;
      },

      closeCategoryEdit() {
        this.isCategoryEdit = false;
        this.editCategory.schedule_category_id = '';
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

      updateCategory(schedule_category_id) {
        if (this.checkCategoryEdit()) {
          this.$inertia.patch(`/schedule_category/${schedule_category_id}`, this.editCategory)
          this.editCategory.schedule_category_id = '';
          this.editCategory.category = '';
          this.editCategory.color = '';
          this.isCategoryEdit = false;
        } else {
          return false;
        }
      },

      deleteCategory(schedule_category_id) {
        if (!confirm('カテゴリーを削除します。よろしいですか？')) {
          return;
        }
        this.$inertia.delete(`/schedule_category/${schedule_category_id}`)
        this.editCategory.schedule_category_id = '';
        this.editCategory.category = '';
        this.editCategory.color = '';
        this.isCategoryEdit = false;
      },

      addSchedule() {
        if (this.checkForm()) {
          this.$inertia.post('/calendar', this.form)
          this.resetForm();
          this.isModal = false;
        } else {
          return false;
        }
      },

      selectColor(color) {
        this.schedule_category.color = color;
      },

      addCategory() {
        if (this.checkCategory()) {
          this.$inertia.post('/schedule_category', this.schedule_category)
          this.resetCategory();
          this.isCategory = false;
        } else {
          return false;
        }
      },

      selectCategory(schedule_category_id) {
        this.tag.schedule_category_id = schedule_category_id;
      },

      addTag() {
        this.form.schedule_category_id = this.tag.schedule_category_id;
        this.isTagModal = false;
        this.tag.schedule_category_id = '';
      },

      cancelCategory() {
        this.form.schedule_category_id = '';
      },

      editModal(schedule) {
        this.isModal = true;
        this.mode = '編集';
        this.form.schedule_id = schedule.schedule_id;
        this.form.title = schedule.title;
        this.form.schedule_category_id = schedule.schedule_category_id;
        this.form.date = this.date;
        this.form.datetime_start = moment(schedule.start_time).format('HH:mm:ss');
        if (schedule.end_time == null) {
          this.form.datetime_end = null;
        } else {
          this.form.datetime_end = moment(schedule.end_time).format('HH:mm:ss');
        }
      },

      editSchedule(schedule_id) {
        if (this.checkForm()) {
          this.$inertia.patch(`/calendar/${schedule_id}`, this.form)
          this.resetForm();
          this.isModal = false;
        } else {
          return false;
        }
      },

      deleteSchedule(schedule_id) {
        if (!confirm('予定を削除します。よろしいですか？')) {
          return;
        }
        this.$inertia.delete(`/calendar/${schedule_id}`)
        this.resetForm();
        this.isModal = false;
      }

    },

  }
</script>
