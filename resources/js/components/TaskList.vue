<template>
  <div class="panel__todo">
    <div class="container">
      <div class="row" style="justify-content: center;">
        <div class="col-4">
          <div class="card card-body">
            <div class="panel__todo--box">
              <h2 class="heading-2"><span>List công việc</span></h2>
              <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-circle-plus fa-fw"></i>
              </button>
            </div>
            <draggable v-model="taskList" @end="updateTaskOrder">
              <template #item="{ element }">
                <Task :task="element" @update-task="updateTask" @delete-task="deleteTask" />
              </template>
            </draggable>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Thêm công việc</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input class="form-control" v-model="newTaskList" @keyup.enter="addTaskToList" placeholder="Thêm 1 công việc mới" />
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" @click="addTaskToList" data-bs-dismiss="modal">Add Task</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Task from './Task.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import draggable from 'vuedraggable';
import { useToast } from 'vue-toastification';

const newTaskList = ref('');
const taskList = ref([]);
const toast = useToast();

const getTasks = async () => {
  const response = await axios.get('/api/tasks');
  taskList.value = response.data;
};

const addTaskToList = async () => {
  if (newTaskList.value.trim() !== '') {
    const response = await axios.post('/api/tasks', {
      name: newTaskList.value,
      order: taskList.value.length,
    });
    toast.success('Tạo mới đầu việc thành công');
    taskList.value.push(response.data);
    newTaskList.value = '';
  }else{
    toast.error('Bạn phải nhập việc làm');
  }
};

const updateTask = async (updatedTask) => {
  const index = taskList.value.findIndex(task => task.id === updatedTask.id);
  if (index !== -1) {

    taskList.value[index] = updatedTask;
    await axios.put(`/api/tasks/${updatedTask.id}`, updatedTask);
  }
};

const deleteTask = async (id) => {
  await axios.delete(`/api/tasks/${id}`);
  taskList.value = taskList.value.filter(task => task.id !== id);
};

const updateTaskOrder = async () => {
  const updatedTasks = taskList.value.map((task, index) => ({
    id: task.id,
    order: index,
  }));
  await axios.post('/api/tasks/order', { tasks: updatedTasks });
};

onMounted(getTasks);
</script>

<style scoped>
.completed {
  text-decoration: line-through;
}
</style>