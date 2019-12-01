<template>
    <nav class="navbar">
        <router-link class="navbar__brand" to="/">
        仮想本棚
        </router-link>
        <div class="navbar__menu">
            <div class="navbar__item">
                <button class="button">
                    <i class="icon ion-md-add"></i>
                    本棚に飾る
                </button>
            </div>
            <span class="navbar__item">
                username
            </span>
            <div class="navbar__item">
                <router-link class="button button--like" to="/login">
                Login / Register
                </router-link>
                <button @click="logout" class="button button--like">
                Logout
                </button>
            </div>        
        </div>
    </nav>
</template>

<script>
export default {
    methods: {
        async logout(){
            await this.$store.dispatch('auth/logout')
            this.$router.push('/login')
        }
    }
}
</script>