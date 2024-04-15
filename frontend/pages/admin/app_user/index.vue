<template>
    <div>
        <nuxt-layout name="admin" title="Usuários" subtitle="Pesquisar">
            <q-table
                row-key="id"
                :loading="search.busy"
                :rows="search.response.data"
                :columns="[
                    { name: 'name', field: 'name', align: 'left', label: 'Nome' },
                    { name: 'email', field: 'email', align: 'left', label: 'E-mail' },
                    { name: 'group', field: 'group', align: 'left', label: 'Grupo' },
                    { name: 'actions', label: '', width: '100px' },
                ]"
                :pagination="{
                    page: search.params.page,
                    rowsPerPage: search.params.per_page,
                }"
                @update:pagination="(ev) => {
                    search.params.per_page = ev.rowsPerPage;
                    search.submit();
                }"
            >
                <template #body-cell-actions="props">
                    <q-td :props="props">
                        <q-btn flat icon="mode_edit" :to="`/admin/app_user/edit?id=${props.row.id}`" />
                        <!-- <q-btn flat icon="delete" /> -->
                    </q-td>
                </template>
            </q-table>

            <template #sidebar>
                <form @submit.prevent="search.submit()" class="column" style="gap: 10px;">
                    <q-input label="Busca" v-model="search.params.q" />
                    <q-btn label="Buscar" type="submit" :loading="search.busy" />
                </form>
            </template>
            
            <template #actions>
                <div class="column" style="gap: 10px;">
                    <q-btn label="Novo" to="/admin/app_user/edit" />
                </div>
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const search = useRequest({
    method: 'get',
    url: 'api://app_user',
    params: { q: '', page: 1, per_page: 20 },
    response: {
        pagination: {},
        data: [],
    },
});

onMounted(() => {
    search.submit();
});
</script>