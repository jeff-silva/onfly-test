<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Pesquisar">
            <q-table
                row-key="id"
                :loading="search.busy"
                :rows="search.response.data"
                :columns="[
                    { name: 'description', field: 'description', align: 'left', label: 'Descrição' },
                    { name: 'date', field: 'date', align: 'left', label: 'Data' },
                    { name: 'amount', field: 'amount', align: 'left', label: 'Valor' },
                    { name: 'actions', label: '', width: '100px' },
                ]"
            >
                <template #body-cell-actions="props">
                    <q-td :props="props">
                        <q-btn flat icon="mode_edit" :to="`/admin/financial_expense/edit?id=${props.row.id}`" />
                        <!-- <q-btn flat icon="delete" /> -->
                    </q-td>
                </template>
            </q-table>

            <template #actions>
                <div class="column" style="gap: 10px;">
                    <q-btn label="Novo" to="/financial_expense/edit" />
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
    url: 'api://financial_expense',
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