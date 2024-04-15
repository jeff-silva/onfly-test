<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Editar">
            <div class="row q-col-gutter-lg">
                <div class="col-12 col-lg-6">
                    <app-user-select label="Usuário" v-model="save.data.user_id" />
                    <br>

                    <q-input label="Descrição" v-model="save.data.description" />
                    <br>

                    <q-field label="Valor">
                        <template #control>
                            <input
                                class="q-field__input text-right"
                                v-maska="'money'"
                                :value="parseFloat(save.data.amount).toFixed(2)"
                                @input="(ev) => {
                                    save.data.amount = parseInt(ev.target.value.replace(/[^0-9]/g, ''))/100;
                                }"
                            />
                        </template>
                    </q-field>
                </div>
                <div class="col-12 col-lg-6">
                    <div>Data de lançamento:</div>
                    <br>
                    <q-date
                        :landscape="$q.screen.gt.md"
                        style="width: 100%; max-width: 500px;"
                        mask="YYYY-MM-DD 00:00:00"
                        v-model="save.data.date"
                    />
                </div>
            </div>
            
            <template #actions>
                <q-btn label="Voltar" to="/admin/financial_expense" color="primary" />
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
const router = useRouter();

const save = useRequest({
    method: () => route.query.id ? 'put' : 'post',
    url: () => {
        return route.query.id ? `api://financial_expense/${route.query.id}` : 'api://financial_expense';
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
    url: () => route.query.id ? `api://financial_expense/${route.query.id}` : null,
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