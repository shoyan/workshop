<script setup>
import axios from 'axios';
import { ref } from 'vue'
const apiUrl = 'http://127.0.0.1:8080/api/create-memo.php';

const body = ref([])
const user = ref({})

const postMemo = () => {
  const params = new URLSearchParams();
  body.value.forEach((val) => {
    params.append('body[]', val);
  });
  axios.post(apiUrl, params)
    .then(function (response) {
      console.log(response);
    })
    .catch(function (error) {
      console.log(error);
    });
}
</script>

<template>
  <ul>
    <li><input v-model="body[0]"></li>
    <li><input v-model="body[1]"></li>
    <li><input v-model="body[2]"></li>
  </ul>

  <div>
    <button @click="postMemo">post Memo</button>
  </div>
</template>