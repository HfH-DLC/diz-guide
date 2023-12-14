<template>
    <div class="flex items-center gap-x-1">
        <div
            :id="id"
            class="hfh-tri-state-checkbox-wrapper"
            role="checkbox"
            :aria-checked="ariaChecked"
            :aria-controls="ariaControls"
            tabindex="0"
            @click="toggle"
            @keydown.space="toggle"
        >
            <div
                class="hfh-tri-state-checkbox"
                :class="{
                    'hfh-tri-state-checkbox--mixed': isMixed,
                    'hfh-tri-state-checkbox--checked': isChecked,
                }"
            ></div>
            <span>{{ label }}</span>
        </div>
        <button
            type="button"
            :aria-expanded="displaySubCategories"
            :aria-controls="`${id}-options-list`"
            @click="toggleDisplaySubCategories"
        >
            <component
                :is="displaySubCategories ? ChevronDownIcon : ChevronRightIcon"
                class="w-5"
            ></component>
            <span class="hfh-sr-only">{{
                displaySubCategories
                    ? "Unterkategorien ausblenden"
                    : "Unterkategorien anzeigen"
            }}</span>
        </button>
    </div>
    <ul
        :id="`${id}-options-list`"
        class="checkboxes ml-9"
        :hidden="!displaySubCategories"
    >
        <li
            v-for="option in options"
            class="hfh-tri-state-checkbox-option flex items-start"
        >
            <div class="flex items-center min-h-[2rem]">
                <input
                    class="hfh-checkbox"
                    type="checkbox"
                    :id="getOptionId(option)"
                    :name="option.name"
                    :value="option.value"
                    :checked="model.includes(option.value)"
                    @change="
                     (event: Event) => setCheckboxValue((<HTMLInputElement>event.target).checked, option)
                "
                />
            </div>
            <label class="hfh-checkbox-label" :for="getOptionId(option)">{{
                option.label
            }}</label>
        </li>
    </ul>
</template>

<script setup lang="ts">
import { ChevronRightIcon, ChevronDownIcon } from "@heroicons/vue/24/outline";
import { PropType, computed, nextTick, ref } from "vue";
import type { CheckboxOption } from "@hfh-dlc/hfh-styleguide/types";

const emit = defineEmits(["update:modelValue"]);
const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
    options: {
        type: Array as PropType<Array<CheckboxOption>>,
        required: true,
    },
    modelValue: {
        type: Array<string>,
        default: () => [],
    },
});

const model = computed({
    get() {
        return props.modelValue;
    },
    set(newValue: Array<string>) {
        console.log("model.set", newValue);
        emit("update:modelValue", newValue);
    },
});

const isChecked = computed(() =>
    props.options.every((option) => model.value.includes(option.value))
);

const isMixed = computed(
    () =>
        !isChecked.value &&
        props.options.some((option) => model.value.includes(option.value))
);

const previousMixedValue = ref(isMixed.value ? props.modelValue : []);

const displaySubCategories = ref(isMixed.value);
const toggleDisplaySubCategories = () => {
    displaySubCategories.value = !displaySubCategories.value;
};

const getOptionId = (option: CheckboxOption) => {
    return `${props.id}-option-${option.name}`;
};

const ariaChecked = computed(() => {
    return isMixed.value ? "mixed" : isChecked ? "true" : "false";
});

const ariaControls = computed(() => {
    return props.options.map((option) => getOptionId(option)).join(" ");
});

const setCheckboxValue = (isChecked: boolean, option: CheckboxOption) => {
    if (isChecked) {
        model.value = [...model.value, option.value];
    } else {
        model.value = model.value.filter((id) => option.value !== id);
    }
    nextTick(() => {
        if (isMixed.value) {
            previousMixedValue.value = model.value;
        } else {
            previousMixedValue.value = [];
        }
    });
};

const toggle = () => {
    if (isChecked.value) {
        model.value = previousMixedValue.value;
    } else if (isMixed.value) {
        model.value = [];
    } else {
        model.value = props.options.map((option) => option.value);
    }
};
</script>

<style scoped lang="scss">
.hfh-tri-state-checkbox-option {
    display: flex;
    align-items: flex-start;
    column-gap: 1rem;
}

.hfh-tri-state-checkbox-wrapper {
    width: fit-content;
    display: flex;
    align-items: center;
    column-gap: 1rem;
    cursor: default;
}
.hfh-tri-state-checkbox {
    width: 1.25rem;
    height: 1.25rem;
    border: 0.125rem solid var(--c-fantasy-dark);
    background-color: var(--c-white);
}

.hfh-tri-state-checkbox--checked {
    background-color: var(--c-thunderbird-red);
    background-image: var(--i-checkmark);
    background-repeat: no-repeat;
    background-position: center;
    border-color: var(--c-thunderbird-red);
}

.hfh-tri-state-checkbox--mixed {
    background: linear-gradient(
        to bottom right,
        var(--c-thunderbird-red) 50%,
        rgba(0, 0, 0, 0) 50%
    );
    border-color: var(--c-thunderbird-red);
}
</style>
