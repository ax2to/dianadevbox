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
        props: ['user_id', 'role_id'],
        mounted() {
            if (this.role_id === "1") {
                this.user = 'all';
            } else {
                this.user = this.user_id;
            }
            this.get(6);
        },
        data() {
            return {
                isLoading: true,
                pipeline: 6,
                user: 0,
                items: []
            }
        },
        methods: {
            get(status) {
                let self = this;
                let url = '/api/tickets?user_id=' + this.user + '&status=' + status;
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
            this.$root.$on('changePipeline', function (user_id, id) {
                self.pipeline = id;
                self.user = user_id;
                self.get(self.pipeline);
            });
            this.$root.$on('changeStatus', function () {
                self.get(self.pipeline);
            });
        }
    }
</script>
