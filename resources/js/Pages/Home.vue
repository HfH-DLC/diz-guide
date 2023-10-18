<template>
    <header>
        <HfhHeaderBar>
            <template v-slot:right>
                <HfhMenu :items="menuItems" variant="tertiary" />
            </template>
        </HfhHeaderBar>
        <div class="mx-4 xl:max-w-container xl:mx-auto">
            <div class="inline-flex gap-x-4 mt-12 mb-12 items-center">
                <HfhLogo />
                <h1 class="text-2xl mb-[3px]">DiZ Guide</h1>
            </div>
        </div>
    </header>
    <main class="mx-4 xl:max-w-container xl:mx-auto">
        <div class="flex items-center flex-col">
            <p>Erkunden Sie das Angebot des DiZ.</p>
            <div class="mt-16 w-full flex justify-center">
                <Search></Search>
            </div>
            <div class="mt-16 w-full">
                <LoadingIndicator v-if="loading" class="mx-auto" />
                <Results v-else :results="results"></Results>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { HfhHeaderBar, HfhLogo, HfhMenu } from "@hfh-dlc/hfh-styleguide";
import Search from "../Components/Search.vue";
import LoadingIndicator from "../Components/LoadingIndicator.vue";
import Results from "../Components/Results.vue";
import { ref } from "vue";
import type { ResultData } from "../types";

const menuItems = [
    { label: "hfh.ch", link: { href: "https://hfh.ch", target: "_blank" } },
];
const loading = ref(false);

const results: Array<ResultData> = [
    {
        mainCategory: "Sprache",
        mediaType: "Buch",
        signatureAndTopic: "1.1.3.1 Grafomotorik",
        location: {
            label: "Rollgestell Nr.1",
            imageSrc: "#",
        },
    },
    {
        mainCategory: "Sprache",
        signatureAndTopic: "1.1.3.1 Grafomotorik",
        mediaType: "Buch",
        location: {
            label: "Rollgestell Nr.1",
            imageSrc: "#",
        },
    },
];
</script>

<style scoped></style>
