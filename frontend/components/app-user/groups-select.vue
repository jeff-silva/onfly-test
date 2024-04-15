<template>
    <q-select
        use-input
        :model-value="props.modelValue"
        :options="[
            { value: null, label: 'Ninguém' },
            ...search.response.map((o) => ({ value: o.id, label: o.name }))
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
    url: 'api://app_user/groups',
    response: [],
});

onMounted(() => {
    search.submit();
});
</script>