<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Editar">
            <div class="row">
                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="Descrição" />
                </div>

                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="Data" />
                </div>

                <div class="col-12 col-md-6 q-pa-sm">
                    <q-input label="Valor" />
                </div>
            </div>

            
            <!-- <template #header>
                <q-tabs>
                    <q-tab label="Aaa" to="/financial_expense/edit?tab=1" />
                    <q-tab label="Bbb" to="/financial_expense/edit?tab=2" />
                    <q-tab label="Ccc" to="/financial_expense/edit?tab=3" />
                </q-tabs>
            </template> -->
            
            <template #actions>
                <q-btn label="Buscar" to="/admin/financial_expense" />
            </template>

            <template #footer>
                <q-btn label="Salvar" flat />
            </template>
        </nuxt-layout>
    </div>
</template>