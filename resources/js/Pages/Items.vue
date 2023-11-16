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
                <h1 class="text-2xl mb-[3px]">DiZ-Guide</h1>
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
                    <fieldset>
                        <legend class="hfh-label">Kategorien</legend>
                        <div v-for="option in categoryOptions">
                            <TriStateCheckbox
                                v-if="hasCategoryChildren(option)"
                                :id="`${option.name}`"
                                :label="option.label"
                                :options="option.children"
                                :modelValue="getCategoriesChecked(option)"
                                @update:modelValue="
                                    (values) =>
                                        setCategoriesChecked(values, option)
                                "
                            >
                            </TriStateCheckbox>
                            <div class="flex items-center gap-x-4" v-else>
                                <input
                                    class="hfh-checkbox"
                                    type="checkbox"
                                    :name="option.name"
                                    :id="`${option.name}`"
                                    :checked="isCategoryChecked(option)"
                                    @change="
                                    (event: Event) => setCategoryChecked((<HTMLInputElement>event.target).checked, option)
                                "
                                />
                                <label
                                    class="hfh-checkbox-label"
                                    :for="`${option.name}`"
                                    >{{ option.label }}</label
                                >
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div>
                    <HfhCheckbox
                        id="media-type"
                        legend="Medienart"
                        :options="mediaTypeOptions"
                        v-model="filter.mediaTypeIds"
                        orientation="vertical"
                    ></HfhCheckbox>
                </div>
                <div>
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
    CategoryData,
    CategoriesResource,
    ItemsResource,
    LocationsResource,
    MediaTypesResource,
    NestedCheckboxOption,
    CheckboxOptionWithChildren,
} from "../types";
import { HfhSocialBlock } from "@hfh-dlc/hfh-styleguide";
import { router } from "@inertiajs/vue3";
import TriStateCheckbox from "@/Components/TriStateCheckbox.vue";
import { CheckboxOption } from "@hfh-dlc/hfh-styleguide/types/types";

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
    props.categoriesResource.data.map((categoryData) =>
        getCategoryOption(categoryData)
    )
);

const getCategoryOption = (
    categoryData: CategoryData
): NestedCheckboxOption => {
    if (categoryData.children.length === 0) {
        return {
            label: categoryData.name,
            name: `category-${categoryData.id}`,
            value: `${categoryData.id}`,
        };
    }
    return {
        label: categoryData.name,
        name: `category-${categoryData.id}`,
        value: `${categoryData.id}`,
        children: categoryData.children.map((childData) =>
            getCategoryOption(childData)
        ),
    };
};

const hasCategoryChildren = (
    option: NestedCheckboxOption
): option is CheckboxOptionWithChildren => {
    return "children" in option && option.children.length > 0;
};

const getCategoriesChecked = (option: CheckboxOptionWithChildren) => {
    return getCategoryIds(option).filter((id) =>
        filter.value.categoryIds.includes(id)
    );
};

const getCategoryIds = (option: NestedCheckboxOption) => {
    const result: Array<string> = [];
    if (hasCategoryChildren(option)) {
        option.children.forEach((child) => {
            result.push(...getCategoryIds(child));
        });
    } else {
        result.push(option.value);
    }
    return result;
};

const isCategoryChecked = (option: CheckboxOption) => {
    return filter.value.categoryIds.includes(option.value);
};

const setCategoriesChecked = (
    categoryIds: Array<string>,
    option: CheckboxOptionWithChildren
) => {
    const ids = getCategoryIds(option);
    filter.value.categoryIds = filter.value.categoryIds
        .filter((id) => !ids.includes(id) && id !== option.value)
        .concat(categoryIds);
    if (option.children.every((child) => categoryIds.includes(child.value))) {
        filter.value.categoryIds.push(option.value);
    }
};

const setCategoryChecked = (isChecked: boolean, option: CheckboxOption) => {
    if (isChecked) {
        filter.value.categoryIds.push(option.value);
    } else {
        filter.value.categoryIds = filter.value.categoryIds.filter(
            (id) => option.value !== id
        );
    }
};

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
