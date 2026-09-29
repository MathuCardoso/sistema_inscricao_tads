<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    user: "",
    password: "",
    login: ""
});
</script>

<template>
    <main class="login-page">
        <section class="login-card">
            <div class="login-header">
                <span class="system-label">SEMANA ACADÊMICA</span>

                <h1>Área administrativa</h1>
                <span class="text-red-500" v-if="form.errors.login">
                    {{ form.errors.login }}
                </span>
            </div>

            <form class="login-form" @submit.prevent="form.post('/login')">
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input
                        id="usuario"
                        type="text"
                        v-model="form.user"
                    />
                    <span class="text-red-600" v-if="form.errors.user">
                        {{ form.errors.user }}
                    </span>
                </div>

                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input
                        id="senha"
                        type="password"
                        v-model="form.password"
                    />
                    <span class="text-red-600" v-if="form.errors.password">
                        {{ form.errors.password }}
                    </span>
                </div>

                <button type="submit" :disabled="form.processing">
                    Entrar
                </button>
            </form>
        </section>
    </main>
</template>

<style scoped>
.login-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: #161615;
}

.login-card {
    width: 100%;
    max-width: 420px;
    padding: 40px;
    background: #161615;
    border: 2px solid #e2e7e46f;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.06);
}

.login-header {
    margin-bottom: 32px;
}

.system-label {
    display: block;
    color: #ed5e14;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.08em;
}

h1 {
    margin: 0 0 10px;
    color: white;
    font-size: 1.8rem;
    font-weight: 700;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

label {
    color: #ed5e14;
    font-size: 0.9rem;
    font-weight: 600;
}

input {
    width: 100%;
    box-sizing: border-box;
    padding: 12px 14px;
    border: 2px solid #ed5e14;
    border-radius: 7px;
    outline: none;
    color: white;
    font-size: 0.95rem;
    transition:
        border-color 0.15s,
        box-shadow 0.15s;
}

input::placeholder {
    color: #525252;
}

input:focus {
    border-color: #ed5e14;
    box-shadow: 0 0 0 3px rgba(150, 56, 9, 0.541);
}

button {
    margin-top: 4px;
    padding: 12px;
    border: none;
    border-radius: 7px;
    background: #ed5e14;
    color: #ffffff;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s;
}

button:hover {
    background: #ed5c14b8;
}
</style>
