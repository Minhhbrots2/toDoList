<template>
  <div class="task-item" :class="{ done: localCompleted }">
    <input type="checkbox" v-model="localCompleted" @change="toggleCompleted" />
    <span :class="{ completed: localCompleted }" v-if="!isEditing" @dblclick="enableEdit">{{ task.name }}</span>
    <input v-else type="text" v-model="editableName" @blur="saveEdit" @keyup.enter="saveEdit" />
    <button class="btn-delete" @click="deleteTask"><i class="fas fa-trash"></i></button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue';
import axios from 'axios';
import { useToast } from 'vue-toastification';
const props = defineProps({
  task: Object
});

const emit = defineEmits(['update-task', 'delete-task']);
const toast = useToast();
const isEditing = ref(false);
const editableName = ref(props.task.name);
const localCompleted = ref(props.task.completed); 

const enableEdit = () => {
  isEditing.value = true;
  editableName.value = props.task.name;
};

const saveEdit = async () => {
  if (editableName.value.trim() !== '') {
    isEditing.value = false;
    const updatedTask = { ...props.task, name: editableName.value };
    try {
      await axios.put(`/api/tasks/${updatedTask.id}`, updatedTask);
      emit('update-task', updatedTask);
      toast.success('Thay đổi cập nhật thành công');
    } catch (error) {
      toast.error('Có lỗi xin vui lòng thử lại.');
    }
  }
};

const toggleCompleted = async () => {
  const updatedTask = { ...props.task, completed: localCompleted.value };
  try {
    await axios.put(`/api/tasks/${updatedTask.id}`, updatedTask);
    emit('update-task', updatedTask);
    toast.success('Thay đổi trạng thái thành công');
  } catch (error) {
    toast.error('hay đổi trạng thái thất bại');
  }
};
const deleteTask = () => {
  try {
    emit('delete-task', props.task.id);
    toast.success('Xóa việc làm thành công!');
  } catch (error) {
    toast.error('Xóa việc làm thất bại');
  }
};


</script>

<style scoped>
.completed {
  text-decoration: line-through;
}
</style>