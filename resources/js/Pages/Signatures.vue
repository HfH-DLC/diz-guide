<template>
    <div>
        <div class="hfh-content">
            <h1>Signatursuche</h1>
            <p>
                Mit der Signatursuche können sie die Aufbewahrungsorte der
                Artikel aus der vollständigen Materialliste des DiZ suchen.
                Tippen sie die vollständige Signatur, oder den ersten Teil davon
                ein, zum Beispiel <strong>1.4.2.3</strong> oder
                <strong>1.4.2.3 - 006</strong>.
            </p>
        </div>
        <div
            class="mt-8 bg-fantasy-light w-full pt-6 pb-6 pl-10 pr-5 flex justify-center"
        >
            <Search
                label="Signatursuche"
                @search="search"
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
        "/signatursuche",
        { search: searchText.value },
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
