<template>
    <div>
        <h1>Neues fachliches Thema</h1>
        <form @submit.prevent="submit" class="mt-4 grid gap-y-4 max-w-[30rem]">
            <HfhInput
                label="Name"
                v-model="form.name"
                id="topic-name"
                required
            ></HfhInput>
            <HfhButton type="submit">Fachliches Thema erstellen</HfhButton>
        </form>
    </div>
</template>

<script setup lang="ts">
import { HfhButton, HfhInput } from "@hfh-dlc/hfh-styleguide";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
});

const submit = () => {
    form.post("/admin/topics");
};
</script>

<style lang="scss" scoped></style>
