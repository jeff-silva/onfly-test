<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Editar">
            <q-banner v-if="load.error" inline-actions class="text-white bg-red">
                {{ load.error.message }}
                <template v-slot:action>
                    <q-btn flat color="white" label="Voltar" to="/admin/financial_expense" />
                </template>
            </q-banner>

            <div class="row q-col-gutter-lg" v-if="!load.error">
                <div class="col-12 col-lg-6">
                    <!-- <app-user-select label="Usuário" v-model="save.data.user_id" />
                    <br> -->

                    <q-input
                        label="Descrição"
                        v-model="save.data.description"
                        :error-message="save.getErrors('description', false)"
                        :error="save.hasError('description')"
                    />
                    <br>

                    <q-input
                        label="Price with 2 decimals"
                        v-model="save.data.amount"
                        mask="#.##"
                        fill-mask="0"
                        reverse-fill-mask
                        input-class="text-right"
                    />
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
                    <div
                        class="text-red q-mt-sm"
                        v-if="save.hasError('date')"
                        v-html="save.getErrors('date', false)"
                    ></div>
                </div>
            </div>

            <q-dialog
                v-model="save.success"
                seamless
                position="bottom"
            >
                <q-card style="width: 350px" class="bg-teal text-white">
                    <q-card-section class="row items-center no-wrap">
                        <div>Dados salvos</div>
                        <q-space />
                        <q-btn flat round icon="close" @click="save.success=false" />
                    </q-card-section>
                </q-card>
            </q-dialog>

            <template #sidebar>
                <div class="column" style="gap: 15px;">
                    <q-btn
                        v-if="!load.error"
                        label="Salvar"
                        :loading="save.busy"
                        @click="save.submit()"
                        color="primary"
                    />

                    <q-btn label="Voltar" to="/admin/financial_expense" />
                </div>
            </template>
        </nuxt-layout>
    </div>
</template>

<script setup>
const route = useRoute();
const router = useRouter();
const app = useApp();

const save = useRequest({
    method: () => route.query.id ? 'put' : 'post',
    url: () => {
        return route.query.id ? `api://financial_expense/${route.query.id}` : 'api://financial_expense';
    },
    data: {},
    onRequestBefore() {
        if (save.data.user_id) return;
        save.data.user_id = app.data.user.id;
    },
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