<template>
    <div>
        <h1>Aufbewahrungsorte</h1>
        <Link
            :href="`/admin/locations/create`"
            class="hfh-button hfh-button--primary hfh-button--icon-arrow"
            >Neuer Aufbewahrungsort</Link
        >
        <ul v-if="locations.length > 0" class="mt-4">
            <li v-for="location in locations">
                <Link
                    :href="`/admin/locations/${location.id}`"
                    class="hover:text-thunderbird-red"
                    >{{ location.name }}</Link
                >
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { PropType, computed } from "vue";
import { LocationsResource } from "@/types";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    locationsResource: {
        type: Object as PropType<LocationsResource>,
        required: true,
    },
});

const locations = computed(() => props.locationsResource.data);
</script>

<style scoped></style>
