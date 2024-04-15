<template>
    <q-select
        use-input
        :model-value="props.modelValue"
        :options="[
            { value: null, label: 'Ninguém' },
            ...search.response.data.map((o) => ({ value: o.id, label: o.name }))
        ]"
        @update:modelValue="(ev) => {
            emit('update:modelValue', ev.value);
        }"
    />
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [Number, String],
        default: null,
    },
});

const emit = defineEmits(["update:modelValue"]);

const search = useRequest({
    method: 'get',
    url: 'api://app_user',
    params: { q: '', per_page: 50 },
    response: { data: [] },
});

onMounted(() => {
    search.submit();
});
</script>