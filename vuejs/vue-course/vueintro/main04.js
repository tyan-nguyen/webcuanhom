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
				variantColor: "green"
			},
			{
				variantId: 2235,
				variantColor: "blue"
			}
		]
	}
});