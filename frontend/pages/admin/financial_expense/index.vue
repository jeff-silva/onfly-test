<template>
    <div>
        <nuxt-layout name="admin" title="Despesas" subtitle="Pesquisar">
            <div>Busca</div>

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