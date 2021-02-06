<template>
    <form action="#" @submit.prevent="updateUser">
        <b-row>
            <b-col md="6">
                <b-form-group
                        id="fieldset-1"
                        label="Оберіть користувача:"
                        label-for="input-1"
                >
                    <b-form-select
                            v-model="selectedUser"
                            :options="getAllUsersInfo"
                            value-field="id"
                            text-field="name"
                            @change="chooseUser(selectedUser)">
                    </b-form-select>
                </b-form-group>
            </b-col>
        </b-row>
        <b-row>
            <b-col md="6">
                <p>
                    <b-form-group
                            label="ПІБ"
                            label-for="name">
                        <b-form-input
                                id="name"
                                v-model="name"
                                type="text"
                                required></b-form-input>
                    </b-form-group>
                </p>
                <p>
                    <b-form-group
                            label="Логін"
                            label-for="login">
                        <b-form-input
                                id="login"
                                v-model="login"
                                type="text"
                                required></b-form-input>
                    </b-form-group>
                </p>
                <p>
                    <b-form-group
                            label="Новий пароль"
                            label-for="password">
                        <b-form-input
                                id="password"
                                v-model="password"
                                type="text"
                        ></b-form-input>
                    </b-form-group>
                    <b-form-input
                                id="password"
                                name="oldPassword"
                                v-model="oldPassword"
                                hidden
                    ></b-form-input>
                </p>
                <p>
                    <b-form-checkbox
                            id="checkbox-1"
                            v-model="role"
                            name="checkbox-1"
                            value="2"
                            unchecked-value="0"
                    >
                       Завідуючий конторою
                    </b-form-checkbox>
                </p>
            </b-col>
        </b-row>
        <b-row class="mt-3">
            <b-col>
                <b-button type="submit"
                          variant="primary">
                    Зберегти
                </b-button>
            </b-col>
        </b-row>
    </form>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    export default {
        name: "SettingUser",
        data() {
            return {
                selectedUser: null,
                name: null,
                login: null,
                password: null,
                oldPassword: null,
                role: 0,
            }
        },
        computed: {
            ...mapGetters('Orders', ['allUsers']),
            getAllUsersInfo() {
                return this.allUsers || {}
            },
        },
        methods: {
            ...mapActions('Orders', ['getAllUsers']),
            ...mapActions('User', ['onceUser', 'onceUserUpdate']),
            chooseUser(id) {
                this.onceUser(id).then((response)=> {
                    this.name = response.name;
                    this.login = response.login;
                    this.role = response.role;
                    this.oldPassword = response.password;
                });
            },
            updateUser(id) {
                let formData = new FormData();
                
                formData.append('name', this.name);
                formData.append('login', this.login);
                formData.append('role', this.role);
                formData.append('password', this.password);
                formData.append('old', this.oldPassword);
                
                this.onceUserUpdate({id: this.selectedUser, info: formData}).then(()=> {
                    this.getAllUsers();
                });

            }
        },
        mounted() {
            this.getAllUsers();
        }
    }
</script>