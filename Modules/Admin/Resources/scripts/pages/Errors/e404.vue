<template>
	<error-layout>
		<template v-slot:code>
			404
		</template>
		<template v-slot:message>
			The page you are looking for is not found
		</template>
	</error-layout>
</template>

<script>
	export default {
		props: {},
		data: function(){
			return{

			}
		},
		mounted(){
			
		}
	}
</script>
