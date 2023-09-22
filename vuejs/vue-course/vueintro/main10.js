Vue.component('product-review', {
	template: `
		<form class="review-form" @submit.prevent="onSubmit">

		<p v-if="errors.length">
			<b>Please fixe following error(s):</b>
			<ul>
				<li v-for="error in errors">{{ error }}</li>
			</ul>
		</p>

		<p>
			<label for="name">Name:</label>
			<input v-model="name">
		</p>

		<p>
			<label for="review">Review:</label>
			<textarea id="review" v-model="review"></textarea>
		</p>

		<p>
			<label for="rating"></label>
			<select id="rating" v-model="rating">
				<option>5</option>
				<option>4</option>
				<option>3</option>
				<option>2</option>
				<option>1</option>
			</select>
		</p>

		<input type="submit">

		</form>
	`,
	data(){
		return {
			name: null,
			review: null,
			rating: null,
			errors: []
		}
	},
	methods: {
		onSubmit(){
			if(this.name && this.rating && this.review){
				let productReview = {
					name: this.name,
					review: this.review,
					rating: this.rating
				}
				this.$emit('review-submitted', productReview)
				this.name = null
				this.review = null
				this.rating = null
				this.errors = []
			} else {
				if(!this.name) this.errors.push('Name cannot be blank')
				if(!this.review) this.errors.push('Review cannot be blank')
				if(!this.rating) this.errors.push('Rating cannot be blank')
			}
			
		}
	}
})

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

			<div>
				<h2>Reviews</h2>
				<p v-if="!reviews.length">Chua co review. Hay la nguoi dau tien!</p>
				<ul>
					<li v-for="review in reviews">
						<p>{{ review.name }}</p>
						<p>{{ review.rating }}</p>
						<p>{{ review.review }}</p>
					</li>
				</ul>
			</div>

			<product-review @review-submitted="adReview"></product-review>

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
			],
			reviews: []
			
		}
	}, 
	methods: {
		addToCart(){
			this.$emit('add-to-cart', this.variants[this.selectedVariant].variantId)
		},
		removeToCart(){
			this.$emit('remove-to-cart', this.variants[this.selectedVariant].variantId)
		},
		updateProduct(index){
			this.selectedVariant = index
			console.log(index)
		},
		adReview(productReview){
			this.reviews.push(productReview)
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
		cart: []
	},
	methods: {
		updateCart(id){
			this.cart.push(id);
		},
		removeCart(id){
			$iIndex = this.cart.indexOf(id);
			if($iIndex > -1)
				this.cart.splice($iIndex, 1);
		}
	}
});