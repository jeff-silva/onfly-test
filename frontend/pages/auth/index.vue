<template>
    <div>
        <nuxt-layout name="auth">
            <q-input label="E-mail" v-model="login.data.email" />
            <q-input label="Senha" v-model="login.data.password" />
            <q-btn label="Acessar" style="width: 100%;" @click="login.submit()" />
            <pre>{{ app.user }}</pre>
        </nuxt-layout>
    </div>
</template>

<script setup>
const route = useRoute();
const router = useRouter();
const app = useApp();

const login = useRequest({
    method: 'post',
    url: 'api://auth/login',
    data: { email: '', password: '' },
    async onSuccess({ data }) {
        localStorage.setItem('app_token', data.access_token);
        await app.refresh();
        setTimeout(() => {
            location.href = route.query.redirect || '/admin';
            // router.push(route.query.redirect || '/admin');
            // console.log(route.query.redirect || '/admin');
        }, 1000);
    },
});
</script>