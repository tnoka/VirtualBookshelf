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
            <h3 class="product-detail__title">
                <i class="fab fa-rocketchat"></i> Comments
            </h3>
            <ul v-if="product.comments.length > 0" class="product-detail__comments">
                <li
                    v-for="comment in product.comments"
                    :key="comment.text"
                    class="product-detail__commentItem"
                >
                <p class="product-detail__commentBody">
                    {{ comment.text }}
                </p>
                <p class="product-detail__commentInfo">
                    {{ comment.author.name }}
                </p>
                </li>
            </ul>
            <p v-else>No comments yet.</p>
            <form v-if="isLogin" @submit.prevent="addComment" class="form">
                <div v-if="commentErrors" class="errors">
                    <ul v-if="commentErrors.text">
                        <li v-for="msg in commentErrors.text" :key="msg">{{ msg }}</li>
                    </ul>
                </div>
                <textarea class="form__item" v-model="commentText"></textarea>
                <div class="form__button">
                    <button type="submit" class="button button--inverse">submit comment</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { OK, CREATED, UNPROCESSABLE_ENTITY } from '../util'
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
            fullWidth: false,
            commentText: '',
            commentErrors: null,
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
        },
        async addComment() {
            const response = await axios.post(`/api/products/${this.id}/comments`, {
                text: this.commentText
            })

            // バリデーションエラー
            if (response.status === UNPROCESSABLE_ENTITY) {
                this.commentErrors = reponse.data.commentErrors
                return false
            }

            this.commentText = ''
            this.commentErrors = null

            if(response.status !== CREATED) {
                this.$store.commit('error/setCode', response.status)
                return false
            }

            // 投稿したコメントを表示させる
            this.$set(this.product, 'comments', [
                response.data,
                ...this.product.comments
            ])
        }
    },
    computed: {
        isLogin() {
            return this.$store.getters['auth/check']
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