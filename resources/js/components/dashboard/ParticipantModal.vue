<script setup>
import { vMaska } from "maska/vue";

defineProps({
    form: {
        type: Object,
        required: true,
    },
    activities: {
        type: Array,
        required: true,
    },
    editingParticipant: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(["close", "submit"]);
</script>

<template>
    <div
        class="modal-overlay"
        @click.self="emit('close')"
    >
        <div class="modal">
            <div class="modal-header">
                <div>
                    <h2>
                        {{
                            editingParticipant
                                ? "Editar participante"
                                : "Novo participante"
                        }}
                    </h2>

                    <p>
                        {{
                            editingParticipant
                                ? "Altere os dados do participante."
                                : "Cadastre uma pessoa no evento."
                        }}
                    </p>
                </div>

                <button
                    class="close-button"
                    type="button"
                    @click="emit('close')"
                >
                    ×
                </button>
            </div>

            <form @submit.prevent="emit('submit')">
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Nome</label>

                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Nome completo"
                            autocomplete="name"
                        />

                        <span v-if="form.errors.name" class="error">
                            {{ form.errors.name }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>

                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="participante@email.com"
                            autocomplete="email"
                        />

                        <span v-if="form.errors.email" class="error">
                            {{ form.errors.email }}
                        </span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cpf">CPF</label>

                        <input
                            id="cpf"
                            v-model="form.cpf"
                            type="text"
                            placeholder="000.000.000-00"
                            maxlength="14"
                            v-maska="'###.###.###-##'"
                        />

                        <span v-if="form.errors.cpf" class="error">
                            {{ form.errors.cpf }}
                        </span>
                    </div>

                    <div class="form-group">
                        <label for="phone">Telefone</label>

                        <input
                            id="phone"
                            v-model="form.phone"
                            type="text"
                            placeholder="(00) 00000-0000"
                            maxlength="15"
                            v-maska="'(##) #####-####'"
                        />
                    </div>
                </div>

                <div class="form-group">
                    <label>Atividades</label>

                    <div class="checkbox-group">
                        <label
                            v-for="activity in activities"
                            :key="activity.id"
                            class="checkbox-option"
                        >
                            <input
                                v-model="form.activity_ids"
                                type="checkbox"
                                :value="activity.id"
                            />

                            <div class="activity-info">
                                <span class="activity-type">
                                    {{ activity.activity_type.toUpperCase() }}
                                </span>

                                <span class="activity-description">
                                    {{ activity.description }}
                                </span>
                            </div>
                        </label>
                    </div>

                    <span v-if="form.errors.activity_ids" class="error">
                        {{ form.errors.activity_ids }}
                    </span>
                </div>

                <div class="modal-actions">
                    <button
                        type="submit"
                        class="primary-button"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing
                                ? editingParticipant
                                    ? "Salvando..."
                                    : "Cadastrando..."
                                : editingParticipant
                                  ? "Salvar alterações"
                                  : "Cadastrar participante"
                        }}
                    </button>

                    <button
                        type="button"
                        class="secondary-button"
                        @click="emit('close')"
                        :disabled="form.processing"
                    >
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 100;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(31, 31, 31, 0.45);
    backdrop-filter: blur(4px);
}

.modal {
    width: 100%;
    max-width: 660px;
    max-height: calc(100vh - 48px);
    overflow-y: auto;
    padding: 20px;
    border-radius: 12px;
    background: rgb(22, 22, 21);
    box-shadow: 0 20px 50px #29292965;
    border: 2px solid #ed5c14a3;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.3rem;
    color: #ed5e14;
}

.modal-header p {
    margin: 5px 0 0;
    color: #ffffff;
    font-size: 0.88rem;
}

.close-button {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 6px;
    color: white;
    background-color: #ed5e14;
    font-size: 1.3rem;
    cursor: pointer;
}

form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.form-group label {
    color: white;
    font-size: 0.85rem;
    font-weight: bold;
}

.form-group input {
    width: 100%;
    box-sizing: border-box;
    padding: 11px 13px;
    border: 1px solid #ed5e14;
    border-radius: 7px;
    outline: none;
    font-size: 0.9rem;
}

.form-group input:focus {
    border-color: #ed5e14;
    box-shadow: 0 0 0 3px rgba(127, 77, 8, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.error {
    color: #c0392b;
    font-size: 0.78rem;
}

.modal-actions {
    display: flex;
    gap: 10px;
    padding-top: 10px;
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
}

.primary-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.secondary-button {
    padding: 11px 16px;
    border: 1px solid #d1d8d4;
    border-radius: 7px;
    background: #ffffff;
    color: #4e5954;
    font-size: 0.9rem;
    font-weight: 600;
    cursor: pointer;
}

.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 8px;
}

.checkbox-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 14px;
    border: 1px solid #ed5e14;
    border-radius: 8px;
    cursor: pointer;
    transition:
        border-color 0.2s,
        background-color 0.2s ease;
}

.checkbox-option:hover {
    background-color: #332113;
}

.checkbox-option input {
    flex-shrink: 0;
    width: 18px;
    height: 18px;
    margin-top: 2px;
}

.activity-info {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.activity-type {
    font-weight: bold;
    color: white;
}

.activity-description {
    font-size: 0.9rem;
    color: rgb(175, 175, 175);
    line-height: 1.4;
}
</style>