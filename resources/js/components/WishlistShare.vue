<template>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                        <h2 class="">Wishlist Name: {{ wishlist_name }}</h2>
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
                                    <img v-bind:src="'/storage/' + wishlistitem.image" v-if="wishlistitem.image !== null" style="max-width: 50%;" />
                                </td>
                                <td>
                                    <a :href="wishlistitem.url" v-if="wishlistitem.url != ''" >{{ wishlistitem.url }}</a>
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
                wishlist_name: '',
                wishlistitems: []
            }
        },
       mounted() {
           this.readWishlistItems();
       },
       methods: {
            readWishlistItems()
            {
                console.log('/sharedetails/' + window.location.pathname.split("/").pop());
                axios.get('/sharedetails/' + window.location.pathname.split("/").pop())
                    .then(response => {

                        this.wishlistitems = response.data.wishlistitems;
                        this.wishlist_id = response.data.wishlist_id;
                        this.wishlist_name = response.data.wishlist_name;
                    });
            },
       }
   }
</script>