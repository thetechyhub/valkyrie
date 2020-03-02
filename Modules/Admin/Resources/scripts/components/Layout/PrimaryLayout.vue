<template>
	<div>
		<navbar />
		<main class="logged-in">
			<section class="main-left">
				<sidebar />
			</section>
			<section class="main-right">
				<slot name="main-content" />
			</section>
		</main>
	</div>
</template>

<script>
	import Sidebar from './Partials/Sidebar';
	import Navbar from './Partials/Navbar';

	export default {
		components: {
			'sidebar': Sidebar,
			'navbar': Navbar
		},
		mounted(){
			console.log("Mounted...");
		}
	}
</script>