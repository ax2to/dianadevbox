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
        <nav>
            <ul class="pagination">
                <li v-for="i in pagination.last" v-bind:class="{ active: i === pagination.current}">
                    <a v-on:click.prevent="getPage(i)" href="#">{{ i }}</a>
                </li>
            </ul>
        </nav>
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
                items: [],
                pagination: {current: 1, last: 1, total: 15, per_page: 15, max: 6}
            }
        },
        methods: {
            get(status) {
                let self = this;
                let url = '/api/tickets?user_id=' + this.user + '&status=' + status + '&page=' + this.pagination.current;
                axios.get(url)
                    .then(function (response) {
                        self.items = response.data.data;
                        self.isLoading = false;
                        self.$root.$emit('getTickets');

                        self.pagination.current = response.data.current_page;
                        self.pagination.last = response.data.last_page;
                        self.pagination.total = response.data.total;
                        self.pagination.per_page = response.data.per_page;
                    });
            },
            showTicket(id) {
                this.$root.$emit('showTicket', id);
            },
            getPage(page) {
                this.pagination.current = page;
                this.get(this.pipeline);
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
                self.pagination.current = 1;
                self.get(self.pipeline);
            });
            this.$root.$on('changeStatus', function () {
                self.get(self.pipeline);
            });
        }
    }
</script>
