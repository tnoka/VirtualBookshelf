<template>
    <div>
        <!-- <header>
            <Navbar />
        </header> -->
            <div class="container">
                <Message />
                <RouterView />
            </div>
            
        <p>Copyright ©2019 仮想本棚, All Rights Reserved.</p>
    </div>
</template>

<script>
import Message from './components/Message.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import { NOT_FOUND,UNAUTHORIZED,INTERNAL_SERVER_ERROR } from './util'

export default {
    components: {
        Message,
        Navbar,
        Footer,
    },
    computed: {
        errorCode() {
            return this.$store.state.error.code
        }
    },
    // 変更時の処理
    watch: {
        errorCode: {
            async handler(val) {
            if(val === INTERNAL_SERVER_ERROR) {
                this.$router.push('/500') // サーバーエラー対応
                } else if(val === UNAUTHORIZED) {
                    // トークンリフレッシュ
                    await axios.get('/api/refresh-token')
                    // ストアのUserをクリア
                    this.$store.commit('auth/setUser', null)
                    // ログイン画面へ
                    this.$router.push('/login')
                } else if(val === NOT_FOUND) {
                    this.$router.push('/not-found')
                }
            },
            immediate: true
        },
        $route() {
            this.$store.commit('error/setCode', null)
        }
    }
}
</script>