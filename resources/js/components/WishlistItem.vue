<template>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                        <h2 class="">Wishlist Items</h2>
                        <button @click="initAddWishlistItem()" class="btn btn-success btn-sm " style="padding:12px">
                            Add New Wishlist Item
                        </button>
                        <button @click="goToHome()" class="btn btn-primary btn-sm " style="padding:12px">
                            Go Back To Wishlists
                        </button>
                   </div>
                   <div class="panel-body">
                        <table class="table table-bordered table-striped table-responsive w-100 d-block d-md-table" v-if="wishlistitems.length > 0">
                            <tbody>
                            <tr class="table-primary">
                                <th>
                                    Name
                                </th>
                                <th>
                                    Description
                                </th>
                                <th>
                                    Price
                                </th>
                                <th>
                                    Image
                                </th>
                                <th>
                                    URL
                                </th>
                                <th>
                                    Action
                                </th>
                            </tr>
                            <tr v-for="(wishlistitem, index) in wishlistitems">
                                <td>
                                    {{ wishlistitem.name }}
                                </td>
                                <td>
                                    {{ wishlistitem.description }}
                                </td>
                                <td>
                                    {{ wishlistitem.price }} {{ wishlistitem.currency }}
                                </td>
                                <td>
                                    <img v-bind:src="'/storage/' + wishlistitem.image" v-if="wishlistitem.image != null || wishlistitem.image != undefined" style="max-width: 50%;" />
                                </td>
                                <td>
                                    <a :href="wishlistitem.url" v-if="wishlistitem.url != ''" >{{ wishlistitem.url }}</a>
                                </td>
                                <td>
                                    <button @click="initUpdate(index)" class="btn btn-success btn-xs" style="padding:8px">Edit</span></button>
                                    <button @click="deleteWishlistItem(index)" class="btn btn-danger btn-xs" style="padding:8px">Delete</span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                   </div>
               </div>
           </div>
       </div>

       <div class="modal fade" tabindex="-1" role="dialog" id="add_wishlistitem_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add New Wishlist Item</h4>
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
                            <input type="text" name="name" id="name" placeholder="Item Name" class="form-control"
                                   v-model="wishlistitem.name">
                        </div>

                        <div class="form-group">
                            <label for="description">Description:</label>
                            <input type="text" name="description" id="description" placeholder="Item Description" class="form-control"
                                   v-model="wishlistitem.description">
                        </div>

                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" name="price" id="price" placeholder="Item Price" class="form-control"
                                   v-model="wishlistitem.price">
                        </div>

                        <div class="form-group">
                            <label for="currency">Currency:</label>
                            <input type="text" name="currency" id="currency" placeholder="Item Currency" class="form-control"
                                   v-model="wishlistitem.currency">
                        </div>

                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" name="image" id="image" placeholder="Item Image" class="form-control"
                                @change="onFileChanged">
                        </div>

                        <div class="form-group">
                            <label for="url">URL:</label>
                            <input type="text" name="url" id="url" placeholder="Item URL" class="form-control"
                                   v-model="wishlistitem.url">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="createWishlistItem()" class="btn btn-primary">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="update_wishlistitem_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Update Wishlist Item</h4>
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
                            <input type="text" placeholder="Item Name" class="form-control"
                                   v-model="update_wishlistitem.name">
                        </div>

                        <div class="form-group">
                            <label>Description:</label>
                            <input type="text" placeholder="Item Description" class="form-control"
                                   v-model="update_wishlistitem.description">
                        </div>

                        <div class="form-group">
                            <label>Price:</label>
                            <input type="number" name="price" id="price" placeholder="Item Price" class="form-control"
                                   v-model="update_wishlistitem.price">
                        </div>

                        <div class="form-group">
                            <label>Currency:</label>
                            <input type="text" name="currency" id="currency" placeholder="Item Currency" class="form-control"
                                   v-model="update_wishlistitem.currency">
                        </div>

                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" name="image" id="image" placeholder="Item Image" class="form-control"
                                @change="onFileChanged">
                        </div>

                        <div class="form-group">
                            <label>URL:</label>
                            <input type="text" name="url" id="url" placeholder="Item URL" class="form-control"
                                   v-model="update_wishlistitem.url">
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" @click="updateWishlistItem()" class="btn btn-primary">Update</button>
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
                wishlistitem: {
                    name: '',
                    description: '',
                    price: 0,
                    currency: '',
                    image: '',
                    url: ''

                },
                wishlist_id: 0,
                selectedFile: null,
                errors: [],
                wishlistitems: [],
                update_wishlistitem: {}
            }
        },
       mounted() {
           this.readWishlistItems();
       },
       methods: {
           deleteWishlistItem(index)
            {
                let conf = confirm("Do you ready want to delete this wishlist item?");
                if (conf === true) {

                    axios.delete('/wishlistitem/' + this.wishlistitems[index].id)
                        .then(response => {

                            this.wishlistitems.splice(index, 1);

                        })
                        .catch(error => {

                        });
                }
            },
            initAddWishlistItem()
            {
                $("#add_wishlistitem_modal").modal("show");
            },
            createWishlistItem()
            {
                const formData = new FormData();
                formData.append('wishlist_id', this.wishlist_id);
                formData.append('name', this.wishlistitem.name);
                formData.append('description', this.wishlistitem.description);
                formData.append('price', this.wishlistitem.price);
                formData.append('currency', this.wishlistitem.currency);
                formData.append('url', this.wishlistitem.url);
                if(this.selectedFile !== null){
                    formData.append('image', this.selectedFile, this.selectedFile.name);
                }
                

                // axios.post('/wishlistitem', {
                //     wishlist_id: this.wishlist_id,
                //     name: this.wishlistitem.name,
                //     description: this.wishlistitem.description,
                //     price: this.wishlistitem.price,
                //     currency: this.wishlistitem.currency,
                //     url: this.wishlistitem.url,
                // })
                axios.post('/wishlistitem', formData)
                    .then(response => {

                        this.reset();

                        this.wishlistitems.push(response.data.wishlistitem);

                        $("#add_wishlistitem_modal").modal("hide");

                    })
                    .catch(error => {
                        this.errors = [];

                        if (error.response.data.errors && error.response.data.errors.name)
                        {
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
                this.wishlistitem.name = '';
                this.wishlistitem.description = '';
                this.wishlistitem.price = 0;
                this.wishlistitem.currency = '';
                this.wishlistitem.image = '';
                this.wishlistitem.url = '';
                this.selectedFile = null;
            },
            readWishlistItems()
            {
                axios.get('/wishlist/' + window.location.pathname.split("/").pop() + '/items')
                    .then(response => {

                        this.wishlistitems = response.data.wishlistitems;
                        this.wishlist_id = response.data.wishlist_id;
                    });
            },
            initUpdate(index)
            {
                this.errors = [];
                this.selectedFile = null;
                $("#update_wishlistitem_modal").modal("show");
                this.update_wishlistitem = this.wishlistitems[index];
            },
            updateWishlistItem()
            {
                const formData = new FormData();
                formData.append('name', this.update_wishlistitem.name);
                formData.append('description', this.update_wishlistitem.description);
                formData.append('price', this.update_wishlistitem.price);
                formData.append('currency', this.update_wishlistitem.currency);
                formData.append('url', this.update_wishlistitem.url);
                formData.append('_method', 'PATCH');
                if(this.selectedFile !== null){
                    formData.append('image', this.selectedFile, this.selectedFile.name);
                }

                for (var pair of formData.entries()) {
                    console.log(pair[0]+ ', ' + pair[1]); 
                }

                // axios.patch('/wishlistitem/' + this.update_wishlistitem.id, {
                //     name: this.update_wishlistitem.name,
                //     description: this.update_wishlistitem.description,
                //     price: this.update_wishlistitem.price,
                //     currency: this.update_wishlistitem.currency,
                //     url: this.update_wishlistitem.url,
                // })

                axios.post('/wishlistitem/' + this.update_wishlistitem.id, formData)
                .then(response => {

                    $("#update_wishlistitem_modal").modal("hide");
                    

                    const item = this.wishlistitems.find( item => item.id = response.data.wishlistitem.id );

                    this.wishlistitems[this.wishlistitems.indexOf(item)] = response.data.wishlistitem;
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
            onFileChanged (event) {
                this.selectedFile = event.target.files[0]
            },
            goToHome(){
                window.location.href = '/home';
            }
       }
   }
</script>