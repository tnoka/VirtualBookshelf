<template>
    <div
        v-if="product"
        class="product-detail"
        :class="{ 'product-detail--column': fullWidth }">
        <figure class="product-detail__pane product_detail__image" @click="fullWidth = ! fullWidth">
            <img :src="product.url">
            <figcaption>Posted by {{ product.owner.name }}</figcaption>
        </figure>
        <div class="product-detail__pane">
            <button class="button button--like" title="読みたい本">
                <i class="fa fa-heart"></i>12
            </button>
            <h2 class="product-detail__title">
                <i class="fab fa-rocketchat"></i>Comments
            </h2>
        </div>
    </div>
</template>

<script>
import { OK } from '../util'
export default {
    props: {
        id: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            product: null,
            fullWidth: false
        }
    },
    methods: {
        async fetchProduct() {
            const response = await axios.get(`/api/products/${this.id}`)

            if(response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.product = response.data
        }
    },
    watch: {
        $route: {
            async handler() {
                await this.fetchProduct()
            },
            immediate: true
        }
    }
}
</script>