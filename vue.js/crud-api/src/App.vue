<script setup>
import axios from 'axios';
import { ref } from 'vue'
const apiUrl = 'http://127.0.0.1:8080/api/create-memo.php';

const user = ref({})

const postMemo = () => {
  const params = new URLSearchParams();
  params.append('body', 'vue.jsアプリから送信');
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
  <div>
    <button @click="postMemo">post Memo</button>
  </div>
</template>