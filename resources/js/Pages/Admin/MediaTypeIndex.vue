<template>
    <div>
        <h1>Medienarten</h1>
        <Link
            :href="`/admin/media-types/create`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow"
            >Neue Medienart</Link
        >
        <ul v-if="mediaTypes.length > 0" class="mt-4">
            <li v-for="mediaType in mediaTypes">
                <Link
                    :href="`/admin/media-types/${mediaType.id}`"
                    class="hover:text-thunderbird-red"
                    >{{ mediaType.name }}</Link
                >
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { MediaTypesResource } from "@/types";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    mediaTypesResource: {
        type: Object as PropType<MediaTypesResource>,
        required: true,
    },
});

const mediaTypes = computed(() => props.mediaTypesResource.data);
</script>

<style scoped></style>
