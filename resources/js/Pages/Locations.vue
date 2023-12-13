<template>
    <div>
        <div class="hfh-content">
            <h1>Suche nach Aufbewahrungsorten</h1>
        </div>
        <form
            @submit.prevent="search"
            class="bg-fantasy-light w-full pt-6 pb-6 pl-10 pr-5"
        >
            <div class="md:flex flex-wrap gap-x-12 gap-y-4">
                <div class="hfh-label flex-shrink-0">Suchen nach</div>
                <div class="flex flex-wrap gap-x-6 gap-y-4 flex-1">
                    <div class="flex-1">
                        <HfhCheckbox
                            id="location"
                            legend="Aufbewahrungsort"
                            :options="locationOptions"
                            v-model="filter.locationIds"
                            orientation="vertical"
                        ></HfhCheckbox>
                    </div>
                </div>
            </div>
            <ul v-if="errors" class="my-8">
                <li v-for="error in errors" class="text-base">
                    {{ error.message }}
                </li>
            </ul>
            <div class="mt-8 flex flex-wrap gap-x-8 gap-y-4">
                <HfhButton type="submit" :animated="true">Suchen</HfhButton>
                <HfhButton :animated="true" :primary="false" @click="reset"
                    >Zurücksetzen</HfhButton
                >
            </div>
        </form>
        <div class="mt-16 w-full">
            <LoadingIndicator v-if="loading" class="mx-auto" />
            <Results v-else-if="displayResults" :results="items"></Results>
        </div>
    </div>
</template>

<script setup lang="ts">
import { HfhCheckbox, HfhButton } from "@hfh-dlc/hfh-styleguide";
import LoadingIndicator from "../Components/LoadingIndicator.vue";
import Results from "../Components/Results.vue";
import { PropType, Ref, computed, ref } from "vue";
import type { ItemsResource, LocationsResource } from "../types";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    itemsResource: {
        type: Object as PropType<ItemsResource>,
        required: true,
    },
    locationsResource: {
        type: Object as PropType<LocationsResource>,
        required: true,
    },
});

const items = computed(() => props.itemsResource.data);

const locationOptions = computed(() =>
    props.locationsResource.data.map((locationData) => ({
        label: locationData.name,
        name: `location-${locationData.id}`,
        value: `${locationData.id}`,
    }))
);

const query = new URLSearchParams(window.location.search);
const locationIds = query.getAll("locationIds[]");

const filter = ref({
    locationIds: locationIds,
});

const displayResults = computed(() => locationIds.length > 0);

const errors: Ref<Array<{ message: string }>> = ref([]);

const search = () => {
    errors.value = [];
    if (filter.value.locationIds.length == 0) {
        errors.value.push({
            message: "Bitte wählen Sie mindestens einen Aufbewahrungsort aus.",
        });
    }
    if (errors.value.length > 0) {
        return;
    }
    router.get("/ortsuche", filter.value, {
        preserveState: false,
        preserveScroll: true,
        replace: true,
    });
};

const reset = () => {
    router.get(
        "/ortsuche",
        {},
        {
            preserveState: false,
            preserveScroll: true,
            replace: true,
        }
    );
};

const loading = ref(false);
</script>

<style scoped>
::v-deep .hfh-checkbox-fieldset__options {
    display: block;
    @media screen and (min-width: 640px) {
        column-count: 2;
    }
    @media screen and (min-width: 1024px) {
        column-count: 3;
    }
}
</style>
