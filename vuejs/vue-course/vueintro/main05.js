var app = new Vue({
	el: '#app',
	data: {
		product: "Socks",
		image: "./assets/product.jpg",
		inStock: true,
		details: ["80% cotton", "20% polyester", "Gender-newtral"],
		variants: [
			{
				variantId: 2234,
				variantColor: "green",
				variantImage: "./assets/product.jpg"
			},
			{
				variantId: 2235,
				variantColor: "blue",
				variantImage: "./assets/product2.jpg"
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
		updateProduct(variantImage){
			this.image = variantImage
		}
	},
});