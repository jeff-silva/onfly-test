<template>
    <q-layout view="hHh Lpr lff" container style="height: 100vh" class="shadow-2">
        <q-header bordered>
            <q-toolbar>
                <q-btn flat @click="nav.drawer()" round dense icon="menu" />
                <q-toolbar-title v-if="props.title">
                    {{ props.title }}
                </q-toolbar-title>
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="nav.drawerVisible"
            show-if-above
            :breakpoint="700"
            bordered
        >
            <q-scroll-area class="fit">
                <q-list>
                    <template v-for="item in nav.items">
                        <q-item :to="item.to">
                            <q-item-section>
                                {{ item.title }}
                            </q-item-section>
                        </q-item>
                    </template>
                </q-list>
            </q-scroll-area>
        </q-drawer>

        <q-page-container>
            <div v-if="props.subtitle" class="bg-primary text-white q-pa-md">
                {{ props.subtitle }}
            </div>
            <slot name="header"></slot>
            <q-page padding>
                <slot></slot>
            </q-page>
        </q-page-container>

        <q-page-sticky position="bottom-right" :offset="[10, 50]">
            <slot name="actions"></slot>
        </q-page-sticky>
        
        <q-page-sticky position="bottom" class="bg-blue-grey-1">
            <slot name="footer"></slot>
        </q-page-sticky>
    </q-layout>
  </template>

<script setup>
const props = defineProps({
    title: {
        type: String,
        default: null,
    },
    subtitle: {
        type: String,
        default: null,
    },
});

const nav = reactive({
    drawerVisible: false,
    drawer(value = null) {
        this.drawerVisible = value===null ? !this.drawerVisible : value;
    },
    items: [
        { title: 'Dashboard', to: '/' },
        { title: 'Usuários', to: '/app_user' },
        { title: 'Despesas', to: '/financial_expense' },
    ],
});
</script>