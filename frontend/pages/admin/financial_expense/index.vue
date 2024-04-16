<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Pesquisar">
            <q-table
                row-key="id"
                virtual-scroll
                :loading="search.busy"
                :rows="search.response.data"
                :columns="[
                    { name: 'description', field: 'description', align: 'left', label: 'Descrição' },
                    { name: 'date', field: 'date', align: 'left', label: 'Data' },
                    { name: 'amount', field: 'amount', align: 'left', label: 'Valor' },
                    { name: 'user_id', field: 'user_id', align: 'left', label: 'Dono' },
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
                        <q-btn
                            v-if="props.row.user_id == app.data.user.id"
                            flat icon="mode_edit"
                            :to="`/admin/financial_expense/edit?id=${props.row.id}`"
                        />
                        <!-- <q-btn
                            v-if="props.row.user_id == app.data.user.id"
                            flat icon="delete"
                        /> -->
                    </q-td>
                </template>
            </q-table>

            <template #sidebar>
                <form @submit.prevent="search.submit()" class="column" style="gap: 15px;">
                    <q-input label="Busca" v-model="search.params.q" />
                    <q-date
                        range
                        mask="YYYY-MM-DD"
                        style="width: 100%;"
                        :model-value="{
                            from: search.params.date_min,
                            to: search.params.date_max,
                        }"
                        @update:modelValue="(ev) => {
                            search.params.date_min = `${ev.from}T00:00:00`;
                            search.params.date_max = `${ev.to}T23:59:59`;
                        }"
                    />
                    <q-btn
                        label="Limpar calendário"
                        @click="() => {
                            search.params.date_min = '';
                            search.params.date_max = '';
                        }"
                    />
                    <q-btn label="Buscar" type="submit" :loading="search.busy" />
                </form>
            </template>

            <template #actions>
                <div class="column" style="gap: 10px;">
                    <q-btn label="Novo" to="/admin/financial_expense/edit" color="primary" />
                </div>
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const app = useApp();

const search = useRequest({
    method: 'get',
    url: 'api://financial_expense',
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