<template>
    <div>
        <div class="hfh-content">
            <h1>Kategorien</h1>
            <p>
                Wählen Sie Kategorien aus und klicken Sie auf Suchen. Unter
                Sprache hat es weitere Kategorien.
            </p>
        </div>
        <form
            @submit.prevent="search"
            class="bg-fantasy-light w-full pt-6 pb-6 pl-10 pr-5"
        >
            <div class="flex flex-wrap gap-x-12 gap-y-4">
                <div class="hfh-label flex-shrink-0">Suchen nach</div>
                <div class="flex flex-wrap gap-x-6 gap-y-4 flex-1">
                    <div class="flex-1">
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
                    <div class="flex-1">
                        <HfhCheckbox
                            id="media-type"
                            legend="Medienart"
                            :options="mediaTypeOptions"
                            v-model="filter.mediaTypeIds"
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
import type {
    CategoryData,
    CategoriesResource,
    ItemsResource,
    MediaTypesResource,
    NestedCheckboxOption,
    CheckboxOptionWithChildren,
} from "../types";
import { router } from "@inertiajs/vue3";
import TriStateCheckbox from "@/Components/TriStateCheckbox.vue";
import type { CheckboxOption } from "@hfh-dlc/hfh-styleguide/types";

const props = defineProps({
    itemsResource: {
        type: Object as PropType<ItemsResource>,
        required: true,
    },
    categoriesResource: {
        type: Object as PropType<CategoriesResource>,
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
    if (!categoryData.children || categoryData.children.length === 0) {
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
const mediaTypeIds = query.getAll("mediaTypeIds[]");
const categoryIds = query.getAll("categoryIds[]");

const filter = ref({
    categoryIds: categoryIds,
    mediaTypeIds:
        mediaTypeIds.length > 0
            ? mediaTypeIds
            : mediaTypeOptions.value.map((option) => option.value),
});

const displayResults = computed(
    () => mediaTypeIds.length > 0 || categoryIds.length > 0
);

const errors: Ref<Array<{ message: string }>> = ref([]);

const search = () => {
    errors.value = [];
    if (filter.value.categoryIds.length == 0) {
        errors.value.push({
            message: "Bitte wählen Sie mindestens eine Kategorie aus.",
        });
    }
    if (filter.value.mediaTypeIds.length == 0) {
        errors.value.push({
            message: "Bitte wählen Sie mindestens eine Medienart aus.",
        });
    }
    if (errors.value.length > 0) {
        return;
    }
    router.get("/kategoriesuche", filter.value, {
        preserveState: false,
        preserveScroll: true,
        replace: true,
    });
};

const reset = () => {
    router.get(
        "/kategoriesuche",
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

<style scoped></style>
