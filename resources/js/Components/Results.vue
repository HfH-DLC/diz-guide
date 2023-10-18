<template>
    <div v-if="results.length > 0">
        <h2 aria-live="polite" class="text-xl mb-4" ref="results">
            <strong class="font-bold">{{ results.length }}</strong>
            Resultate
        </h2>
        <div>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Hauptkategorie</th>
                        <th>Signatur und Fachliches Thema</th>
                        <th>Medienart</th>
                        <th>Aufbewahrungsort</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="result in results">
                        <td>{{ result.mainCategory }}</td>
                        <td>{{ result.signatureAndTopic }}</td>
                        <td>{{ result.mediaType }}</td>
                        <td>
                            <button
                                class="text-thunderbird-red font-bold hover:underline"
                                @click="openDialog(result)"
                            >
                                {{ result.location.label }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div v-else class="flex-1 flex items-center justify-center text-xl">
        Für Ihre Suche wurden leider keine passenden Resultate gefunden.
    </div>
    <dialog ref="dialog" class="p-4">
        <h2>{{ selectedLocation?.label }}</h2>
    </dialog>
</template>

<script setup lang="ts">
import { PropType, Ref, ref } from "vue";
import type { LocationData, ResultData } from "../types";

const props = defineProps({
    results: {
        type: Array as PropType<Array<ResultData>>,
    },
});

const dialog = ref();

const selectedLocation: Ref<LocationData | undefined> = ref();

const openDialog = (result: ResultData) => {
    selectedLocation.value = result.location;
    dialog.value.showModal();
};
</script>

<style scoped>
td,
th {
    border: 1px solid black;
    padding: 0.5rem;
    @apply text-base;
}

th {
    @apply font-bold text-left;
}
</style>
