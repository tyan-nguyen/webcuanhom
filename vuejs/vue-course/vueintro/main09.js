Vue.component('product-detail',{
	props: {
		details: {
			type: Array,
			required: true
		}
	},
	template: `
		<ul>
			<li v-for="detail in details">{{ detail }}</li>
		</ul>
	`
});


Vue.component('product', {
	props: {
		premium: {
			type: Boolean,
			required: true
		}
	},
	template:`
		<div class="product">
			<div class="product-image">
				<img v-bind:src="image">
			</div>

			<div class="product-info">
				<h1 :style="{color: color}">{{ title }}</h1>
				<p :style="[styleObject1, styleObject2]" v-if="inStock">In Stock</p>
				<p v-else :class="{textDecoration: !inStock}">Out of Stock</p>

				<p>shipping: {{ shipping }}</p>

				<product-detail :details="details"></product-detail>

				<div v-for="(variant, index) in variants":key="variant.variantId" 
					class="color-box"
					:style="{ backgroundColor: variant.variantColor}"
					@mouseover="updateProduct(index)"
				>
				</div>

				<button @click="addToCart" 
					:disabled="!inStock"
					:class="{disabledButton: !inStock}"
				>Add to Cart</button>

				<button @click="removeToCart">Remove to Cart</button>

				


			</div>

		</div>	
	`,
	data(){
		return {
			brand: "Vue Masterful",
			product: "Socks",
			color: "red",
			fontSize: '18px',
			styleObject1: {
				color: 'red',
				fontSize: '100px',
			},
			styleObject2: {
				color: 'green',
				fontSize: '15px',
			},
			selectedVariant: 0,
			//inStock: false,
			details: ["80% cotton", "20% polyester", "Gender-newtral"],
			variants: [
				{
					variantId: 2234,
					variantColor: "green",
					variantImage: "./assets/product.jpg",
					variantQuantity: 10
				},
				{
					variantId: 2235,
					variantColor: "blue",
					variantImage: "./assets/product2.jpg",
					variantQuantity: 0
				}
			]
			
		}
	}, 
	methods: {
		addToCart(){
			this.$emit('add-to-cart')
		},
		removeToCart(){
			this.$emit('remove-to-cart')
		},
		updateProduct(index){
			this.selectedVariant = index
			console.log(index)
		}
	},
	computed: {
		title(){
			return this.brand + ' ' + this.product;
		},
		image(){
			return this.variants[this.selectedVariant].variantImage;
		},
		inStock(){
			return this.variants[this.selectedVariant].variantQuantity
		},
		shipping(){
			if(this.premium){
				return 'Free';
			}
			return 2.99
		}

	}
});
var app = new Vue({
	el: '#app',
	data:{
		premium: true,
		cart: 0
	},
	methods: {
		updateCart(){
			this.cart += 1;
		},
		removeCart(){
			this.cart -= 1;
		}
	}
});