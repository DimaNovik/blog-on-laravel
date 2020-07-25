<template>
    <div class="page page--settings">
        <div class="settings">
            <b-container>
                <b-card no-body>
                    <b-tabs card>
                        <b-tab title="Tab 1" active>
                            <b-card-text>Tab contents 1</b-card-text>
                        </b-tab>
                        <b-tab title="Tab 2">
                            <b-card-text>Tab contents 2</b-card-text>
                        </b-tab>
                    </b-tabs>
                </b-card>
            </b-container>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Settings"
    }
</script>