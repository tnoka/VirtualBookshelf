<template>
    <div class="product">
        <figure class="product__wrapper">
            <img class="product__image product__image--portrait"
            :src="item.url" :alt="'Product by ${item.owner.name}'">
        </figure>
        
    </div>
</template>