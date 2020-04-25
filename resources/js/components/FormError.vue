<template>
    <span class="help-block error">
        <slot></slot>
    </span>
</template>

<script>
	export default {
		props: ['errors'],
	}
</script>