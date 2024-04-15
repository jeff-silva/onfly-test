<template>
    <div>
        <nuxt-layout name="admin" title="Usuários" subtitle="Pesquisar">
            <div>Busca</div>
            <q-btn label="Load" @click="search.submit()" :loading="search.busy" />
            <pre>{{ search }}</pre>

            <template #actions>
                <div class="column" style="gap: 10px;">
                    <q-btn label="Novo" to="/app_user/edit" />
                </div>
            </template>
            
            <template #footer>
                <q-btn label="Aaa" flat />
                <q-btn label="Aaa" flat />
                <q-btn label="Aaa" flat />
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const search = useRequest({
    method: 'get',
    url: 'api://app_user',
    params: { q: '' },
    response: {
        pagination: {},
        data: [],
    },
});

onMounted(() => {
    search.submit();
});
</script>