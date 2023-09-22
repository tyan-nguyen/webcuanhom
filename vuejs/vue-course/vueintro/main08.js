var app = new Vue({
	el: '#app',
	data: {
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
		cart: 0
	},
	methods: {
		addToCart(){
			this.cart += 1
		},
		removeToCart(){
			this.cart -= 1;
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
		}

	}
});