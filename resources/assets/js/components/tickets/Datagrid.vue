<template>
    <div>
        <div v-if="isLoading">loading...</div>
        <table v-else class="table table-responsive table-bordered datagrid">
            <thead>
            <tr>
                <th width="60px">ID</th>
                <th>Summary</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items">
                <td>{{ item.id }}</td>
                <td>
                    <div v-on:click="showTicket(item.id)">
                        {{ item.summary }}
                    </div>
                    <datagrid-row v-bind:id="item.id" v-bind:contact_id="item.contact_id" v-bind:user_id="user_id">
                    </datagrid-row>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['user_id'],
        mounted() {
            this.get(6);
        },
        data() {
            return {
                isLoading: true,
                pipeline: 6,
                items: []
            }
        },
        methods: {
            get(status) {
                let self = this;
                let url = '/api/tickets?user_id=' + this.user_id + '&status=' + status;
                axios.get(url)
                    .then(function (response) {
                        self.items = response.data;
                        self.isLoading = false;
                        self.$root.$emit('getTickets');
                    });
            },
            showTicket(id) {
                this.$root.$emit('showTicket', id);
            }
        },
        created() {
            let self = this;
            this.$root.$on('storeTicket', function () {
                self.get(self.pipeline);
            });
            this.$root.$on('changePipeline', function (id) {
                self.pipeline = id;
                self.get(self.pipeline);
            });
            this.$root.$on('changeStatus', function () {
                self.get(self.pipeline);
            });
        }
    }
</script>
