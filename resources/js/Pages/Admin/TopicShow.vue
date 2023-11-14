<template>
    <div>
        <h1>{{ topic.name }}</h1>
        <Link
            :href="`/admin/topics/${topic.id}/edit`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow mt-4"
            >Bearbeiten</Link
        >
        <HfhButton class="block mt-4" @click="deleteTopic">Löschen</HfhButton>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { TopicResource } from "../../types";
import { HfhButton } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    topicResource: {
        type: Object as PropType<TopicResource>,
        required: true,
    },
});

const topic = computed(() => props.topicResource.data);

const deleteTopic = () => {
    if (
        confirm(
            `Willst du das fachliche Thema "${topic.value.name}" wirklich löschen?`
        )
    ) {
        router.delete(`/admin/topics/${topic.value.id}`);
    }
};
</script>

<style lang="scss" scoped>
img {
    max-width: calc(min(100%, 60rem));
}
</style>
