<template>
    <nav class="navbar">
        <router-link class="navbar__brand" to="/">
        仮想本棚
        </router-link>
        <div class="navbar__menu">
            <div v-if="isLogin" class="navbar__item">
                    <router-link class="button" to="/ProductForm">
                    <i class="fa fa-plus"></i>
                    本棚に飾る
                    </router-link>
                <button @click="logout" class="button">
                Logout
                </button>
                <span class="navbar__item">
                {{ username }}
                </span>
            </div>
            <div v-else class="navbar__item">
                <router-link class="button button--like" to="/login">
                Login / Register
                </router-link>
            </div>        
        </div>
    </nav>
</template>

<script>
import { mapState, mapGetters} from 'vuex'
import { OK } from '../util'

export default {
    computed: {
        ...mapState({
            apiStatus: state => stete.auth.apiStatus
        }),
        ...mapGetters({
            isLogin: 'auth/check',
            username: 'auth/username'
        })
    },
    methods: {
        async logout(){
            await this.$store.dispatch('auth/logout')
        
            if(this.apiStatus) {
            this.$router.push('/login')
            }
        },
        // async destroy(){
        //     const response = await axios.delete(`/api/users/${this.id}`)

        //     if(response.status !== OK) {
        //         this.$store.commit('error/setCode', response.status)
        //         return false
        //     }
        //     this.user = response.data
        //     this.$router.push('/login')
        // }
    },
}
</script>