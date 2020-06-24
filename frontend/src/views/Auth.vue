<template>
    <div class="page page--auth">
        <div class="auth">
            <b-container>
                <b-row align-h="center">
                    <b-col md="6">
                        <div class="auth__title">
                            <h4>Калькулятор додаткових платних послуг</h4>
                        </div>
                        <div class="auth__form">
                            <AuthForm
                                @changeComponent="setComponentName"></AuthForm>
                        </div>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>

    import AuthForm from "@/components/form/AuthForm";
    import {mapMutations} from 'vuex'

    export default {
        name: 'Auth',
        components: {
            AuthForm
        },
        methods: {
            ...mapMutations({
                setComponent: 'main/setCurrentComponent'
            }),
            setComponentName(name) {
                this.setComponent(name);
            }
        }
    }
</script>
