<template>
    <div>
        <h1>{{ mediaType.name }}</h1>
        <Link
            :href="`/admin/media-types/${mediaType.id}/edit`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow mt-4"
            >Bearbeiten</Link
        >
        <HfhButton class="block mt-4" @click="deleteMediaType"
            >Löschen</HfhButton
        >
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { MediaTypeResource } from "../../types";
import { HfhButton } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    mediaTypeResource: {
        type: Object as PropType<MediaTypeResource>,
        required: true,
    },
});

const mediaType = computed(() => props.mediaTypeResource.data);

const deleteMediaType = () => {
    if (
        confirm(
            `Willst du die Medienart "${mediaType.value.name}" wirklich löschen?`
        )
    ) {
        router.delete(`/admin/media-types/${mediaType.value.id}`);
    }
};
</script>

<style lang="scss" scoped>
img {
    max-width: calc(min(100%, 60rem));
}
</style>
