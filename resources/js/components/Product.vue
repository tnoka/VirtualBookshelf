<template>
    <div class="product">
        <figure class="product__wrapper">
            <img
            class="product__image"
            :class="imageClass"
            :src="item.url"
            :alt="`By ${item.owner.name}`"
            @load="setAspectRatio"
            ref="image"
            >
        </figure> 
        <router-link
        class="product__overlay"
        :to= "`/products/${item.id}`"
        :title="`View the Book by ${item.owner.name}`">
        <div class="product__controls">
            <button class="product__action product__action--like"
            title="読みたい本">
            <i class="fa fa-heart"></i>12
            </button>
        </div>
        <div class="product__username">
            {{  item.owner.name }}
        </div>
        </router-link>      
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