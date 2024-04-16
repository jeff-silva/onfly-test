<template>
    <div>
        <nuxt-layout name="admin" title="Usuários" subtitle="Editar">
            <div class="row">
                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="Nome" v-model="save.data.name" />
                </div>
                
                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="E-mail" v-model="save.data.email" />
                </div>
                
                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="Senha" v-model="save.data.password" type="password" />
                </div>
            </div>
            
            <template #actions>
                <q-btn label="Buscar" to="/admin/app_user" />
            </template>

            <template #sidebar>
                <div class="column" style="gap: 15px;">
                    <q-btn
                        label="Salvar"
                        :loading="save.busy"
                        @click="save.submit()"
                        color="primary"
                    />

                    <q-btn label="Voltar" to="/admin/app_user" />
                </div>
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const route = useRoute();
const router = useRouter();

const save = useRequest({
    method: () => route.query.id ? 'put' : 'post',
    url: () => {
        return route.query.id ? `api://app_user/${route.query.id}` : 'api://app_user';
    },
    data: {},
    onSuccess: ({ data }) => {
        const query = { ...route.query, id: data.data.id };
        router.push({ query });
        save.data = data.data;
    },
});

const load = useRequest({
    method: 'get',
    url: () => route.query.id ? `api://app_user/${route.query.id}` : null,
    onSuccess(resp) {
        save.data = resp.data.data;
    },
});

onMounted(() => {
    if (!isNaN(+route.query.id)) {
        load.submit();
    }
});
</script>