<template>
    <nav>
        <div class="navbar">
            <div class="navbar-start">
                <a class="btn btn-ghost normal-case text-xl">JCMS Lite</a>
            </div>
            <div class="navbar-center hidden lg:flex">
                <ul class="menu menu-horizontal px-1">
                    <LinkList/>
                </ul>
            </div>
            <div class="block lg:hidden">
                <div class="navbar-start">
                    <div class="dropdown">
                        <label tabIndex={0} class="btn btn-ghost btn-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h7"/>
                            </svg>
                        </label>
                        <ul tabIndex={0}
                            class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                            <LinkList/>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="navbar-end z-50">
                <ThemeSwitcher/>
                <AuthDropdown v-if="$page.props.auth" :auth="auth"/>
                <a v-else href="/login/steam" class="btn">Auth</a>
            </div>
        </div>
    </nav>
</template>

<script>
import LinkList from "@/Components/User/Elements/LinkList.vue";
import ThemeSwitcher from "@/Components/User/Elements/ThemeSwitcher.vue";
import AuthDropdown from "@/Components/User/Elements/AuthDropdown.vue";

export default {
    name: "Navbar",
    components: {
        AuthDropdown,
        LinkList,
        ThemeSwitcher,
    },
    props: {
        auth: {
            type: Object,
            required: false,
        },
    },
}
</script>

<style scoped>

</style>
