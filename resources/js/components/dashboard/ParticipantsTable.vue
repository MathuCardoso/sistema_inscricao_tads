<script setup>
import { router } from "@inertiajs/vue3";
import Trash from "@/components/icons/Trash.vue";
import Pen from "@/components/icons/Pen.vue";

const props = defineProps({
    participants: {
        type: Object,
        required: true,
    },
    activities: {
        type: Array,
        required: true,
    },
    registrations: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(["toggle-presence", "edit"]);

function getRegistration(participant, activity) {
    return props.registrations.find(
        (registration) =>
            registration.participant_id == participant.id &&
            registration.activity_id == activity.id,
    );
}

function isPresent(participant, activity) {
    return getRegistration(participant, activity)?.presence ?? false;
}

function changePresence(participant, activity) {
    const registration = getRegistration(participant, activity);

    if (registration) {
        emit("toggle-presence", registration);
    }
}

function goToPage(link) {
    if (!link.url) return;

    router.get(link.url, {}, {
        preserveState: true,
        preserveScroll: true,
    });
}
</script>

<template>
    <div class="table-card">
        <div class="table-header">
            <div>
                <h2>Participantes cadastrados</h2>
                <p>
                    {{ participants.total }}
                    participante(s) cadastrado(s)
                </p>
            </div>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th
                            v-for="activity in activities"
                            :key="activity.id"
                        >
                            {{ activity.activity_type }}
                        </th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="participant in participants.data"
                        :key="participant.id"
                    >
                        <td class="name-cell">{{ participant.id }}</td>

                        <td class="name-cell">
                            {{ participant.name.toUpperCase() }}
                        </td>

                        <td>{{ participant.email }}</td>
                        <td>{{ participant.cpf }}</td>
                        <td>{{ participant.phone }}</td>

                        <td
                            v-for="activity in activities"
                            :key="activity.id"
                            class="attendance-cell"
                        >
                            <label
                                v-if="getRegistration(participant, activity)"
                                class="attendance-checkbox"
                            >
                                <input
                                    type="checkbox"
                                    :checked="isPresent(participant, activity)"
                                    @change="changePresence(participant, activity)"
                                />
                                <span class="checkmark"></span>
                            </label>
                        </td>

                        <td class="attendance-cell">
                            <div class="actions">
                                <button
                                    type="button"
                                    class="action-button"
                                    title="Editar participante"
                                    @click="emit('edit', participant)"
                                >
                                    <Pen />
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr v-if="participants.data.length === 0">
                        <td
                            :colspan="6 + activities.length"
                            class="empty-state"
                        >
                            Nenhum participante encontrado.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="participants.links.length > 3" class="pagination">
            <button
                v-for="link in participants.links"
                :key="link.label"
                :disabled="!link.url"
                :class="{ active: link.active }"
                @click="goToPage(link)"
                v-html="link.label"
            />
        </div>
    </div>
</template>

<style scoped>
.table-card {
    overflow: hidden;
    border: 1px solid #e2e7e4;
    border-radius: 10px;
}

.table-header {
    padding: 22px 24px;
    border-bottom: 1px solid #e8ecea;
}

.table-header h2 {
    margin: 0;
    font-size: 1rem;
}

.table-header p {
    margin: 5px 0 0;
    color: #ed5e14;
    font-size: 0.85rem;
}

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9rem;
}

th,
td {
    padding: 15px 24px;
    text-align: left;
    border-bottom: 1px solid #edf0ef;
}

th {
    color: #ed5e14;
    font-size: 0.78rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

td {
    color: white;
}

.name-cell {
    color: white;
    font-weight: 600;
}

tbody tr:last-child td {
    border-bottom: none;
}

tbody tr:hover {
    background: #121212;
}

.empty-state {
    padding: 50px 24px;
    color: #7c8782;
    text-align: center;
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 5px;
    padding: 18px;
    border-top: 1px solid #e8ecea;
}

.pagination button {
    min-width: 34px;
    height: 34px;
    padding: 0 9px;
    border: 1px solid #d9dfdc;
    border-radius: 6px;
    background: #ffffff;
    color: #56615c;
    cursor: pointer;
}

.pagination button:hover:not(:disabled) {
    background: #f4f6f5;
}

.pagination button.active {
    border-color: #ed5e14;
    background: #ed5e14;
    color: #ffffff;
}

.pagination button:disabled {
    opacity: 0.45;
    cursor: default;
}

.actions {
    display: flex;
    gap: 12px;
}

.attendance-cell {
    text-align: center;
    vertical-align: middle;
}

.action-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    border: none;
    background: transparent;
    color: inherit;
    cursor: pointer;
}

.attendance-checkbox {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.attendance-checkbox input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.checkmark {
    width: 22px;
    height: 22px;
    border: 2px solid #cbd5e1;
    border-radius: 6px;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    transition:
        background-color 0.15s ease,
        border-color 0.15s ease,
        transform 0.1s ease;
}

.attendance-checkbox input:checked + .checkmark {
    background-color: #ed5e14;
    border-color: #ed5e14;
}

.attendance-checkbox input:checked + .checkmark::after {
    content: "";
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg) translate(-1px, -1px);
}

.attendance-checkbox:hover .checkmark {
    border-color: #ed5e14;
}

.attendance-checkbox:active .checkmark {
    transform: scale(0.9);
}

.attendance-checkbox input:focus-visible + .checkmark {
    outline: 3px solid rgba(163, 97, 22, 0.25);
    outline-offset: 2px;
}
</style>