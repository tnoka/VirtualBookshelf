<template>
    <div class="product col-6 col-sm-4">
        <figure class="">
            <img
            class="img-fluid mb-4"
            :class="imageClass"
            :src="item.url"
            @load="setAspectRatio"
            ref="image"
            >
        </figure> 

        <a :href="'/products/'+item.id" class="product__overlay">
        <div class="product__controls">
            <button class="product__action product__action--favorite"
                    :class="{ 'product__action--favorited': item.favorited_by_user }"
                    title="読みたい本"
                    @click.prevent="favorite">
            <i class="fa fa-heart"></i>{{ item.favorite_count }}
            </button>
        </div>
        </a>
    </div>
</template>

<script>
export default {
    props: {
        item: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
        landscape: false,
        portrait: false
        }
    },
    computed: {
        imageClass () {
        return {
            // 横長クラス
            'product__image--landscape': this.landscape,
            // 縦長クラス
            'product__image--portrait': this.portrait
        }
        }
    },
    methods: {
        setAspectRatio () {
        if (! this.$refs.image) {
            return false
        }
        const height = this.$refs.image.clientHeight
        const width = this.$refs.image.clientWidth
        // 縦横比率 3:4 よりも横長の画像
        this.landscape = height / width <= 0.75
        // 横長でなければ縦長
        this.portrait = ! this.landscape
        },
        favorite() {
            this.$emit('favorite', {
                id: this.item.id,
                favorited: this.item.favorited_by_user
            })
        }
    },
    
    watch: {
        $route () {
        // ページが切り替わってから画像が読み込まれるまでの間に
        // 前のページの同じ位置にあった画像の表示が残ってしまうことを防ぐ
        this.landscape = false
        this.portrait = false
        }
    }
    }

</script>