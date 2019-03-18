<template>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                        <h2 class="">Wishlist Items</h2>
                        <button @click="buyAllSelected()" class="btn btn-success btn-sm " style="padding:12px" :disabled="selected.length == 0">
                            Buy All Selected
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
                                    <input type="checkbox" v-model="selectAll" @click="select"/>
                                </th>
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
                                    <input type="checkbox" v-model="selected" :value="wishlistitem.id" v-if="!wishlistitem.bought"/>
                                </td>
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
                                    <button @click="buyWishlistItem(index)" v-if="!wishlistitem.bought" class="btn btn-success btn-xs" style="padding:8px">Buy</span></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                   </div>
               </div>
           </div>
       </div>

       

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
                selected: [],
                selectAll: false
            }
        },
       mounted() {
           this.readWishlistItems();
       },
       methods: {
            buyWishlistItem(index)
            {
                let conf = confirm("Do you ready want to buy this wishlist item?");
                if (conf === true) {

                    axios.post('/invitee/wishlistitem/buyitem', {
                        item: this.wishlistitems[index]
                    })
                    .then(response => {
                        this.wishlistitems[index].bought = true;
                    })
                    .catch(error => {
                        
                    });
                }
            },
            readWishlistItems()
            {
                axios.get('/invitee/wishlist/' + window.location.pathname.split("/").pop() + '/items')
                    .then(response => {

                        this.wishlistitems = response.data.wishlistitems;
                        this.wishlist_id = response.data.wishlist_id;
                    });
            },
            goToHome()
            {
                window.location.href = '/home';
            },
            select()
            {
                this.selected = [];

                if (!this.selectAll) {
                    for (let i in this.wishlistitems) {
                        if(!this.wishlistitems[i].bought){
                            this.selected.push(this.wishlistitems[i].id);
                        }
                        
                    }
                }
            },
            buyAllSelected()
            {
                let conf = confirm("Do you ready want to buy selected wishlist items?");
                if (conf === true)
                {
                    axios.post('/invitee/wishlistitem/buyitems', {
                        items: this.selected
                    })
                    .then(response => {
                        for(i in this.selected)
                        {
                            this.wishlistitems[i].bought = true;
                        }
                    })
                    .catch(error => {
                        
                    });
                }
            }
       }
   }
</script>