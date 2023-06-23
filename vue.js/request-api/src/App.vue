<script setup>
import axios from 'axios';
import { ref } from 'vue'
// const apiUrl = 'http://127.0.0.1:8080/api.php';
const apiUrl = 'https://jsonplaceholder.typicode.com/todos/1'

const user = ref({})

const getUser = () => {
  axios.get(apiUrl)
      .then(response => user.value = response.data)
}
</script>

<template>
  <div>
    <button @click="getUser">getUser</button>
  </div>
  <table>
    <thead>
        <tr>
            <th>id</th>
            <th>title</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ user.id }}</td>
            <td>{{ user.title }}</td>
        </tr>
    </tbody>
  </table>
</template>

