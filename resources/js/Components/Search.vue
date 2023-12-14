<template>
    <form @submit.prevent="search" class="relative w-full max-w-[60ch]">
        <div>
            <HfhInput
                v-model="inputValue"
                id="search"
                type="search"
                placeholder="Suchbegriff"
                :label="label"
            />
            <div class="mt-8 flex flex-wrap gap-x-8 gap-y-4">
                <HfhButton type="submit" icon="search">Suchen</HfhButton>
                <HfhButton :primary="false" @click="reset"
                    >Zurücksetzen</HfhButton
                >
            </div>
        </div>
    </form>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { ref, watch } from "vue";
const emit = defineEmits(["search", "reset"]);
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

const reset = () => {
    emit("reset");
};
</script>

<style scoped></style>
