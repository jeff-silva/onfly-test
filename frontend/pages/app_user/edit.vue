<template>
    <div>
        <nuxt-layout name="admin" title="Usuários" subtitle="Editar">
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
            
            <template #actions>
                <q-btn label="Buscar" to="/app_user" />
            </template>

            <template #footer>
                <q-btn label="Salvar" flat />
            </template>
        </nuxt-layout>
    </div>
</template>