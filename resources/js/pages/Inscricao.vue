<script setup>
import Toast from '@/components/ui/Toast.vue';
import { useForm } from "@inertiajs/vue3";
import { vMaska } from "maska/vue";
const props = defineProps({ activities: { type: Array, required: true } });
const form = useForm({
    name: "",
    email: "",
    cpf: "",
    phone: "",
    activity_ids: [],
});
function submit() {
    form.post("/inscricao", {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
}
</script>
<template>
    <Toast />
    <main class="page">
        <div class="container">
            <div class="header">
                <h1>Inscrição</h1>
                <p>
                    Preencha seus dados para se inscrever na Semana Acadêmica de
                    TADS.
                </p>
            </div>
            <form @submit.prevent="submit">
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
                        <span v-if="form.errors.phone" class="error">
                            {{ form.errors.phone }}
                        </span>
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
                                <span class="activity-time">
                                    {{ activity.start_time }} -
                                    {{ activity.end_time }}
                                </span>
                            </div>
                        </label>
                    </div>
                    <span v-if="form.errors.activity_ids" class="error">
                        {{ form.errors.activity_ids }}
                    </span>
                </div>
                <div class="form-actions">
                    <button
                        type="submit"
                        class="primary-button"
                        :disabled="form.processing"
                    >
                        {{
                            form.processing
                                ? "CARREGANDO..."
                                : "REALIZAR INSCRIÇÃO"
                        }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</template>
<style scoped>
.page {
    height: 100vh;
    padding: 40px 24px;
    box-sizing: border-box;
    background: #161615;
    color: white;
    display: flex;
    justify-content: center;
    align-items: center;
}
.container {
    width: 100%;
    max-width: 760px;
    margin: 0 auto;
    padding: 28px;
    box-sizing: border-box;
    border-radius: 12px;
}
.header {
    margin-bottom: 30px;
}
.header h1 {
    margin: 0;
    color: #ed5e14;
    font-size: 1.7rem;
    font-weight: bold;
}
.header p {
    margin: 7px 0 0;
    color: #ffffff;
    font-size: 0.9rem;
    line-height: 1.5;
}
form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.form-group > label {
    color: white;
    font-size: 1rem;
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
    box-shadow: 0 0 0 3px rgba(237, 94, 20, 0.1);
}
.error {
    color: #c0392b;
    font-size: 0.78rem;
}
.checkbox-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 2px;
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
    letter-spacing: 2px;
    color: white;
}
.activity-description {
    font-size: 0.9rem;
    color: rgb(175, 175, 175);
    line-height: 1.4;
}
.activity-time {
    margin-top: 3px;
    color: #ed5e14;
    font-size: 0.8rem;
    font-weight: 600;
}
.form-actions {
    display: flex;
    justify-content: flex-start;
    padding-top: 10px;
}
.primary-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 11px 18px;
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
@media (max-width: 650px) {
    .page {
        padding: 20px 12px;
    }
    .container {
        padding: 20px;
    }
    .form-row {
        grid-template-columns: 1fr;
    }
    .form-actions {
        justify-content: stretch;
    }
    .primary-button {
        width: 100%;
    }
}
</style>
