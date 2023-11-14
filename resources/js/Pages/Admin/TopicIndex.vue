<template>
    <div>
        <h1>Fachliche Themen</h1>
        <Link
            :href="`/admin/topics/create`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow"
            >Neues fachliches Thema</Link
        >
        <ul v-if="topics.length > 0" class="mt-4">
            <li v-for="topic in topics">
                <Link
                    :href="`/admin/topics/${topic.id}`"
                    class="hover:text-thunderbird-red"
                    >{{ topic.name }}</Link
                >
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { TopicsResource } from "@/types";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    topicsResource: {
        type: Object as PropType<TopicsResource>,
        required: true,
    },
});

const topics = computed(() => props.topicsResource.data);
</script>

<style scoped></style>
