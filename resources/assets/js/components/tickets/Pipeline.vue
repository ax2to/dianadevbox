<template>
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
</template>

<script>
    export default {
        props: ['user_id'],
        mounted() {
            this.get();
        },
        data() {
            return {
                isLoading: true,
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
                let url = '/api/pipeline?user_id=' + this.user_id;
                axios.get(url)
                    .then(function (response) {
                        self.items = response.data;
                        self.isLoading = false;
                    });
            },
            changePipeline(id) {
                this.current = id;
                this.$root.$emit('changePipeline', this.current);
            },
            newTicket() {
                this.$root.$emit('newTicket');
            }
        }
    }
</script>
