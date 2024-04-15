<template>
    <div>
        <nuxt-layout name="auth">
            <q-input label="E-mail" v-model="login.data.email" />
            <q-input label="Senha" v-model="login.data.password" />
            <q-btn label="Acessar" style="width: 100%;" @click="login.submit()" />
        </nuxt-layout>
    </div>
</template>

<script setup>
const login = useRequest({
    method: 'post',
    url: 'api://auth/login',
    data: { email: '', password: '' },
    onSuccess({ data }) {
        localStorage.setItem('app_token', data.access_token);

        const redirect = localStorage.getItem('app_redirect');
        if (redirect) {
            localStorage.removeItem('app_redirect');
            location.href = redirect;
        }
    },
});
</script>