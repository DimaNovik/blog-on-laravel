<template>
    <div class="auth__form">
        <b-form
            @submit.prevent="onSubmit">
            <b-row>
                <b-col>
                    <b-form-group
                            id="fieldset-1"
                            label="Оберіть контору"
                            label-for="input-1"
                            v-if="isReg"
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
                            label-for="input-1"
                        v-if="isReg">
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
                <b-col  v-if="!isReg" align="center">
                    <b-button type="submit" variant="primary" >Увійти</b-button>
                </b-col>
                <b-col  align="center">
                    <b-button
                            type="button"
                            variant="primary"
                        @click="setRegStatus">Реєстрація</b-button>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>

    import { mapActions, mapGetters } from 'vuex';

    export default {
        name: "AuthForm",
        data() {
            return {
                formData: {
                    fio: '',
                    login: '',
                    password: '',
                    selectedGroup: null,
                },
                isReg: false,
            }
        },
        computed: {
          ...mapGetters('User', ['groups']),
            groupOptions() {
              return this.groups || []
            }
        },
        methods: {
            ...mapActions('User', ['getGroups', 'regUser', 'loginUser']),
            onSubmit() {
                console.log(this.csrf);
                let formLoginData = new FormData();
                formLoginData.append('login', this.formData.login);
                formLoginData.append('password', this.formData.password);
                formLoginData.append('_token', window.csrf_token);

                this.loginUser(formLoginData).then(()=> {
                    this.$router.push('/pages/calculator/main')
                })

            },
            setRegStatus() {

                if(!this.isReg) {
                    this.getGroups().then(()=> {
                        this.isReg = true
                    })
                } else {
                    let formRegData = new FormData();

                    formRegData.append('name', this.formData.fio);
                    formRegData.append('login', this.formData.login);
                    formRegData.append('password', this.formData.password);
                    formRegData.append('group_id', this.formData.selectedGroup);

                    this.regUser(formRegData).then((res)=> {
                        this.$router.push('calculator/main')
                    });
                }

            }
        },
        mounted() {
            console.log(document.querySelector('#token'));
        }
    }
</script>