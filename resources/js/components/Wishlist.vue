<template>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                        <h2 class="">Wishlists</h2>
                        <button @click="initAddWishlist()" class="btn btn-success btn-sm " style="padding:12px">
                            Add New Wishlist
                        </button>
                   </div>
                   <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive w-100 d-block d-md-table" v-if="wishlists.length > 0">
                            <tbody>
                            <tr class="table-primary">
                                <th>
                                    Name
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <tr v-for="(wishlist, index) in wishlists">
                                <td>
                                    {{ wishlist.name }}
                                </td>
                                <td>
                                    <button @click="viewWishlistItems(wishlist.id)"  class="btn btn-primary btn-xs" style="padding:8px">View Items</span></button>
                                    <button @click="shareWishlist(index)" class="btn btn-success btn-xs" style="padding:8px">Share</span></button>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs" style="padding:8px">Edit</span></button>
                                    <button @click="deleteWishlist(index)" class="btn btn-danger btn-xs" style="padding:8px">Delete</span></button>
                                    
                                </td>
                            </tr>
                            </tbody>
                        </table>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal fade" tabindex="-1" role="dialog" id="add_wishlist_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Wishlist</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="names">Name:</label>
                            <input type="text" name="name" id="name" placeholder="Wishlist Name" class="form-control"
                                   v-model="wishlist.name">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createWishlist" class="btn btn-primary">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_wishlist_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Wishlist</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-danger" v-if="errors.length > 0">
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" placeholder="Wishlist Name" class="form-control"
                                   v-model="update_wishlist.name">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateWishlist" class="btn btn-primary">Update</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="share_wishlist_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Share Wishlist</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="names">Share Link:</label>
                            <input type="text" name="uuid" id="uuid" placeholder="Share Wishlist" class="form-control"
                                   v-bind:value="'http://localhost:8000/share/' + share_wishlist.uuid" readonly>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

   </div>
</template>
<script>
   export default {
       data(){
            return {
                wishlist: {
                    name: ''
                },
                errors: [],
                wishlists: [],
                update_wishlist: {},
                share_wishlist: {}
            }
        },
       mounted() {
           this.readWishlists();
       },
       methods: {
            deleteWishlist(index)
            {
                let conf = confirm("Do you ready want to delete this wishlist?");
                if (conf === true) {

                    axios.delete('/wishlist/' + this.wishlists[index].id)
                        .then(response => {

                            this.wishlists.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            },
            initAddWishlist()
            {
                $("#add_wishlist_modal").modal("show");
            },
            createWishlist()
            {
                axios.post('/wishlist', {
                    name: this.wishlist.name,
                })
                .then(response => {
                    console.log(response);
                    this.reset();

                    this.wishlists.push(response.data.wishlist);

                    $("#add_wishlist_modal").modal("hide");

                })
                .catch(error => {
                    this.errors = [];

                    if (error.response.data.errors && error.response.data.errors.name) {
                    
                        this.errors.push(error.response.data.errors.name[0]);
                    }
                    if (error.response.data.errors && error.response.data.errors.description)
                    {
                        this.errors.push(error.response.data.errors.description[0]);
                    }
                });
            },
            reset()
            {
                this.wishlist.name = '';
            },
            readWishlists()
            {
                axios.get('/wishlist')
                    .then(response => {

                        this.wishlists = response.data.wishlists;

                    });
            },
            initUpdate(index)
            {
                this.errors = [];
                $("#update_wishlist_modal").modal("show");
                this.update_wishlist = this.wishlists[index];
            },
            updateWishlist()
            {
                axios.patch('/wishlist/' + this.update_wishlist.id, {
                    name: this.update_wishlist.name,
                })
                    .then(response => {

                        $("#update_wishlist_modal").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];
                        if (error.response.data.errors.name) {
                            this.errors.push(error.response.data.errors.name[0]);
                        }

                        if (error.response.data.errors.description) {
                            this.errors.push(error.response.data.errors.description[0]);
                        }
                    });
            },
            viewWishlistItems(id)
            {
                window.location.href = '/wishlist/items/' + id;
            },
            shareWishlist(index)
            {
                $("#share_wishlist_modal").modal("show");
                this.share_wishlist = this.wishlists[index];
            },
        }
   }
</script>