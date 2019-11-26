/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
// ルーティング
import router from './router'
// ルートコンポーネント（コンポーネントツリーの頂上）
import App from './App.vue'

new Vue({
    el: '#app',
    router, //ルーティングの定義を読み込む
    components: {
        App
    }, //ルートコンポーネントの使用を宣言
    template: '<App />' //ルートコンポーネントの描画
})