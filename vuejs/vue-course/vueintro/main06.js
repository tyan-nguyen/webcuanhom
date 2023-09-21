var app = new Vue({
	el: '#app',
	data: {
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
		image: "./assets/product.jpg",
		inStock: false,
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