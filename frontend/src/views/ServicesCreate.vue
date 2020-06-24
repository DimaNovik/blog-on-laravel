<template>
    <div class="page page--create">
        <b-container>
            <div class="create mt-5">
                <CreateForm></CreateForm>
            </div>
        </b-container>
    </div>
</template>

<script>
    import CreateForm from '@/components/form/CreateServiceForm';
    import { mapActions} from 'vuex';

    export default {
        name: 'ServiceCreate',
        components: {
            CreateForm
        },
        methods: {
          ...mapActions({
              getNotaryActions: 'Calculator/getMainActions',
          })
        },
        created() {
            this.getNotaryActions();
        }
    }
</script>