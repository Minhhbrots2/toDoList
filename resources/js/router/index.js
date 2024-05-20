import { createRouter, createWebHistory } from 'vue-router'
import TaskList from '../components/AddTaskForm.vue'

const routes = [
  { path: '/', component: TaskList }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router