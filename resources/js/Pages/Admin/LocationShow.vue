<template>
    <div>
        <h1>{{ location.name }}</h1>
        <img
            v-if="location.imageSrc"
            :src="location.imageSrc"
            :alt="location.imageAlt"
        />
        <Link
            :href="`/admin/locations/${location.id}/edit`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow mt-4"
            >Bearbeiten</Link
        >
        <HfhButton class="block mt-4" @click="deleteLocation"
            >Löschen</HfhButton
        >
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { LocationResource } from "../../types";
import { router } from "@inertiajs/vue3";
import { HfhButton } from "@hfh-dlc/hfh-styleguide";

const props = defineProps({
    locationResource: {
        type: Object as PropType<LocationResource>,
        required: true,
    },
});

const location = computed(() => props.locationResource.data);

const deleteLocation = () => {
    if (
        confirm(
            `Willst du den Aufbewahrungsort "${location.value.name}" wirklich löschen?`
        )
    ) {
        router.delete(`/admin/locations/${location.value.id}`);
    }
};
</script>

<style lang="scss" scoped>
img {
    max-width: calc(min(100%, 60rem));
}
</style>
