<template>
    <div>
        <ul id="status" class="nav nav-pills nav-justified">
            <li v-if="isLoading"></li>
            <li v-else v-for="item in items" v-bind:class="{ active: current == item.id}">
                <a v-on:click.prevent="getTickets(item.id)" href="#">
                    <span style="font-size: 20px">{{ item.count }}</span> <br>
                    {{ item.name }}
                </a>
            </li>
            <li>
                <a v-on:click.prevent="newTicket()" href="">Create<br>Ticket</a>
            </li>
        </ul>

        <template v-if="isNewTicket">
            <ticket-create></ticket-create>
        </template>

        <table class="table table-responsive table-bordered datagrid">
            <thead>
            <tr>
                <th>ID</th>
                <th>Summary</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="record in records.data">
                <td>{{ record.id }}</td>
                <td>
                    <div v-on:click="getDetails(record)">
                        {{ record.summary }}
                    </div>
                    <div class="row" v-if="row == record.id" style="margin-top: 10px">
                        <div class="col-md-6">
                            <h2>Contact</h2>
                            <div v-if="isContactSaved" class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <strong>Success!</strong> The contact was saved successfully.
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>Company</label>
                                    <input v-model="company" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input v-model="name" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name</label>
                                    <input v-model="lastName" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email 1</label>
                                    <input v-model="email1" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email 2</label>
                                    <input v-model="email2" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone 1</label>
                                    <input v-model="phone1" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone 2</label>
                                    <input v-model="phone2" type="text" class="form-control"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-default">Cancel</button>
                                    <button v-on:click="setContact(record.contact)" class="btn btn-primary">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2>Details</h2>
                            <div v-html="record.description"></div>
                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    Status <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a v-on:click.prevent="changeStatus(record.id, 6)" href="#">New</a></li>
                                    <li><a v-on:click.prevent="changeStatus(record.id, 7)" href="#">Pending</a></li>
                                    <li><a v-on:click.prevent="changeStatus(record.id, 8)" href="#">Closed</a></li>
                                    <li><a v-on:click.prevent="changeStatus(record.id, 9)" href="#">Trash</a></li>
                                    <li><a v-on:click.prevent="changeStatus(record.id, 10)" href="#">Sale</a></li>
                                </ul>
                            </div>
                            <h2>Notes</h2>
                            <template v-for="comment in comments.data">
                                <div class="note">
                                    <p>{{ comment.message }}</p>
                                    <label class="author">{{ comment.user.name + ' ' + comment.user.lastName }}</label>
                                    <label class="date pull-right">{{ comment.created_at }}</label>
                                </div>
                            </template>
                            <form v-on:submit.prevent="addComment(record.id)" method="post">
                                <div class="form-group">
                                    <textarea v-model="comment" class="form-control"
                                              placeholder="new note..."></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <label class="pull-right">
                                        <input v-model="sendEmail" type="checkbox"/> Send email to contact
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isLoading: true,
                items: [],
                current: 6,
                records: [],
                row: 0,
                isContactSaved: false,
                company: '',
                name: '',
                lastName: '',
                email1: '',
                email2: '',
                phone1: '',
                phone2: '',
                comments: [],
                comment: '',
                sendEmail: false,
                isNewTicket: false,
            }
        },
        props: ['user_id'],
        mounted() {
            this.getPipeline();
            this.getTickets(this.current);
        },
        methods: {
            getDetails(record) {
                this.row = record.id;
                this.company = record.contact.company;
                this.name = record.contact.name;
                this.lastName = record.contact.lastname;
                this.email1 = record.contact.email1;
                this.email2 = record.contact.email2;
                this.phone1 = record.contact.phone1;
                this.phone2 = record.contact.phone2;

                this.getComments(record.id);
            },
            getPipeline() {
                self = this;
                axios.get('/api/status')
                    .then(function (response) {
                        self.items = response.data
                    });
            },
            setContact(contact) {
                self = this;
                axios.post('/api/contacts/' + contact.id, {
                    company: self.company,
                    name: self.name,
                    lastname: self.lastName,
                    email1: self.email1,
                    email2: self.email2,
                    phone1: self.phone1,
                    phone2: self.phone2,
                }).then(function (response) {
                    self.isContactSaved = true;
                })
            },
            getTickets(status) {
                self = this;
                self.isLoading = true;
                axios.get('/api/tickets/' + status)
                    .then(function (response) {
                        self.records = response.data;
                        self.current = status;
                        self.isLoading = false;
                    });
            },
            changeStatus(ticket, status) {
                this.isLoading = true;
                self = this;
                axios.post('/api/ticket/' + ticket + '/status/' + status)
                    .then(function (response) {
                        self.getPipeline();
                        self.getTickets(self.current);
                    })
            },
            getComments(ticket) {
                self = this;
                //self.isLoading = true;
                axios.get('/api/ticket/' + ticket + '/comments')
                    .then(function (response) {
                        self.comments = response.data;
                        //self.isLoading = false;
                    });
            },
            addComment(ticket) {
                //this.isLoading = true;
                self = this;
                axios.post('/api/ticket/' + ticket + '/comment', {
                    message: self.comment,
                    user_id: self.user_id,
                    issue_id: ticket,
                    email: self.sendEmail
                }).then(function () {
                    self.comment = '';
                    self.sendEmail = false;
                    self.getComments(ticket);
                })
            },
            newTicket() {
                this.isNewTicket = true;
            }
        }
    }
</script>