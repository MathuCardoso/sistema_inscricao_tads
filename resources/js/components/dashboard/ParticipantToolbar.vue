<script setup>
defineProps({
    search: {
        type: String,
        default: "",
    },
});

const emit = defineEmits(["update:search", "create"]);
</script>

<template>
    <div class="toolbar">
        <div class="search-wrapper">
            <svg
                class="search-icon"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="11" cy="11" r="7" />
                <path d="m20 20-4-4" />
            </svg>

            <input
                :value="search"
                type="search"
                placeholder="Pesquisar participante..."
                @input="emit('update:search', $event.target.value)"
            />
        </div>

        <button type="button" class="primary-button" @click="emit('create')">
            <span>+</span>
            Novo participante
        </button>
    </div>
</template>

<style scoped>
.toolbar {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
}

.search-wrapper {
    position: relative;
    flex: 1;
}

.search-icon {
    position: absolute;
    top: 50%;
    left: 14px;
    width: 18px;
    height: 18px;
    color: #7c8782;
    transform: translateY(-50%);
}

.search-wrapper input {
    width: 100%;
    box-sizing: border-box;
    padding: 12px 14px 12px 42px;
    border: 1px solid #ccd5d1;
    border-radius: 7px;
    outline: none;
    font-size: 0.9rem;
}

.search-wrapper input:focus {
    border-color: #ed5e14;
    box-shadow: 0 0 0 3px rgba(8, 127, 91, 0.1);
}

.primary-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 11px 16px;
    border: none;
    border-radius: 7px;
    background: #ed5e14;
    color: #ffffff;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.primary-button:hover {
    background: #ed5e14;
}

.primary-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.primary-button span {
    font-size: 1.2rem;
    line-height: 1;
}
</style>