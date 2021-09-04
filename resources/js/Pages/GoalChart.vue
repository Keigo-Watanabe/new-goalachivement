<template>
  <app-layout>
    <div class="home-content">

      <!-- ガントチャートタイトル -->
      <div class="gantchart-title">
        <div class="gantchart-back-to-goal">
          <a class="back-goal-show" v-on:click="backGoalShow(goal.goal_id)"><i class="fas fa-angle-left"></i>目標詳細へ戻る</a>
        </div>

        <div class="gantchart-goal-detail">
          <span class="gantchart-goal-name">{{ goal.title }}</span>
          <span class="gantchart-goal-date">{{ moment(goal.date).format('YYYY年M月D日') }}達成予定</span>
        </div>
      </div>

      <!-- ガントチャート詳細 -->
      <div class="gantchart-container">
        <!-- ガントチャートタスク一覧 -->
        <div class="gantchart-tasks">
          <div class="gantchart-tasks-title">
            <span>タスク</span>
          </div>

          <ul class="gantchart-task-list">
            <li class="gantchart-task-item" v-for="task in tasks" v-bind:key="task.task_id">{{ task.title }}</li>
            <li class="gantchart-task-item" v-if="!tasks.length">タスクがありません</li>
          </ul>
        </div>

        <!-- ガントチャートグラフ -->
        <div id="gantchart-table-box" class="gantchart-table-box">
          <table class="gantchart-table">
            <tr id="gantchart-date-row" class="gantchart-table-date">
              <th v-for="day in days">
                <span v-if="moment(day).format('YYYY-MM-DD') == moment(today).format('YYYY-MM-DD')" id="gantchart-today" class="gantchart-today">{{ moment(day).format('M/D') }}</span>
                <span v-else class="gantchart-day">{{ moment(day).format('M/D') }}</span>
              </th>
            </tr>
            <tr class="gantchart-table-graph" v-for="task in tasks" v-bind:key="task.task_id">
              <td v-for="day in days">
                <span class="gantchart-bar" v-if="task.start_date <= moment(day).format('YYYY-MM-DD') && moment(day).format('YYYY-MM-DD') <= task.end_date"></span>
              </td>
            </tr>
          </table>
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

    props: ['goal', 'tasks', 'days', 'today'],

    data() {
      return {
        moment: moment,
      }
    },

    mounted() {
      const gantchartTableBox = document.getElementById('gantchart-table-box');
      const gantchartDateRow = document.getElementById('gantchart-date-row');
      const gantchartToday = document.getElementById('gantchart-today');

      if (gantchartToday) {
        const gantchartDateRowLeft = gantchartDateRow.getBoundingClientRect().left;

        const gantchartTodayLeft = gantchartToday.getBoundingClientRect().left;

        const scroll = gantchartTodayLeft - gantchartDateRowLeft;

        gantchartTableBox.scrollLeft = scroll;
      }
    },

    methods: {
      backGoalShow(goal_id) {
        this.$inertia.get(`/home/${goal_id}`)
      },
    }
  }
</script>
