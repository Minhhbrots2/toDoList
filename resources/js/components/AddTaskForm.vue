<template>
  <div>
    <input class="form-control" v-model="newTaskName" @keyup.enter="addTask" placeholder="Thêm 1 công việc mới" />
    <button class="btn btn-primary" @click="addTask">Add Task</button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { defineEmits } from 'vue';

const newTaskName = ref('');

const emit = defineEmits(['task-added']);

const addTask = async () => {
  if (newTaskName.value.trim() !== '') {
    const response = await axios.post('/api/tasks', { name: newTaskName.value });
    emit('task-added', response.data);
    newTaskName.value = '';
  }
};
</script>