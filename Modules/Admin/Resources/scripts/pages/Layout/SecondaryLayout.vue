<template>
	<main class="strange-wrapper">
		<section class="main-section">
			<div class="image-view"></div> 
			<slot name="main-content" />
			<footer class="footer">
				<div class="container mx-auto px-4">
					<hr class="mb-6 border-b-1 border-gray-700">
					<div class="d-flex ml-3">
						<p>Copyright © The Techy Hub Sdn Bhd {{ new Date().getFullYear() }}</p>
					</div>
				</div>
			</footer>
		</section>
	</main>
</template>

<script>

	export default {
		components: { },
		mounted(){
			console.log("Mounted...");
		}
	}
</script>
