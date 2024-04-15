<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Editar">
            <div class="row q-col-gutter-md">
                <div class="col-12 col-md-6">
                    <app-user-select label="Usuário" v-model="save.data.user_id" />
                    <br>

                    <q-input label="Descrição" v-model="save.data.description" />
                    <br>

                    <q-field label="Valor">
                        <template #control>
                            <input
                                class="q-field__input text-right"
                                v-maska="'money'"
                                :value="save.data.amount"
                                @input="(ev) => {
                                    save.data.amount = parseInt(ev.target.value.replace(/[^0-9]/g, ''))/100;
                                }"
                            />
                        </template>
                    </q-field>
                </div>
                <div class="col-12 col-md-6">
                    <div>Data lançamento</div>
                    <q-date
                        landscape
                        mask="YYYY-MM-DD 00:00:00"
                        v-model="save.data.date"
                    />
                </div>
            </div>

            <pre>{{ route.query }}</pre>
            <pre>{{ save }}</pre>
            
            <template #actions>
                <q-btn label="Buscar" to="/admin/financial_expense" />
            </template>

            <template #sidebar>
                <div class="column" style="gap: 10px;">
                    <q-btn
                        label="Salvar"
                        :loading="save.busy"
                        @click="save.submit()"
                    />
                </div>
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const route = useRoute();

const save = useRequest({
    method: () => {
        return route.query.id ? 'put' : 'post';
    },
    url: () => {
        return route.query.id ? `api://financial_expense/${route.query.id}` : 'api://financial_expense';
    },
    data: {},
});

const load = useRequest({
    method: 'get',
    url: () => route.query.id ? `api://financial_expense/${route.query.id}` : null,
    onSuccess(resp) {
        console.log('aaa');
        save.data = resp.data.data;
    },
});

onMounted(() => {
    if (!isNaN(+route.query.id)) {
        load.submit();
    }
});
</script>