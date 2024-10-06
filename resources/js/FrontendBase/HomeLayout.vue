<script>
import HomeNavbar from "./HomeNavbar.vue";
import HomeFooter from "./HomeFooter.vue";

export default {
    name: "HomeLayout",
    components: {
        HomeFooter,
        HomeNavbar
    },
}
</script>

<template>
    <head>
        <title>Online Ticket</title>
    </head>
    <body>
    <div>
        <HomeNavbar />
        <slot/>
        <HomeFooter/>
    </div>
    </body>
</template>

<style scoped>

</style>
