<template>
   <div class="container">
       <div class="row">
           <div class="col-md-12">
               <div class="panel panel-default">
                   <div class="panel-heading">
                        <h2 class="">Wishlists</h2>
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
                wishlist: {
                    name: ''
                },
                errors: [],
                wishlists: []
            }
        },
       mounted() {
           this.readWishlists();
       },
       methods: {
            readWishlists()
            {
                axios.get('/invitee/wishlist')
                    .then(response => {

                        this.wishlists = response.data.wishlists;

                    });
            },
            viewWishlistItems(id)
            {
                window.location.href = '/invitee/wishlist/items/' + id;
            }
        }
   }
</script>