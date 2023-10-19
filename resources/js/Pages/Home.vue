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
    <main class="mx-4 xl:max-w-container xl:mx-auto pb-20">
        <div class="flex items-center flex-col">
            <p>Erkunden Sie das Angebot des DiZ.</p>
            <div class="mt-16 w-full flex justify-center">
                <Search></Search>
            </div>
            <HfhFilterGroup class="mt-8 w-full"></HfhFilterGroup>
            <div class="mt-16 w-full">
                <LoadingIndicator v-if="loading" class="mx-auto" />
                <Results v-else :results="results"></Results>
            </div>
        </div>
    </main>
    <footer>
        <HfhFooter>
            <template #tagline
                ><p>
                    wissenschaftsbasiert, praxisorientiert, breit verankert
                </p></template
            >
            <template #contact-address
                ><p>
                    Schaffhauserstrasse 239<br />Postfach 5850<br />CH-8050
                    Zürich
                </p></template
            >
            <template #contact-other>
                <p>T +41 44 317 11 11</p>
                <p><a href="mailto:info@hfh.ch">info@hfh.ch</a></p>
            </template>
            <template #socials>
                <HfhSocialBlock
                    icon="facebook"
                    href="https://www.facebook.com/hfh.edu"
                />
                <HfhSocialBlock
                    icon="youtube"
                    href="https://www.youtube.com/user/hfhzuerich"
                />
                <HfhSocialBlock
                    icon="linkedin"
                    href="https://www.linkedin.com/company/hfh.edu"
                />
                <HfhSocialBlock
                    icon="instagram"
                    href="https://www.instagram.com/hfh_edu/"
                />
                <HfhSocialBlock
                    icon="twitter"
                    href="https://twitter.com/hfh_edu"
                />
                <HfhSocialBlock
                    icon="issuu"
                    href="https://issuu.com/hochschule_fuer_heilpaedagogik"
                />
            </template>
            <template #copyright
                >© Copyright {{ new Date().getFullYear() }} HfH</template
            >
        </HfhFooter>
    </footer>
</template>

<script setup lang="ts">
import {
    HfhFilterGroup,
    HfhHeaderBar,
    HfhLogo,
    HfhMenu,
    HfhFooter,
} from "@hfh-dlc/hfh-styleguide";
import Search from "../Components/Search.vue";
import LoadingIndicator from "../Components/LoadingIndicator.vue";
import Results from "../Components/Results.vue";
import { ref } from "vue";
import type { ResultData } from "../types";
import { HfhSocialBlock } from "@hfh-dlc/hfh-styleguide";

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
            imageSrc: "images/Rollgestelle_mit_Beschriftung.png",
            imageAlt: "",
        },
    },
    {
        mainCategory: "Sprache",
        signatureAndTopic: "1.1.3.1 Grafomotorik",
        mediaType: "Buch",
        location: {
            label: "Rollgestell Nr.1",
            imageSrc: "images/Rollgestelle_mit_Beschriftung.png",
            imageAlt: "",
        },
    },
];
</script>

<style scoped></style>
