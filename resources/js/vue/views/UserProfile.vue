<template>
    <div>
        <h2>User Profile</h2>
        <p>Name: {{ user.name }}</p>
        <p>Email: {{ user.email }}</p>
        <button @click="logout">Logout</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return { user: {} };
    },
    async created() {
        let res = await axios.get('http://localhost:8000/api/user', {
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
        });
        this.user = res.data;
    },
    methods: {
        async logout() {
            await axios.post('http://localhost:8000/api/logout');
            localStorage.removeItem('token');
            this.$router.push('/login');
        }
    }
};
</script>
