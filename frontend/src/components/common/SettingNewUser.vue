<template>
    <b-form
            @submit.prevent="onSubmit">
        <b-row>
            <b-col>
                <b-form-group
                        id="fieldset-1"
                        label="Оберіть контору"
                        label-for="input-1"
                >
                    <b-form-select
                            :options="groupOptions"
                            v-model="formData.selectedGroup">
                        <template v-slot:first>
                            <b-form-select-option :value="null" disabled>-- Оберіть контору --</b-form-select-option>
                        </template>

                    </b-form-select>
                </b-form-group>

                <b-form-group
                        id="input-group-1"
                        label="ФІО"
                        label-for="input-1">
                    <b-form-input
                            id="input-1"
                            v-model="formData.fio"
                            type="text"
                            required></b-form-input>
                </b-form-group>

                <b-form-group
                        id="input-group-2"
                        label="Логін"
                        label-for="input-2">
                    <b-form-input
                            id="input-1"
                            v-model="formData.login"
                            type="text"
                            required></b-form-input>
                </b-form-group>

                <b-form-group
                        id="input-group-3"
                        label="Пароль"
                        label-for="input-3">
                    <b-form-input
                            id="input-2"
                            v-model="formData.password"
                            type="password"
                            required></b-form-input>
                </b-form-group>
            </b-col>
        </b-row>


        <b-row class="mt-2">

            <b-col align="center">
                <b-button
                        type="submit"
                        variant="primary">Додати
                </b-button>
            </b-col>
        </b-row>

        <b-row v-if="hasError" class="mt-3">
            <b-col align="center">
                <p class="error">Логін вже існує в базі</p>
            </b-col>
        </b-row>

        <b-row v-if="isReg" class="mt-3">
            <b-col align="center">
                <p class="error">Користувач успішно доданий!</p>
            </b-col>
        </b-row>
    </b-form>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        name: "SettingNewUser",
        data() {
            return {
                formData: {
                    fio: null,
                    login: null,
                    password: null,
                    selectedGroup: null,
                },
                isReg: false,
                hasRegError: false
            }
        },
        computed: {
            ...mapGetters('User', ['groups']),
            groupOptions() {
                return this.groups || []
            }
        },
        methods: {
            ...mapActions('User', ['getGroups', 'regUser']),
            onSubmit() {
                this.isReg = false;
                this.hasRegError = false;
                let formRegData = new FormData();

                formRegData.append('name', this.formData.fio);
                formRegData.append('login', this.formData.login);
                formRegData.append('password', this.formData.password);
                formRegData.append('group_id', this.formData.selectedGroup);

                this.regUser(formRegData)
                    .then((res)=> {
                        this.isReg = true;
                    })
                    .catch(()=> {
                        this.hasRegError = true;
                    });

            }
        },
        mounted() {
            this.getGroups();
        }
    }
</script>