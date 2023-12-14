<template>
    <div>
        <div class="hfh-content">
            <h1>Stichwortsuche</h1>
            <p>
                Unsere Sammlung deckt über 150 Fachthemen ab. Einfach die
                Stichwortsuche verwenden, oder ohne Stichwort suchen, um die
                gesammte Themenliste zu sehen.
            </p>
        </div>
        <div class="mt-8 bg-fantasy-light w-full pt-6 pb-6 pl-10 pr-5 flex">
            <Search
                label="Stichwortsuche nach Fachthema"
                @search="search"
                @reset="reset"
                :searchText="searchText"
            ></Search>
        </div>
        <div class="mt-16 w-full">
            <LoadingIndicator v-if="loading" class="mx-auto" />
            <Results v-else-if="displayResults" :results="items"></Results>
        </div>
    </div>
</template>

<script setup lang="ts">
import Search from "../Components/Search.vue";
import LoadingIndicator from "../Components/LoadingIndicator.vue";
import Results from "../Components/Results.vue";
import { PropType, computed, ref } from "vue";
import type { ItemsResource } from "../types";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    itemsResource: {
        type: Object as PropType<ItemsResource>,
        required: true,
    },
});

const items = computed(() => props.itemsResource.data);

const query = new URLSearchParams(window.location.search);

const searchText = ref(query.get("search") || "");

const search = (value: string) => {
    searchText.value = value;
    router.get(
        "/stichwortsuche",
        { search: searchText.value },
        {
            preserveState: false,
            preserveScroll: true,
            replace: true,
        }
    );
};

const reset = () => {
    router.get(
        "/stichwortsuche",
        {},
        {
            preserveState: false,
            preserveScroll: true,
            replace: true,
        }
    );
};

const displayResults = query.has("search");

const loading = ref(false);
</script>

<style scoped></style>
