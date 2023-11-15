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
                <Search
                    @search="setSearchText"
                    :searchText="searchText"
                ></Search>
            </div>
            <HfhFilterGroup
                class="mt-8 w-full"
                orientation="vertical"
                @reset="resetFilters"
            >
                <div>
                    <HfhCheckbox
                        id="category"
                        legend="Kategorie"
                        :options="categoryOptions"
                        v-model="filter.categoryIds"
                        orientation="vertical"
                    ></HfhCheckbox>
                </div>
                <div>
                    <HfhCheckbox
                        id="media-type"
                        legend="Medienart"
                        :options="mediaTypeOptions"
                        v-model="filter.mediaTypeIds"
                        orientation="vertical"
                    ></HfhCheckbox>
                    <HfhCheckbox
                        id="location"
                        legend="Aufbewahrungsort"
                        :options="locationOptions"
                        v-model="filter.locationIds"
                        orientation="vertical"
                    ></HfhCheckbox>
                </div>
            </HfhFilterGroup>
            <div class="mt-16 w-full">
                <LoadingIndicator v-if="loading" class="mx-auto" />
                <Results v-else :results="items"></Results>
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
    HfhCheckbox,
} from "@hfh-dlc/hfh-styleguide";
import Search from "../Components/Search.vue";
import LoadingIndicator from "../Components/LoadingIndicator.vue";
import Results from "../Components/Results.vue";
import { PropType, computed, ref, watch } from "vue";
import type {
    CategoriesResource,
    ItemsResource,
    LocationsResource,
    MediaTypesResource,
    SearchParams,
} from "../types";
import { HfhSocialBlock } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    itemsResource: {
        type: Object as PropType<ItemsResource>,
        required: true,
    },
    categoriesResource: {
        type: Object as PropType<CategoriesResource>,
        required: true,
    },
    locationsResource: {
        type: Object as PropType<LocationsResource>,
        required: true,
    },
    mediaTypesResource: {
        type: Object as PropType<MediaTypesResource>,
        required: true,
    },
});

const items = computed(() => props.itemsResource.data);

const categoryOptions = computed(() =>
    props.categoriesResource.data.map((categoryData) => {
        return {
            label: categoryData.name,
            name: `category-${categoryData.id}`,
            value: categoryData.id,
        };
    })
);

const locationOptions = computed(() =>
    props.locationsResource.data.map((locationData) => {
        return {
            label: locationData.name,
            name: `location-${locationData.id}`,
            value: locationData.id,
        };
    })
);

const mediaTypeOptions = computed(() =>
    props.mediaTypesResource.data.map((mediaTypeData) => {
        return {
            label: mediaTypeData.name,
            name: `media-type-${mediaTypeData.id}`,
            value: mediaTypeData.id,
        };
    })
);

const query = new URLSearchParams(window.location.search);

const searchText = ref(query.get("search") || "");

const filter = ref({
    categoryIds: query.getAll("categoryIds[]"),
    locationIds: query.getAll("locationIds[]"),
    mediaTypeIds: query.getAll("mediaTypeIds[]"),
});

const resetFilters = () => {
    filter.value.categoryIds = [];
    filter.value.locationIds = [];
    filter.value.mediaTypeIds = [];
};

const setSearchText = (value: string) => {
    searchText.value = value;
};

const searchParams = computed(() => {
    const params = { ...filter.value } as Record<string, string | string[]>;
    if (searchText.value) {
        params.search = searchText.value;
    }
    return params;
});

const search = () => {
    router.get("/", searchParams.value, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
};

watch(searchParams, search, { deep: true });

const menuItems = [
    {
        label: "Didaktisches Zentrum",
        link: {
            href: "https://www.hfh.ch/services/didaktisches-zentrum",
            target: "_blank",
        },
    },
    { label: "hfh.ch", link: { href: "https://hfh.ch", target: "_blank" } },
];

const loading = ref(false);
</script>

<style scoped></style>
