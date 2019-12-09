<template>
    <div class="product-list">
        <div class="grid">
            <Product
            class="grid__item"
            v-for="product in products"
            :key="product.id"
            :item="product"
            @like="onFavoriteClick"
            />
        </div>
        <Pagination :current-page="currentPage" :last-page="lastPage" />
    </div>
</template>


<script>
import Product from '../components/Product.vue'
import Pagination from '../components/Pagination.vue'
import { OK } from '../util'

export default {
    components: {
        Product,
        Pagination
    },
    data() {
        return {
            products: [],
            currentPage: 0,
            lastPage: 0
        }
    },
    methods: {
        async fetchProducts() {
            const response = await axios.get(`/api/products/?page=${this.$route.query.page}`)

            if(response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.products = response.data.data //resonse.dataでレスポンスのJSONを取得
            this.currentPage = response.data.current_page
            this.lastPage = response.data.last_page
        },
        onFavoriteClick({id, favorited}) {
            if(! this.$store.getters['auth/check']) {
                alert('読みたい本に追加する場合はログインしてください')
                return false
            }

            if(favorited) {
                this.unFavorite(id)
            } else {
                this.favorite(id)
            }
        },
        async favorite(id) {
            const response = await axios.put(`/api/products/${id}/favorite`)

            if(response.status !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.products = this.products.map(product => {
                if(product.id === response.data.product_id) {
                    product.favorite_count += 1
                    product.favorited_by_user = true
                }
                return product
            })
        },
        async unFavorite(id) {
            const response = await axios.delete(`/api/products/${id}/favorite`)

            if(response.data !== OK) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            this.product = this.product.map(product => {
                if(product.id === response.data.product_id) {
                    product.favorite_count -= 1
                    product.favorited_by_user = false
                }
                return product
            })
        }
    },
    watch: {
        $route: {
        async handler () {
            await this.fetchProducts()
        },
        immediate: true //コンポーネントが生成されたタイミングでも実行される
            }
        }
}
</script>