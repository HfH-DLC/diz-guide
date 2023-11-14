<template>
    <div>
        <h1>Fachliches Thema bearbeiten</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="topic-name"
                required
            ></HfhInput>
            <HfhButton type="submit">Speichern</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { TopicResource } from "@/types";
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";
import { PropType, computed } from "vue";

const props = defineProps({
    topicResource: {
        type: Object as PropType<TopicResource>,
        required: true,
    },
});

const topic = computed(() => props.topicResource.data);

const form = useForm({
    name: topic.value.name,
});

const submit = () => {
    form.put(`/admin/topics/${topic.value.id}`);
};
</script>

<style lang="scss" scoped></style>
