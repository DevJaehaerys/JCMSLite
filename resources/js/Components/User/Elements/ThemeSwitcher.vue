<template>
    <div>
        <div class="dropdown">
            <label tabIndex={0} class="btn m-1">Themes</label>

            <ul tabIndex={0} class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-32">
                <li
                    v-for="t in themes"
                    :key="t"
                    @click="handleThemeChange(t)"
                    :class="{'active': theme === t}"
                    class="theme-switcher-button"
                >
                    {{ t }}
                </li>
            </ul>
        </div>
        <div></div>
    </div>
</template>

<script>
import { reactive, toRefs, onMounted } from "vue";

export default {
    name: "ThemeSwitcher",
    setup() {
        const state = reactive({
            theme: localStorage.getItem("theme") || "halloween",
            themes: [
                "light",
                "dark",
                "cupcake",
                "bumblebee",
                "emerald",
                "corporate",
                "synthwave",
                "retro",
                "cyberpunk",
                "valentine",
                "halloween",
                "garden",
                "forest",
                "aqua",
                "lofi",
                "pastel",
                "fantasy",
                "wireframe",
                "black",
                "luxury",
                "dracula",
                "cmyk",
                "autumn",
                "business",
                "acid",
                "lemonade",
                "night",
                "coffee",
                "winter",
            ],
        });

        const handleThemeChange = (selectedTheme) => {
            console.log(selectedTheme);
            state.theme = selectedTheme;
            document.querySelector("html").setAttribute("data-theme", selectedTheme);
            localStorage.setItem("theme", selectedTheme);
        };

        onMounted(() => {
            document.querySelector("html").setAttribute("data-theme", state.theme);
            localStorage.setItem("theme", state.theme);
        });

        return { ...toRefs(state), handleThemeChange };
    },
};
</script>
