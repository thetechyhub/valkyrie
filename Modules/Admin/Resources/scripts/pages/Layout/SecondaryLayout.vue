<template>
	<div class="auth-wrapper">
		<div class="auth-row">
			<div class="auth-col left-col order-2 order-md-1">
				<div class="auth-content not-form">
					<h2 class="fs-30 lp-25">Welcome to Valkyrie</h2>
				</div>
			</div>
			<div class="auth-col right-col order-1 order-md-2">
				<div class="auth-content form">
					<slot name="main-content" />	
				</div>
			</div>
		</div>
	</div>
</template>

<script>

	export default {
		components: { },
		mounted(){
			console.log("Mounted...");
		}
	}
</script>