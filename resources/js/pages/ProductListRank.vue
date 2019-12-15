<template>
        <div class="product-list">
            
            <div v-if="isLogin">
                <div  class="grid">
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

            <div v-else>
                <div  class="jumbotron jumbotron-extend home-header"  style="background: url(../img/main.jpg) no-repeat center center; background-size: cover;">
                    <div class="container-fluid jumbotron-container">
                        <h1 class="display-4 site-name text-light text-center mt-5 top-title" style="">仮想本棚</h1>
                        <h3 class="site-name text-light text-center mt-5 top-title">読んだ本を本棚に飾り</h3>
                        <h3 class="site-name text-light text-center top-title">おすすめの本を共有しよう</h3>
                    </div>
                </div>
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
            lastPage: 0,
        }
    },
    methods: {
        async fetchProducts() {
            const response = await axios.get(`/api/products/indexRank/?page=${this.$route.query.page}`)

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
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
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