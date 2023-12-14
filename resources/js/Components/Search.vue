<template>
    <form @submit.prevent="search" class="relative w-full max-w-[60ch]">
        <div class="flex items-end gap-4">
            <HfhInput
                v-model="inputValue"
                id="search"
                type="search"
                placeholder="Suchbegriff"
                :label="label"
            />
            <HfhButton type="submit" icon="search" :animated="false"
                >Suchen</HfhButton
            >
        </div>
    </form>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { ref, watch } from "vue";
const emit = defineEmits(["search"]);
const props = defineProps({
    searchText: {
        type: String,
        default: "",
    },
    label: {
        type: String,
        required: true,
    },
});
const inputValue = ref(props.searchText);

watch(
    () => props.searchText,
    (newVal) => {
        inputValue.value = newVal;
    }
);

const search = () => {
    emit("search", inputValue.value);
};
</script>

<style scoped></style>
