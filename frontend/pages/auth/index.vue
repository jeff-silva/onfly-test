<template>
    <div>
        <nuxt-layout name="auth">
            <form @submit.prevent="login.submit()">
                <q-card>
                    <q-card-section>
                        <q-input label="E-mail" v-model="login.data.email" />
                        <br>
                        <q-input label="Senha" v-model="login.data.password" />
                    </q-card-section>
                    <q-card-actions class="justify-end">
                        <q-btn
                            flat
                            label="Login"
                            type="submit"
                            @click="login.submit()"
                            :loading="login.busy"
                        />
                    </q-card-actions>
                </q-card>
            </form>
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
        router.push(route.query.redirect || '/admin');
    },
});
</script>