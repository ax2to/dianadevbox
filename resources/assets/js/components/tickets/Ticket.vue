<template>
    <div v-if="display">
        <h2>Details</h2>
        <div v-html="description"></div>
        <!-- Single button -->
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                Status <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a v-on:click.prevent="changeStatus(id, 6)" href="#">New</a></li>
                <li><a v-on:click.prevent="changeStatus(id, 7)" href="#">Pending</a></li>
                <li><a v-on:click.prevent="changeStatus(id, 8)" href="#">Closed</a></li>
                <li><a v-on:click.prevent="changeStatus(id, 9)" href="#">Trash</a></li>
                <li><a v-on:click.prevent="changeStatus(id, 10)" href="#">Sale</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        mounted() {

        },
        data() {
            return {
                display: false,
                description: ''
            }
        },
        created() {
            let self = this;
            this.$root.$on('showTicket', function (id) {
                if (self.id === id) {
                    self.get();
                    self.display = true;
                }
            });
            this.$root.$on('getTickets', function () {
                self.display = false;
            });
        },
        methods: {
            get() {
                let self = this;
                let url = '/api/ticket/' + this.id;
                axios.get(url).then(function (response) {
                    self.description = response.data.description;
                });
            },
            changeStatus(ticket, status) {
                self = this;
                axios.post('/api/ticket/' + ticket + '/status/' + status)
                    .then(function () {
                        self.$root.$emit('changeStatus');
                    })
            }
        }
    }
</script>
