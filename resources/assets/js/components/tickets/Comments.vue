<template>
    <div v-if="display">
        <h2>Notes</h2>
        <template v-for="comment in comments">
            <div class="note">
                <div v-html="comment.message"></div>
                <label class="author">{{ comment.user.name + ' ' + comment.user.lastName }}</label>
                <label class="date pull-right">{{ comment.created_at }}</label>
            </div>
        </template>
        <form v-on:submit.prevent="add(id)" method="post">
            <div class="form-group">
                <textarea v-model="comment" class="form-control" placeholder="new note..."></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Save</button>
                <label class="pull-right">
                    <input v-model="sendEmail" type="checkbox"/> Send email to contact
                </label>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props: ['id', 'user_id'],
        mounted() {
        },
        data() {
            return {
                display: false,
                sendEmail: false,
                comment: '',
                comments: []
            }
        },
        created() {
            let self = this;
            this.$root.$on('showTicket', function (id) {
                if (self.id === id) {
                    self.get(id);
                    self.display = true;
                }
            });
            this.$root.$on('getTickets', function () {
                self.display = false;
            });
        },
        methods: {
            get(ticket) {
                self = this;
                axios.get('/api/ticket/' + ticket + '/comments')
                    .then(function (response) {
                        self.comments = response.data;
                    });
            },
            add(ticket) {
                self = this;
                axios.post('/api/ticket/' + ticket + '/comment', {
                    message: self.comment,
                    user_id: self.user_id,
                    issue_id: ticket,
                    email: self.sendEmail
                }).then(function () {
                    self.comment = '';
                    self.sendEmail = false;
                    self.get(ticket);
                })
            },
            changeStatus(ticket, status) {
                let self = this;
                axios.post('/api/ticket/' + ticket + '/status/' + status)
                    .then(function () {
                        self.$root.$emit('changeStatus');
                    })
            },
        }
    }
</script>
