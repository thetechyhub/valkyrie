<template>
	<div>
		<main>
			<section class="nav-top">
				<!-- <navbar /> -->
			</section>
			<section class="main">
				<section class="main-left">
					<sidebar />
				</section>
				<section class="main-right">
					<!-- <slot name="main-content" /> -->
				</section>
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