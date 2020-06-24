<template>
    <div class="auth__form">
        <b-form
            @submit.prevent="onSubmit">
            <b-form-group
                id="input-group-1"
                label="Логін"
                label-for="input-1">
                <b-form-input
                    id="input-1"
                    v-model="formData.login"
                    type="text"
                    required></b-form-input>
            </b-form-group>
            <b-form-group
                    id="input-group-2"
                    label="Пароль"
                    label-for="input-2">
                <b-form-input
                        id="input-2"
                        v-model="formData.password"
                        type="password"
                        required></b-form-input>
            </b-form-group>

            <div class="auth__btn">
                <b-button type="submit" variant="primary">Увійти</b-button>
            </div>
        </b-form>
    </div>
</template>

<script>
    export default {
        name: "AuthForm",
        data() {
            return {
                formData: {
                    login: '',
                    password: ''
                }
            }
        },
        methods: {
            onSubmit() {
                this.$router.push('/pages/calculator/main')
            }
        }
    }
</script>