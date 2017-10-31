<template>
    <div>
        <div v-if="role_id == 1" class="row form-inline">
            <div class="form-group col-md-6">
                <label>User: </label>
                <select v-model="user" v-on:change="onChangeUser()" class="form-control">
                    <option value="all">All</option>
                    <option value="16">Karolay Pereyra</option>
                    <option value="18">Mariely Mendoza</option>
                    <option value="15">Rosana Toro</option>
                </select>
            </div>
        </div>
        <ul id="status" class="nav nav-pills nav-justified">
            <li v-if="isLoading">loading...</li>
            <li v-else v-for="item in items" v-bind:class="{ active: current == item.id}">
                <a v-on:click.prevent="changePipeline(item.id)" href="#">
                    <span style="font-size: 20px">{{ item.count }}</span><br>
                    {{ item.name }}
                </a>
            </li>
            <li>
                <a v-on:click.prevent="newTicket()" href="">Create<br>Ticket</a>
            </li>
        </ul>
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
            this.get();
        },
        data() {
            return {
                isLoading: true,
                user: 0,
                current: 6,
                items: []
            }
        },
        created() {
            let self = this;
            this.$root.$on('storeTicket', function () {
                self.get();
            });
            this.$root.$on('changeStatus', function () {

                self.get();
            });
        },
        methods: {
            get() {
                let self = this;
                let url = '/api/pipeline?user_id=' + this.user;
                axios.get(url)
                    .then(function (response) {
                        self.items = response.data;
                        self.isLoading = false;
                    });
            },
            changePipeline(id) {
                this.current = id;
                this.$root.$emit('changePipeline', this.user, this.current);
            },
            newTicket() {
                this.$root.$emit('newTicket');
            },
            onChangeUser() {
                this.get();
                this.$root.$emit('changePipeline', this.user, this.current);
            }
        }
    }
</script>
