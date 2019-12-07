<template>
    <div class="product-list">
        <div class="grid">
            <Product
            class="grid__item"
            v-for="product in products"
            :key="product.id"
            :item="product"
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